<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

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

$factory->define(Client::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'display_name' => $faker->name,
        'seconds' => $faker->numberBetween(1,2000000),
        'points' => $faker->numberBetween(10,20000)
     ];
});
