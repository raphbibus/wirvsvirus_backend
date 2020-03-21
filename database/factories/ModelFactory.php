<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\InOut;
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

$factory->define(InOut::class, function (Faker $faker) {

    $client = Client::all()->random(1);

    return [
        'entered' => $faker->dateTimeBetween('-1 day', 'now'),
        'client_id' => $client[0]->id,
        'token' => md5('your mom'.$client[0]->id.rand(0,20)),
    ];

});
