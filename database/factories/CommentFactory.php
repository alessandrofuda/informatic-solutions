<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'on_post' => 1,
        'from_user' => $faker->name,
        'from_user_name' => $faker->name,
        'body' => $faker->paragraph,
        //'created_at' => '',
        //'updated_at' => '',
        'from_user_email' => $faker->email,
        'from_user_ip' => '0.0.0.0',
        'from_user_url' => $faker->url,
        'comment_approved' => 1,
        'comment_agent' => 'UserAgent Test',
        'comment_parent' => 0,
        'deleted_at' => null,
    ];
});
