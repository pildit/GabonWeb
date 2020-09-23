<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Translation\Entities\Language::class, function (Faker $faker) {
    return [
        'text_key' => $faker->word,
        'text_us' => $faker->word,
        'text_ga' => $faker->word,
        'mobile' => $faker->boolean
    ];
});
