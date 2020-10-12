<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\ForestResources\Entities\Concession;

$factory->define(\Modules\ForestResources\Entities\DevelopmentUnit::class, function (Faker $faker) {
    $concession = factory(Concession::class)->create();
    return [
        'Concession' => $concession->Id,
        'Name' => $faker->Name,
        'Start' => $faker->date,
        'End' => $faker->date,
        'Geometry' => "POLYGON((-7708435.4368466325 -1342414.3736874666,-7708585.922246069 -1342414.3736874666,-7708759.099888277 -1342667.571343661,-7708560.841346163 -1342696.2352292682,-7708396.024003923 -1342816.8624145307,-7708220.45770458 -1342569.6364011709,-7708294.5060757315 -1342613.8265581483,-7708423.493560963 -1342507.531315689,-7708435.4368466325 -1342414.3736874666))"
    ];
});
