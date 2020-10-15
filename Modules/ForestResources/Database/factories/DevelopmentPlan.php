<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\ForestResources\Entities\DevelopmentUnit;

$factory->define(\Modules\ForestResources\Entities\DevelopmentPlan::class, function (Faker $faker) {
    $developmentUnit = factory(DevelopmentUnit::class)->create();
    return [
        'DevelopmentUnit' =>  $developmentUnit->Id,
        'Species' => $faker->Species,
        'MinimumExploitableDiameter' => $faker->MinimumExploitableDiameter,
        'VolumeTariff' => $faker->VolumeTariff,
        'Increment' => $faker->Increment
    ];
});
