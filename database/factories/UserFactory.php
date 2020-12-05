<?php

use Illuminate\Support\Str;
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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '123456', // secret
        'remember_token' => str_random(10),
        'dni' => $faker->randomNumber(8, true),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker->randomElement(['patient', 'doctor'])
    ];
});


$factory->state(App\User::class, 'patient', [
    'role' => 'patient'
]);

$factory->state(App\User::class, 'doctor', [
    'role' => 'doctor'
]);