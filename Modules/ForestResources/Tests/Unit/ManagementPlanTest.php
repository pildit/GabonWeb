<?php


namespace Modules\ForestResources\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Concession;
use Modules\ForestResources\Entities\ManagementUnit;
use Tests\TestCase;
use Str;

class ManagementPlanTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_create_a_development_plan()
    {
        $managementUnit = factory(ManagementUnit::class)->create();
        $response = $this->postJson('/api/managementplan',[
            'ManagementUnit' => $managementUnit->Id,
            'Species' => '1',
            'GrossVolumeUFG' => '1',
            'GrossVolumeYear' => '1',
            'YieldVolumeYear' => '1',
            'CommercialVolumeYear' => '1',
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

    /** @test  */
    public function it_update_a_development_plan(){

        $managementUnit = factory(ManagementUnit::class)->create();
        $managementPlan = factory(ManagementPlan::class)->create(
            ['ManagementUnit' => $managementUnit->Id]);

        $response = $this->putJson('/api/managementplan/'.$managementPlan->Id, [
            'ManagementUnit' => $managementUnit->Id,
            'Species' => '1',
            'GrossVolumeUFG' => '1',
            'GrossVolumeYear' => '1',
            'YieldVolumeYear' => '1',
            'CommercialVolumeYear' => '1',
            'token' => $this->generateJwtToken()
        ]);
    }
}
