<?php


namespace Modules\Transport\Tests\Unit;


use GenTux\Jwt\JwtToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Entities\User;
use Tests\TestCase;

class PermitTest extends TestCase
{
    /** @test */
    public function it_fails_getting_list_of_permits_paginated_due_the_authentication()
    {
        $response = $this->getJson('/api/permits');

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);
    }

    /** @test */
    public function it_returns_list_of_permits_paginated()
    {
        $token = app(JwtToken::class)->createToken(factory(User::class)->create())->token();

        $response = $this->getJson('/api/permits', ['Authorization' => "Bearer $token"]);

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

        $data = $response->decodeResponseJson();

        $this->assertManyNotEmpty([
            'current_page', 'per_page', 'total',
            'current_page', 'from', 'to',
            'first_page_url', 'last_page_url'
        ], $data);

        $this->assertEquals(1, $data['current_page']);
        $this->assertEquals(1, $data['from']);
    }
}
