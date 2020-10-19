<?php


namespace Modules\Admin\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Admin\Entities\Page;
use Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_fails_getting_list_of_pages_due_no_access_token()
    {
        $response = $this->getJson('/api/pages');

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertNotEmpty($jsonResponse['message']);
    }

    /** @test */
    public function it_fails_getting_paginator_for_pages_due_wrong_params()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/pages?sort=asc&sort_fields=name|id', ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sort', 'sort_fields']
            ]);
    }

    /** @test */
    public function it_fails_getting_paginator_due_wrong_type_of_request_params()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/pages?page=a&per_page=b', ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['page', 'per_page']
            ]);
    }

    /** @test */
    public function it_returns_list_of_pages_paginated()
    {
        $token = $this->generateJwtToken();
        factory(Page::class, 50)->create();

        $response = $this->getJson('/api/pages', ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data',
                'from',
                'to',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'last_page',
                'path',
                'per_page',
                'total'
            ]);

        $jsonResponse = $response->decodeResponseJson();

        $this->assertManyNotEmpty([
            'current_page', 'per_page', 'total',
            'current_page', 'from', 'to',
            'first_page_url', 'last_page_url'
        ], $jsonResponse);

        $this->assertEquals(1, $jsonResponse['current_page']);
        $this->assertEquals(1, $jsonResponse['from']);
        $this->assertCount(50, $jsonResponse['data']);
    }

    /** @test */
    public function it_test_getting_next_page_and_less_per_page_of_pages()
    {
        $token = $this->generateJwtToken();
        factory(Page::class, 50)->create();
        $per_page = 10;
        $page = 2;

        $response = $this->getJson("/api/pages?page=$page&per_page=$per_page", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk();

        $jsonResponse = $response->decodeResponseJson();
        $this->assertEquals(2, $jsonResponse['current_page']);
        $this->assertEquals($per_page+1, $jsonResponse['from']);
        $this->assertEquals($per_page*$page, $jsonResponse['to']);
        $this->assertCount(10, $jsonResponse['data']);
    }

    /** @test */
    public function it_test_searching_page_by_name()
    {
        $token = $this->generateJwtToken();
        factory(Page::class, 10)->create();
        $page = factory(Page::class)->create(['name' => 'test_page']);

        $response = $this->getJson("/api/pages?search=test_page", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data',
                'from',
                'to',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'last_page',
                'path',
                'per_page',
                'total'
            ]);

        $jsonResponse = $response->decodeResponseJson();

        $this->assertEquals(1, $jsonResponse['total']);
        $this->assertCount(1, $jsonResponse['data']);
        $this->assertEquals($page['name'], $jsonResponse['data'][0]['name']);
    }
}
