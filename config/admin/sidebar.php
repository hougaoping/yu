<?php

return [
        [
            'name'=>'系统管理',
            'items' => [
                [
                    'title' => '管理首页',
                    'route' => 'admin.dashboard',
                    'active'=> 'admin.dashboard'
                ],
                [
                    'title' => '系统设置',
                    'route' => 'admin.settings',
                    'active'=> 'admin.settings'
                ],
                [
                    'title' => '操作日志',
                    'route' => 'admin.activity_logs.index',
                    'active'=> 'admin.activity_logs.*'
                ],
                [
                    'title' => '登录日志',
                    'route' => 'admin.user_loginlogs.index',
                    'active'=> 'admin.user_loginlogs.*'
                ],
                [
                    'title' => '链接管理',
                    'route' => 'admin.links.index',
                    'active'=> 'admin.links.*'
                ],
                [
                    'title' => '文件管理',
                    'route' => 'admin.files.index',
                    'active'=> 'admin.files.index'
                ],
            ]
        ],

        [
            'name'=>'广告管理',
            'items' => [
                [
                    'title' => '广告位管理',
                    'route' => 'admin.ad_positions.index',
                    'active'=> 'admin.ad_positions.*'
                ],
                [
                    'title' => '广告管理',
                    'route' => 'admin.ads.index',
                    'active'=> 'admin.ads.*'
                ],
            ]
        ],

         [
            'name'=>'文章管理',
            'items' => [
                [
                    'title' => '文章分类',
                    'route' => 'admin.article_categories.index',
                    'active'=> 'admin.article_categories.*'
                ],
                [
                    'title' => '文章管理',
                    'route' => 'admin.articles.index',
                    'active'=> 'admin.articles.*'
                ],
            ]
        ],

        [
            'name'=>'用户管理',
            'items' => [
                [
                    'title' => '用户列表',
                    'route' => 'admin.users.index',
                    'active'=> 'admin.users.*'
                ],
                [
                    'title' => '用户邮箱',
                    'route' => 'admin.user_emails.index',
                    'active'=> 'admin.user_emails.*'
                ],
                [
                    'title' => '财务明细',
                    'route' => 'admin.user_finances.index',
                    'active'=> 'admin.user_finances.*'
                ],
            ]
        ],

        [
            'name'=>'管理员',
            'items' => [
                [
                    'title' => '管理员列表',
                    'route' => 'admin.admin.index',
                    'active'=> 'admin.admin.*'
                ],
                [
                    'title' => '角色管理',
                    'route' => 'admin.roles.index',
                    'active'=> 'admin.roles.*'
                ],
            ]
        ],
];