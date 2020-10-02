<?php


namespace Modules\User\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Tests\TestCase;
use Str;

class UserTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_regsiters_an_user_with_success()
    {
        $password = Hash::make($this->faker->password);
        $response = $this->postJson('/api/users/register', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'employee_type' => 1
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
            'password_confirmation' => 'confirm_pass',
             'employee_type' => 1
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
            'password_confirmation' => $password,
            'employee_type' => 1
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

    /** @test */
    public function it_regsiters_an_user_with_success_by_admin()
    {
        $password = Hash::make($this->faker->password);
        $token = $this->generateJwtToken();
        $response = $this->postJson('/api/users/registerAdmin', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'employee_type' => 1,
            'token' => $token
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
    public function it_verifies_users_from_email_link()
    {
        $user = factory(User::class)->create(['status' => User::STATUS_DISABLED,'activationcode' => Str::random(20)]);
        $response = $this->postJson('/api/users/verify', [
            'code' => $user->activationcode,
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
    public function it_send_forgot_password_email(){
        $user = factory(User::class)->create(['status' => User::STATUS_ACTIVE,'activationcode' => Str::random(20)]);

        $response = $this->postJson('/api/users/'.$user->id.'/forgot');

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'message'
            ]);

        $data = $response->decodeResponseJson();

        $this->assertNotEmpty($data['message']);

    }

    /** @test */
    public function it_changes_the_password() {
        $user = factory(User::class)->create(['status' => User::STATUS_ACTIVE,'activationcode' => Str::random(20)]);
        $password = Hash::make($this->faker->password);

        $response = $this->postJson('/api/users/password/', [
            'code' => $user->activationcode,
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
    public function in_resend_confirmation_email() {
        $user = factory(User::class)->create(['status' => User::STATUS_ACTIVE,'activationcode' => Str::random(20)]);

        $response = $this->postJson('/api/users/'.$user->id.'/confirmation',[
            'token' => $this->generateJwtToken()
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
    public function it_approve_the_user() {
        $user = factory(User::class)->create(['status' => User::STATUS_DISABLED,'activationcode' => Str::random(20)]);

        $response = $this->postJson('/api/users/'.$user->id.'/approve',[
            'token' => $this->generateJwtToken()
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'message'
            ]);

        $data = $response->decodeResponseJson();

        $this->assertNotEmpty($data['message']);
    }
}
