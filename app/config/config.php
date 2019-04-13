<?php

return new Phalcon\Config([
    /**
     * 配置环境：dev test prod
     */
    'env' => 'dev',

    /**
     * 对应目录配置
     */
    'application' => [
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir' => APP_PATH . '/models/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'servicesDir' => APP_PATH . '/services/',
        'tasksDir' => APP_PATH . '/tasks/',
        'commonDir' => APP_PATH . '/common/',
        'baseUri' => '/micro/',
    ],

    /**
     * 数据库配置
     */
    'db' => [
        'master' => [
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => '123456',
            'dbname' => 'phalcon',
            'charset' => 'utf8mb4',
        ],
        'slave' => [
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => '123456',
            'dbname' => 'phalcon',
            'charset' => 'utf8mb4',
        ]
    ],

    /**
     * 加密密钥，请自行修改
     */
    'cryptKey' => 'OAVmCOfnAls9NPkD',

    /**
     * 免授权路由设置
     */
    'noAuth' => [
        'POST' => [
            '/auth/token',
        ],
        //GET PATCH DELETE HEAD...请自行添加
    ],

    /**
     * jwt秘钥配置
     */
    'jwt' => [
        'key' => 'OAVmCOfnAls9NPkD',//请自行修改
        'expire' => 72000,//有效期两小时
    ],
]);
