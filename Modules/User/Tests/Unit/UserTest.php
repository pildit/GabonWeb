<?php


namespace Modules\User\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_regsiters_an_user_with_success()
    {
        $password = Hash::make($this->faker->password);
        $response = $this->postJson('/api/users/register', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'message'
            ]);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);
    }

    /** @test */
    public function it_fails_password_confirmation_on_register()
    {
        $response = $this->postJson('/api/users/register', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'some_pass',
            'password_confirmation' => 'confirm_pass'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['password']
            ]);

        $data = $response->decodeResponseJson();
        $this->assertManyNotEmpty(['message', 'errors'], $data);
    }

    /** @test */
    public function it_fails_registering_existing_email_account()
    {
        $user = factory(User::class)->create();
        $password = Hash::make($this->faker->password);

        $response = $this->postJson('/api/users/register', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['email']
            ]);

        $data = $response->decodeResponseJson();
        $this->assertManyNotEmpty(['message', 'errors'], $data);
        $this->assertNotEmpty($data['errors']['email']);
    }
}
