<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Allocate;
use Faker\Generator as Faker;

$factory->define(Allocate::class, function (Faker $faker) {
    return [
        'item_id' => rand(2,15), 
        'num' => rand(1, 3) *10,
        'created_at' => now(),
        'updated_at' => now(),
        'name' => $faker->name,
    ];
});
