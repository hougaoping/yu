<?php

return [

    'ad' => [
        'disk'         => 'uploads',
        'save_path'    => 'ad',                                    // 不允许二级目录
        'rule'         => 'date',                                  // 上传文件命名规则
        'size'         => 5 * 1024 * 1024,                         // 上传的文件大小限制
        'ext'          => 'jpg,png,gif,jpeg',                      // 允许上传的文件后缀
    ],


    'article' => [
        'disk'         => 'uploads',
        'save_path'    => 'article',
        'rule'         => 'date',
        'size'         => 15 * 1024 * 1024,
        'ext'          => 'jpg,png,gif,jpeg',
    ],

    'editor' => [
        'disk'         => 'uploads',
        'save_path'    => 'editor',
        'rule'         => 'date',
        'size'         => 15 * 1024 * 1024,
        'ext'          => 'jpg,png,gif,jpeg',
    ],
];
