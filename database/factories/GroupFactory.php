<?php

use App\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'group_name' => $faker->unique()->safeColorName,
    ];
});