<?php

use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Spread;

$factory->define(Spread::class, function (Faker $faker) {

    $products = Product::get()->pluck('id')->toArray();
    $admins = Admin::role('推广员')->get()->pluck('id')->toArray();
    $uid = random_int(0,(count($admins)-1));
    $pid = random_int(0,(count($products)-1));

    return [
        'uid' => $admins[$uid],
        'pid' => $products[$pid],
        'number' => date('YmdHis').random_int(10000,99999),
        'change' => mt_rand(0,100)/100,
        'created_at' => date('Y-m-d H:i:s',time()),
        'updated_at' => date('Y-m-d H:i:s',time()),
    ];
});
