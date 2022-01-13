<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Author::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail(),
        'username' => $faker->userName().time(),
        'fullname' => $faker->name(),
        'password' => bcrypt('123456'),
    ];
});
