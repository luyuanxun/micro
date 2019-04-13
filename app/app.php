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
    error_exit(Code::NOT_FOUND);
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

/**
 * UserController
 */
$user = new MicroCollection();
$user->setHandler(new App\Controllers\UserController());
$user->setPrefix("/user");
$user->post("/", "create");
$user->delete("/", "delete");
$user->put("/", "update");
$user->get("/", "getInfo");
$user->get("/list", "getList");
$app->mount($user);

/**
 * NewsController
 */
$news = new MicroCollection();
$news->setHandler(new App\Controllers\NewsController());
$news->setPrefix("/news");
$news->post("/", "create");
$news->delete("/", "delete");
$news->put("/", "update");
$news->get("/", "getInfo");
$news->get("/list", "getList");
$app->mount($news);