<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'logo' => $faker->url,
        'maxs' => $faker->numberBetween(5000,10000),
        'tag' => $faker->name,
        'saleman' => $faker->name,
        'longtimes' => $faker->numberBetween(30,360),
        'link' => $faker->url,
        'types' => '外部产品',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
