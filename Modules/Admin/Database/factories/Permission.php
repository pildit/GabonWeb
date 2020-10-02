<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Admin\Entities\Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
