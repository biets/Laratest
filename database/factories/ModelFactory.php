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

$factory->define(Models\Album::class, function (Faker $faker) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        'user_id' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

    ];
});

