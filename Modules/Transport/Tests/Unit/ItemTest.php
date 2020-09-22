<?php


namespace Modules\Transport\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Transport\Entities\Item;
use Modules\Transport\Entities\Permit;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected $permit;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permit = factory(Permit::class)->create();
    }

    /** @test */
    public function it_fails_getting_list_of_permits_items_paginated_due_the_authentication()
    {

        $response = $this->getJson("/api/permits/{$this->permit->id}/items");

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertNotEmpty($jsonResponse['message']);
    }

    /** @test */
    public function it_fails_getting_list_of_permits_items_paginated_due_the_wrong_sort_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson("/api/permits/{$this->permit->id}/items?sort=asc&sort_fields=obsdate|gps_accu", [
            'Authorization' => "Bearer $token"
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sort', 'sort_fields']
            ]);
    }

    /** @test */
    public function it_fails_getting_list_of_permits_items_paginated_due_the_wrong_type_of_request_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson("/api/permits/{$this->permit->id}/items?page=a&per_page=b", [
            'Authorization' => "Bearer $token"
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['page', 'per_page']
            ]);
    }

    /** @test */
    public function it_returns_list_of_permits_paginated()
    {
        $token = $this->generateJwtToken();
        factory(Item::class, 50)->create();

        $response = $this->getJson("/api/permits/{$this->permit->id}/items", [
            'Authorization' => "Bearer $token"
        ]);

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
    public function it_test_getting_next_page_and_less_per_page_of_permit_items()
    {
        $token = $this->generateJwtToken();
        factory(Item::class, 50)->create();
        $per_page = 10;
        $page = 2;

        $response = $this->getJson("/api/permits/{$this->permit->id}/items?page=$page&per_page=$per_page", [
            'Authorization' => "Bearer $token"
        ]);

        $response
            ->assertOk();

        $jsonResponse = $response->decodeResponseJson();
        $this->assertEquals(2, $jsonResponse['current_page']);
        $this->assertEquals($per_page+1, $jsonResponse['from']);
        $this->assertEquals($per_page*$page, $jsonResponse['to']);
        $this->assertCount(10, $jsonResponse['data']);
    }

    /** @test */
    public function it_returns_the_field_list_for_permit_items_for_mobile_app()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson("/api/permit_items/mobile", ["Authorization" => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                '*' => ['f', 'fl', 'type']
            ]);
    }
}
