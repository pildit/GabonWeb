<?php


namespace Modules\Transport\Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Transport\Entities\Permit;
use Tests\TestCase;

class PermitTest extends TestCase
{
    use RefreshDatabase;

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
        $token = $this->generateJwtToken();

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

    /** @test */
    public function it_returns_404_when_permit_with_id_does_not_exist()
    {
        $token = $this->generateJwtToken();

        $response = $this->getJson('api/permits/1', ['Authorization' => "Bearer $token"]);

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

        $response = $this->getJson("api/permits/{$permit->id}", ['Authorization' => "Bearer $token"]);

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

        $response = $this->getJson("api/permits/vectors?bbox=$bbox", ['Authorization' => "Bearer $token"]);

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

}
