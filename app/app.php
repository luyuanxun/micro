<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use App\Common\Code;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    error_exit(Code::NOT_FOUND);
});

/**
 * TestController相关路由
 */
$test = new MicroCollection();
$test->setHandler(new \App\Controllers\TestController());
$test->setPrefix('/test');
$test->get('/', 'index');
$test->get('/error', 'error');
$app->mount($test);


/**
 * UserController相关路由
 */
$test = new MicroCollection();
$test->setHandler(new \App\Controllers\UserController());
$test->setPrefix('/user');
$test->post('/login', 'login');
$app->mount($test);

