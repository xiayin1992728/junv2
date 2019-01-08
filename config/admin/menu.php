<?php

return [
    /*用户管理*/
    [
        'icon' => '&#xe66f;',
        'title' => '用户管理',
        'son' => [
             [
                'title' => '前台用户',
                 'url' => 'user.index',
            ],
            [
                'title' => '后台用户',
                'url' => 'admin.index',
            ],
        ],
    ],

    /* 权限管理 */
    [
        'icon' => '&#xe672;',
        'title' => '权限管理',
        'son' => [
            [
                'title' => '角色列表',
                'url' => 'roles.index',
            ],
            [
                'title' => '权限列表',
                'url' => 'permissions.index',
            ],
        ],
    ],

    /* 产品管理 */
    [
        'icon' => '&#xe653;',
        'title' => '产品管理',
        'son' => [
            [
                'title' => '产品列表',
                'url' => 'products.index',
            ],
            [
                'title' => '页面列表',
                'url' => 'productPages.index',
            ],
        ],
    ],

];