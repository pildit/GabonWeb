<?php


namespace Modules\Transport\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Transport\Entities\Permit;
use Tests\TestCase;

class PermitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
    public function it_fails_getting_list_of_permits_paginated_due_the_wrong_sort_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/permits?sort=asc,sort_fields=obsdate|gps_accu', ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sort', 'sort_fields']
            ]);
    }

    /** @test */
    public function it_fails_getting_list_of_permits_paginated_due_the_wrong_type_of_request_parameters()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/permits?page=a&per_page=b', ['Authorization' => "Bearer $token"]);

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
        factory(Permit::class, 50)->create();

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
        $this->assertCount(50, $data['data']);
    }

    /** @test */
    public function it_test_getting_next_page_and_less_per_page_of_permits()
    {
        $token = $this->generateJwtToken();
        factory(Permit::class, 50)->create();
        $per_page = 10;
        $page = 2;

        $response = $this->getJson("/api/permits?page=$page&per_page=$per_page", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk();

        $data = $response->decodeResponseJson();
        $this->assertEquals(2, $data['current_page']);
        $this->assertEquals($per_page+1, $data['from']);
        $this->assertEquals($per_page*$page, $data['to']);
        $this->assertCount(10, $data['data']);
    }

    /** @test */
    public function it_returns_404_when_permit_with_id_does_not_exist()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('/api/permits/1', ['Authorization' => "Bearer $token"]);

        $response
            ->assertNotFound()
            ->assertJsonStructure(['message']);

        $data = $response->decodeResponseJson();
        $this->assertNotEmpty($data['message']);
    }

    /** @test */
    public function it_gets_a_single_permit_info_by_id()
    {
        $token = $this->generateJwtToken();

        $permit = factory(Permit::class)->create();

        $response = $this->getJson("/api/permits/{$permit->id}", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id', 'recdate', 'obsdate', 'appuser', 'lat', 'lon', 'gps_accu', 'permit_no', 'harvest_name',
                    'client_name', 'concession_name', 'transport_comp', 'license_plate', 'destination',
                    'management_unit', 'operational_unit', 'annual_operational_unit', 'mobile_id', 'note',
                    'the_geom', 'product_type', 'permit_status', 'verified_by', 'transport_by', 'generated_by',
                    'scan_lat', 'scan_lon', 'scan_gps_accu'
                ]
            ]);

        $data = $response->decodeResponseJson()['data'];

        $this->assertMultipleEquals($permit, $data, [
            'id', 'permit_no', 'permit_no', 'harvest_name',
            'client_name', 'concession_name', 'transport_comp', 'license_plate', 'destination',
            'management_unit', 'operational_unit', 'annual_operational_unit'
        ]);
        $this->assertNotEquals($permit->the_geom, $data['the_geom']);
        $this->assertNotEmpty($data['recdate']);
    }

    /** @test */
    public function it_gets_the_vectors_collection_for_permits()
    {
        //829188.882837592,-709335.6224864357,1758663.1467853351,391357.58482010243
        $token = $this->generateJwtToken();
        $bbox = '829188.882837592,-709335.6224864357,1758663.1467853351,391357.58482010243';

        $response = $this->getJson("/api/permits/vectors?bbox=$bbox", ['Authorization' => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'name',
                    'features' => [
                        '*' => [
                            'geometry' => [
                                'type',
                                'coordinates'
                            ],
                            'properties' => ['id']
                        ]
                    ]
                ]
            ]);
        $data = $response->decodeResponseJson()['data'];
        $this->assertEquals('permits', $data['name']);
    }

    /** @test */
    public function it_returns_the_field_list_for_permits_for_mobile_app()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson("/api/permits/mobile", ["Authorization" => "Bearer $token"]);

        $response
            ->assertOk()
            ->assertJsonStructure([
               '*' => ['f', 'fl', 'type']
            ]);
    }

    /** @test */
    public function it_creates_a_transport_permit()
    {
        $token = $this->generateJwtToken();

        $response = $this->postJson('/api/permits', [
            'the_geom' => "POINT(1469563.9738679952 -49607.63135707937)",
            'permit_no' => $this->faker->numerify('##_########_######'),
            'obsdate' => $this->faker->dateTimeBetween('-5 days')->format('Y-m-d'),
            'license_plate' => $this->faker->regexify('[A-Z][0-9]'),
            'transport_comp' => $this->faker->company,
            'harvest_name' => $this->faker->name,
            'client_name' => $this->faker->name,
            'concession_name' => $this->faker->company,
            'destination' => $this->faker->randomElement(['depot', 'sawmil', 'local_community']),
            'management_unit' => $this->faker->randomElement(['m3', 'pieces']),
            'operational_unit' => $this->faker->randomElement(['m3', 'pieces']),
            'annual_operational_unit' => $this->faker->word,
            'product_type' => $this->faker->randomElement(['logs', 'transformed']),
            'permit_status' => $this->faker->randomElement(['ready', 'verified', 'in_transit', 'transfer_load', 'end_transport', 'canceled']),
            'verified_by' => $this->faker->name,
            'transport_by' => $this->faker->company,
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->longitude,
            'gps_accu' => rand(1,10)
        ], ['Authorization' => "Bearer $token"]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    "obsdate",
                    "lat",
                    "lon",
                    "gps_accu",
                    "permit_no",
                    "harvest_name",
                    "client_name",
                    "concession_name",
                    "transport_comp",
                    "license_plate",
                    "destination",
                    "management_unit",
                    "operational_unit",
                    "annual_operational_unit",
                    "note",
                    "the_geom",
                    "product_type",
                    "permit_status",
                    "id"
                ]
            ]);

        $data = $response->decodeResponseJson();
        $this->assertArrayHasKey('data', $data);
        $this->assertNotEmpty($data['data']);
        $this->assertManyNotEmpty([
            "obsdate", "lat", "lon", "gps_accu", "permit_no", "harvest_name",
            "client_name", "concession_name", "transport_comp", "license_plate",
            "destination", "management_unit", "operational_unit", "annual_operational_unit",
            "the_geom", "product_type", "permit_status", "id"],
            $data['data']
        );

    }

    /** @test */
    public function it_updated_a_transport_permit()
    {
        // TODO
    }

    /** @test */
    public function it_deletes_a_transport_permit()
    {
        // TODO
    }

}
