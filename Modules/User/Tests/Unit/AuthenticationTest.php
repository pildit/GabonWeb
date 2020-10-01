<?php

namespace Modules\User\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthenticationTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_generate_user_jwt_token()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->postJson('/api/users/login', ['email' => $user->email, 'password' => 'pass123']);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'jwt',
            ]);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);
        $this->assertNotEmpty($data['jwt']);
    }

    /** @test */
    public function it_requires_email_and_password_to_auth()
    {
        $response = $this->postJson('/api/users/login', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['email', 'password']
            ]);

        $data = $response->decodeResponseJson();
        $this->assertIsArray($data['errors']);
        $this->assertNotEmpty($data['errors']);

    }

    /** @test */
    public function it_fails_to_generate_token_due_user_not_found()
    {
        $response = $this->postJson('/api/users/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response
            ->assertNotFound()
            ->assertJsonStructure([
                'message'
            ]);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);

    }

    /** @test */
    public function it_fails_to_generate_token_due_invalid_credentials()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/users/login', [
            'email' => $user->email,
            'password' => 'wrong_pass'
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);
    }
}
