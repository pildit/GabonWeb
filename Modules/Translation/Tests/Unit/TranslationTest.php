<?php


namespace Modules\Translation\Tests\Unit;


use Tests\TestCase;

class TranslationTest extends TestCase
{
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
}
