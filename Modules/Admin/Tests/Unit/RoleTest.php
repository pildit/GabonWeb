<?php


namespace Modules\Admin\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_fails_getting_list_of_roles_due_no_access_token()
    {
        $response = $this->getJson('/api/roles');

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);

        $jsonResponse = $response->decodeResponseJson();
        $this->assertNotEmpty($jsonResponse['message']);
    }

    /** @test */
    public function it_fails_getting_paginator_for_roles_due_wrong_params()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/roles?sort=asc&sort_fields=name|id', ['Authorization' => "Bearer $token"]);

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

        $response = $this->getJson('/api/roles?page=a&per_page=b', ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['page', 'per_page']
            ]);
    }

    /** @test */
    public function it_returns_list_of_roles_paginated()
    {
        $token = $this->generateJwtToken();
        factory(Role::class, 50)->create();

        $response = $this->getJson('/api/roles', ['Authorization' => "Bearer $token"]);

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
    public function it_test_getting_next_page_and_less_per_page_of_roles()
    {
        $token = $this->generateJwtToken();
        factory(Role::class, 50)->create();
        $per_page = 10;
        $page = 2;

        $response = $this->getJson("/api/roles?page=$page&per_page=$per_page", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk();

        $jsonResponse = $response->decodeResponseJson();
        $this->assertEquals(2, $jsonResponse['current_page']);
        $this->assertEquals($per_page+1, $jsonResponse['from']);
        $this->assertEquals($per_page*$page, $jsonResponse['to']);
        $this->assertCount(10, $jsonResponse['data']);
    }

    /** @test */
    public function it_test_searching_role_by_name()
    {
        $token = $this->generateJwtToken();
        factory(Role::class, 10)->create();
        $role = factory(Role::class)->create(['name' => 'test_role']);

        $response = $this->getJson("/api/roles?search=test_role", ['Authorization' => "Bearer $token"]);

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
        $this->assertEquals($role['name'], $jsonResponse['data'][0]['name']);
    }

    /** @test */
    public function it_get_info_for_single_role_by_id()
    {
        $token = $this->generateJwtToken();
        $role = factory(Role::class)->create(['name' => 'test_role']);

        $response = $this->getJson("/api/roles/{$role->id}", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'name']
            ]);

    }

    /** @test */
    public function it_creates_a_role()
    {
        $token = $this->generateJwtToken();

        $response = $this->postJson("/api/roles",[
            'name' => $this->faker->word
        ], ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['name', 'id']
            ]);
    }

    /** @test */
    public function it_validates_unique_role_name()
    {
        $token = $this->generateJwtToken();
        $role = factory(Role::class)->create();

        $response = $this->postJson("/api/roles", [
            'name' => $role->name
        ], ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['name']
            ]);
    }

    /** @test */
    public function it_updates_a_role_name()
    {
        $token = $this->generateJwtToken();
        $role = factory(Role::class)->create();

        $response = $this->patchJson("/api/roles/{$role->id}", [
            'name' => 'update_role'
        ], ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['name', 'id']
            ]);

        $this->assertEquals('update_role', $response['data']['name']);
    }

    /** @test */
    public function it_deletes_a_role_name()
    {
        $token = $this->generateJwtToken();
        $role = factory(Role::class)->create();

        $response = $this->deleteJson("/api/roles/{$role->id}", [], ['Authorization' => "Bearer $token"]);

        $response
            ->assertNoContent();
    }

    /** @test */
    public function it_getting_permissions_for_a_role()
    {
        $token = $this->generateJwtToken();
        $role = factory(Role::class)->create();
        $role->pages()->saveMany(factory(Page::class, 10)->create());
        $role->permissions()->saveMany(factory(Permission::class, 3)->create());

        $response = $this->getJson("/api/roles/{$role->id}/permissions",
            ['Authorization' => "Bearer $token"]);

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
        $this->assertCount(10, $jsonResponse['data']);

    }
}
