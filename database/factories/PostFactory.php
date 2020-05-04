<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'author_id' => 2,
        'title' => $faker->unique()->sentence,
        'description' => $faker->paragraph,
        'body' => $faker->text(400),
        'slug' => $faker->slug,
        'images' => $faker->slug,
        'active' => rand(0,1)
    ];
});
