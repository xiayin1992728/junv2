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

    /* 渠道管理 */
 /*   [
        'icon' => '&#xe656;',
        'title' => '渠道管理',
        'son' => [
            [
                'title' => '渠道列表',
                'url' => 'channels.index',
            ],
        ],
    ],*/

    /* 推广管理 */
    [
        'icon' => '&#xe667;',
        'title' => '推广管理',
        'son' => [
            [
                'title' => '推广列表',
                'url' => 'spreads.index',
            ],
            [
                'title' => '推广统计',
                'url' => 'countPeoples.index',
            ],
        ],
    ],

    /* 其他设置 */
    [
        'icon' => '&#xe716;',
        'title' => '其他设置',
        'son' => [
            [
                'title' => '轮播设置',
                'url' => 'admin.carousel.index',
            ],
            [
                'title' => '发现设置',
                'url' => 'carousel.index',
            ],
        ],
    ],
];