<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
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

$factory->define(App\Models\Photo::class, function (Faker $faker) {
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
        //'album_id' => Album::inRandomOrder()->first()->id,
        'album_id' => 1,
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl(640, 480, $faker->randomElement($cats))
        //'img_path' => 'https://picsum.photos/640/680'
    ];
});


