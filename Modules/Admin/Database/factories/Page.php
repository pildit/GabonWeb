<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Admin\Entities\Page::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'path' => $faker->url,
        'resource' => $faker->word
    ];
});
