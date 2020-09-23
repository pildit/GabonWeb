<?php


namespace Modules\Translation\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Translation\Entities\Language;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

    /** @test */
    public function it_test_getting_next_page_and_less_per_page_of_trans_keys()
    {
        $token = $this->generateJwtToken();
        factory(Language::class, 50)->create();
        $per_page = 10;
        $page = 2;

        $response = $this->getJson("/api/translation?page=$page&per_page=$per_page", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk();

        $jsonResponse = $response->decodeResponseJson();
        $this->assertEquals(2, $jsonResponse['current_page']);
        $this->assertEquals($per_page+1, $jsonResponse['from']);
        $this->assertEquals($per_page*$page, $jsonResponse['to']);
        $this->assertCount(10, $jsonResponse['data']);
    }

    /** @test */
    public function it_returns_404_when_trans_key_with_id_does_not_exist()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/translation/1123123', ['Authorization' => "Bearer $token"]);

        $response
            ->assertNotFound()
            ->assertJsonStructure(['message']);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertNotEmpty($jsonResponse['message']);
    }

    /** @test */
    public function it_gets_a_single_trans_key_info_by_id()
    {
        $token = $this->generateJwtToken();

        $trans = factory(Language::class)->create();

        $response = $this->getJson("/api/translation/{$trans->id}", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ["text_us", "text_ga", "id", "text_key", "mobile"]
            ]);

        $jsonResponse = $response->decodeResponseJson()['data'];

        $this->assertMultipleEquals($trans, $jsonResponse, [
            "text_us", "text_ga", "id", "text_key", "mobile"
        ]);
        $this->assertMultipleEquals($trans, $jsonResponse, [
            "text_us", "text_ga", "id", "text_key", "mobile"
        ]);
    }

    /** @test */
    public function it_creates_a_trans_keu()
    {
        $token = $this->generateJwtToken();

        $response = $this->postJson('/api/translation', [
            'text_key' => $this->faker->word,
            'text_us' => $this->faker->word,
            'text_ga' => $this->faker->word,
            'mobile' => $this->faker->boolean
        ], ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    "text_us", "text_ga", "id", "text_key", "mobile"
                ]
            ]);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertNotEmpty($jsonResponse['data']);
        $this->assertManyNotEmpty([
            "text_us", "text_ga", "id", "text_key", "mobile"],
            $jsonResponse['data']
        );

    }
}
