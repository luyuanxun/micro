<?php
/**
 * Local variables
 * @var Micro $app
 */

use App\Controllers\AuthController;
use App\Common\Code;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    if ($app->request->getMethod() !== 'OPTIONS') {
        error_exit(Code::NOT_FOUND);
    }
});

/**
 * AuthController相关路由
 */
$auth = new MicroCollection();
$auth->setHandler(new AuthController());
$auth->setPrefix("/auth");
$auth->post("/token", "getToken");
$auth->get("/info", "getInfo");
$app->mount($auth);