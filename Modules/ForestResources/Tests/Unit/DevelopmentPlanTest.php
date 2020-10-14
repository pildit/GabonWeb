<?php


namespace Modules\ForestResources\Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Concession;
use Tests\TestCase;
use Str;

class DevelopmentPlanTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function it_create_a_development_plan()
    {
        $developmentUnit = factory(DevelopmentUnit::class)->create();
        $response = $this->postJson('/api/developmentplan',[
            'DevelopmentUnit' => $developmentUnit->Id,
            'Species' => '1',
            'MinimumExploitableDiameter' => '1',
            'VolumeTariff' => 'test',
            'Increment' => '1',
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

        $developmentUnit = factory(DevelopmentUnit::class)->create();
        $developmentPlan = factory(DevelopmentPlan::class)->create(
            ['DevelopmentUnit' => $developmentUnit->Id]);

        $response = $this->putJson('/api/developmentplan/'.$developmentPlan->Id, [
            'DevelopmentUnit' => $developmentPlan->DevelopmentUnit,
            'Species' => '1',
            'MinimumExploitableDiameter' => '1',
            'VolumeTariff' => 'test',
            'Increment' => '1',
            'token' => $this->generateJwtToken()
        ]);
    }
}
