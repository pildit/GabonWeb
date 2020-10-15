<?php


namespace Modules\ForestResources\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Concession;
use Tests\TestCase;
use Str;

class DevelopmentUnitTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_create_a_development_unit()
    {

        $concession = factory(Concession::class)->create();
        $response = $this->postJson('/api/developmentunit/store',[
            'Name' => 'Test',
            'Concession' => $concession->Id,
            'Start' => '2020-10-12',
            'End' => '2020-12-12',
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
        $concession = factory(Concession::class)->create();
        $developmentUnit = factory(DevelopmentUnit::class)->create(
            ['Concession' => $concession->Id]);

        $response = $this->postJson('/api/developmentunit/'.$developmentUnit->Id.'/update/', [
            'Name' => "Test",
            'Geometry' => "POLYGON((-7708436.6311751995 -1342415.5680160334,-7708583.533588935 -1342415.5680160334,-7708757.90555971 -1342667.571343661,-7708548.898060493 -1342702.2068721028,-7708397.21833249 -1342815.6680859637,-7708216.874718879 -1342560.0817726352,-7708288.534432897 -1342613.8265581483,-7708413.938932427 -1342512.3086299568,-7708436.6311751995 -1342415.5680160334))",
            'Start' => "2020-10-12",
            'End' => "2020-12-12",
            'Concession' => $developmentUnit->Concession,
        ]);
    }
}
