<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\ForestResources\Entities\DevelopmentUnit;

$factory->define(\Modules\ForestResources\Entities\ManagementPlan::class, function (Faker $faker) {
    $managementUnit = factory(ManagementtUnit::class)->create();
    return [
        'ManagementUnit' =>  $managementUnit->Id,
        'Species' => $faker->Species,
        'GrossVolumeUFG' => $faker->GrossVolumeUFG,
        'GrossVolumeYear' => $faker->GrossVolumeYear,
        'YieldVolumeYear' => $faker->YieldVolumeYear,
        'CommercialVolumeYear' => $faker->CommercialVolumeYear
    ];
});
