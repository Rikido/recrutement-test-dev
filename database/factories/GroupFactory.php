<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        // IDは自動割り振り
        // unique()でユニークなパラメータを生成する
        // group_nameをword(単語)から生成する
        'group_name' => $faker->unique()->word,
    ];
});
