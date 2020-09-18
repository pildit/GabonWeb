<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Transport\Entities\Item::class, function (Faker $faker) {
    return [
        'permit_id' => factory(\Modules\Transport\Entities\Permit::class),
        'trunk_number' => $faker->uuid,
        'lot_number' => $faker->numerify('####'),
        'species' => app('db')->table('transportation.list_species')->get()->random()->pop_name,
        'diam1' => $faker->randomFloat(2,10, 99),
        'diam2' => $faker->randomFloat(2,10, 99),
        'length' => $faker->randomFloat(2,10, 99),
        'volume' => $faker->randomFloat(2,10, 99),
        'width' => $faker->randomFloat(2,10, 99),
        'height' => $faker->randomFloat(2,10, 99),
        'mobile_id' => $faker->numerify('##_########_######'),
        'appuser' => app('db')->table('admin.accounts')->get()->random()->email
    ];
});
