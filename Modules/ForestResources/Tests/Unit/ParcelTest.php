<?php


namespace Modules\ForestResources\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Modules\ForestResources\Entities\Parcel;
use Tests\TestCase;
use Str;

class ParcelTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_create_a_parcel()
    {


        $response = $this->postJson('/api/parcels',[
            'Name' => 'Test',
            'geometry_shp' =>  new \Illuminate\Http\UploadedFile(resource_path('test-files/provinces_gabon.shp'), 'provinces_gabon.shp', null, null, null, true),
            'geometry_shx' => new \Illuminate\Http\UploadedFile(resource_path('test-files/provinces_gabon.shx'), 'provinces_gabon.shx', null, null, null, true),
            'geometry_dbf' => new \Illuminate\Http\UploadedFile(resource_path('test-files/provinces_gabon.dbf'), 'provinces_gabon.dbf', null, null, null, true),
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
