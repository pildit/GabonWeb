<?php


namespace Modules\Translation\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Translation\Entities\Language;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_gets_translation_dictionary()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/translation/dictionary', ['Authorization' => "Bearer {$token}"]);

        $response
            ->assertOk()
            ->assertJsonStructure(['text_en', 'text_fr']);

        $this->assertManyNotEmpty(['text_en', 'text_fr'], $response);
    }

    /** @test */
    public function it_fails_getting_translation_dictionary_due_authentication()
    {
        $response = $this->getJson('/api/translation/dictionary');

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $this->assertNotEmpty($response['message']);

    }

    /** @test */
    public function it_fails_getting_list_of_trans_keys_paginated_due_the_authentication()
    {
        $response = $this->getJson('/api/translation');

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertNotEmpty($jsonResponse['message']);
    }

    /** @test */
    public function it_fails_getting_list_of_trans_keys_paginated_due_the_wrong_sort_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/translation?sort=asc&sort_fields=text_key|text_en', ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sort', 'sort_fields']
            ]);
    }

    /** @test */
    public function it_fails_getting_list_of_trans_keys_paginated_due_the_wrong_type_of_request_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/translation?page=a&per_page=b', ['Authorization' => "Bearer $token"]);

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
        factory(Language::class, 50)->create();

        $response = $this->getJson('/api/translation', ['Authorization' => "Bearer $token"]);

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
}
