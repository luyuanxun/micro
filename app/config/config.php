<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new Phalcon\Config([
    /**
     * 对应目录配置
     */
    'application' => [
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir' => APP_PATH . '/models/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'servicesDir' => APP_PATH . '/services/',
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
     * 免授权路由设置
     */
    'jwt' => [
        'key' => 'OAVmCOfnAls9NPkD',//请自行修改
        'expire' => 72000,//有效期两小时
    ],
]);
