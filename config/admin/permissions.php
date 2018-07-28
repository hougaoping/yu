<?php
return [

    // 公共权限
	'public' => [
		'admin.dashboard',
        'admin.upload',
    ],

    // 相同权限
    'equal' => [
        'admin.articles.create' => ['admin.upload.tinymce'],
        'admin.articles.edit' => ['admin.upload.tinymce'],
    ],

	'permissions' => [
        [
            'name' => '系统设置',
            'items' => [
                'admin.settings' => '系统设置',
            ],
        ],
        [
            'name' => '操作日志',
            'items' => [
                'admin.activity_logs.index' => '日志列表',
            ],
        ],
        [
            'name' => '登录日志',
            'items' => [
                'admin.user_loginlogs.index' => '登录日志',
            ],
        ],
        [
            'name' => '链接管理',
            'items' => [
                'admin.links.index' => '链接列表',
                'admin.links.create|admin.links.store' => '添加链接',
                'admin.links.edit|admin.links.update' => '编辑链接',
                'admin.links.destroy' => '删除链接',
            ],
        ],
        [
            'name' => '文件管理',
            'items' => [
                'admin.files.index' => '文件管理',
            ],
        ],
        [
            'name' => '广告位管理',
            'items' => [
                'admin.ad_positions.index' => '广告位列表',
                'admin.ad_positions.create|admin.ad_positions.store' => '添加广告位',
                'admin.ad_positions.edit|admin.ad_positions.update' => '编辑广告位',
                'admin.ad_positions.destroy' => '删除广告位',
            ],
        ],
        [
            'name' => '广告管理',
            'items' => [
                'admin.ads.index' => '广告列表',
                'admin.ads.create|admin.ads.store' => '添加广告',
                'admin.ads.edit|admin.ads.update' => '编辑广告',
                'admin.ads.destroy' => '删除广告',
            ],
        ],
        [
            'name' => '文章分类管理',
            'items' => [
                'admin.article_categories.index' => '文章分类列表',
                'admin.article_categories.create|admin.article_categories.store' => '添加文章分类',
                'admin.article_categories.edit|admin.article_categories.update'  => '编辑文章分类',
                'admin.article_categories.destroy' => '删除文章分类',
            ],
        ],
        [
            'name' => '文章管理',
            'items' => [
                'admin.articles.index' => '文章列表',
                'admin.articles.create|admin.articles.store' => '添加文章',
                'admin.articles.edit|admin.articles.update'  => '编辑文章',
                'admin.articles.destroy' => '删除文章',
            ],
        ],
        [
            'name' => '用户管理',
            'items' => [
               'admin.users.index'   => '用户列表',
			   'admin.users.profile' => '个人信息',
			   'admin.users.charge'  => '充值',
               'admin.users.destroy' => '删除用户',
            ],
        ],
        [
            'name' => '用户邮箱',
            'items' => [
               'admin.user_emails.index' => '用户列表',
            ],
        ],
        [
            'name' => '管理员管理',
            'items' => [
                'admin.admin.index' => '管理员列表',
                'admin.admin.create|admin.admin.store' => '添加管理员',
                'admin.admin.edit|admin.admin.update' => '编辑管理员',
                'admin.admin.destroy' => '删除管理员',
            ],
        ],
        [
            'name' => '角色管理',
            'items' => [
                'admin.roles.index' => '角色列表',
                'admin.roles.create|admin.roles.store' => '添加角色',
                'admin.roles.edit|admin.roles.update' => '编辑角色',
                'admin.roles.destroy' => '删除角色',
            ],
        ],
	],
];
