<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Transport\Entities\Permit::class, function (Faker $faker) {
    return [
        'the_geom' => "POINT(1469563.9738679952 -49607.63135707937)",
        'permit_no' => $faker->numerify('##_########_######'),
        'obsdate' => $faker->dateTimeBetween('-5 days')->format('Y-m-d'),
        'license_plate' => $faker->regexify('[A-Z][0-9]'),
        'transport_comp' => $faker->company,
        'harvest_name' => $faker->name,
        'client_name' => $faker->name,
        'concession_name' => $faker->company,
        'destination' => $faker->randomElement(['depot', 'sawmil', 'local_community']),
        'management_unit' => $faker->randomElement(['m3', 'pieces']),
        'operational_unit' => $faker->randomElement(['m3', 'pieces']),
        'annual_operational_unit' => $faker->word,
        'product_type' => $faker->randomElement(['logs', 'transformed']),
        'permit_status' => $faker->randomElement(['ready', 'verified', 'in_transit', 'transfer_load', 'end_transport', 'canceled']),
        'verified_by' => $faker->name,
        'transport_by' => $faker->company,
        'lat' => $faker->latitude,
        'lon' => $faker->longitude,
        'gps_accu' => rand(1,10)
    ];
});
