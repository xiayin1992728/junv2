<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Models\Spread;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $now = Carbon::now()->toDateTimeString();
    $spreads = Spread::get()->pluck('id')->toArray();
    $phone = $faker->phoneNumber;
    return [
        'name' => $faker->name,
        'remember_token' => str_random(10),
        'phone' => $phone,
        'sid' => array_random($spreads),
        'password' => bcrypt($phone),
        'change' => random_int(1,100)/100,
        'created_at' => $now,
    	'updated_at' => $now,
    ];
});
