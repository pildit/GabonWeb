<?php


namespace Modules\ForestResources\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Entities\Concession;
use Tests\TestCase;
use Str;

class ManagementUnitTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_create_a_development_unit()
    {

        $developmentUnit = factory(DevelopmentUnit::class)->create();
        $response = $this->postJson('/api/managementunit',[
            'Name' => 'Test',
            'DevelopmentUnit' => $developmentUnit->Id,
            'Geometry' => 'POLYGON((-7708435.4368466325 -1342414.3736874666,-7708585.922246069 -1342414.3736874666,-7708759.099888277 -1342667.571343661,-7708560.841346163 -1342696.2352292682,-7708396.024003923 -1342816.8624145307,-7708220.45770458 -1342569.6364011709,-7708294.5060757315 -1342613.8265581483,-7708423.493560963 -1342507.531315689,-7708435.4368466325 -1342414.3736874666))',
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
    public function it_update_a_development_unit(){
        $managementunit = factory(ManagementUnit::class)->create();
        $developmentUnit = factory(DevelopmentUnit::class)->create();

        $response = $this->puytJson('/api/managementunit/'.$managementunit->Id, [
            'Name' => 'Test',
            'DevelopmentUnit' => $developmentUnit->Id,
            'Geometry' => 'POLYGON((-7708435.4368466325 -1342414.3736874666,-7708585.922246069 -1342414.3736874666,-7708759.099888277 -1342667.571343661,-7708560.841346163 -1342696.2352292682,-7708396.024003923 -1342816.8624145307,-7708220.45770458 -1342569.6364011709,-7708294.5060757315 -1342613.8265581483,-7708423.493560963 -1342507.531315689,-7708435.4368466325 -1342414.3736874666))',
            'token' => $this->generateJwtToken()
        ]);
    }
}
