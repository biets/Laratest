<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Album::class, function (Faker $faker) {
    $cats = ['abstract',
        'animals',
        'business',
        'cats',
        'city',
        'food',
        'fashion',
        'people',
        'nature',
        'sports',
        'technics',
        'transport',
    ];

    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        'user_id' => User::inRandomOrder()->first(),
        'album_thumb' => $faker->imageUrl(640, 480, $faker->randomElement($cats))
    ];
});

