<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?? $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => 'subscriber',
        'verified' => 1,
        'email_token' => null
    ];
});
