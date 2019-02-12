<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ProductPage::class, function (Faker $faker) {
    return [
        [
            'pid' => 1,
            'name' => '借款选择',
            'pages' => config('app.url').'/loan',
            'sort' => 1,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '身份验证',
            'pages' => config('app.url').'/verify',
            'sort' => 2,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '身份特征',
            'pages' => config('app.url').'/feature',
            'sort' => 3,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '审核中',
            'pages' => config('app.url').'/audit',
            'sort' => 4,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '继续借',
            'pages' => config('app.url').'/continue',
            'sort' => 5,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '为我推荐',
            'pages' => config('app.url').'/second',
            'sort' => 6,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ],
        [
            'pid' => 1,
            'name' => '发现',
            'pages' => config('app.url').'/find',
            'sort' => 7,
            'created_at' => date('Y-m-d H:i:s',time()),
            'updated_at' => date('Y-m-d H:i:s',time()),
        ]
    ];
});
