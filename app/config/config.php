<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'phalcon',
        'charset' => 'utf8',
    ],

    'application' => [
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir' => APP_PATH . '/models/',
        'migrationsDir' => APP_PATH . '/migrations/',
        'servicesDir' => APP_PATH . '/services/',
        'commonDir' => APP_PATH . '/common/',
        'baseUri' => '/micro/',
    ],

    'cryptKey' => 'crypt-key',//加密密钥，请自行修改
    'noAuth' => [               //免授权路由
        'POST' => [
            '/auth/token',
        ],
        //GET PATCH DELETE HEAD...请自行添加
    ],
    'jwt' => [
        'key' => 'jwt-example-key',//请自行修改
        'expire' => 7200,//有效期两小时
    ],
]);
