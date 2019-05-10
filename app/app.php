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
$auth->get("/token/refresh", "refresh");
$auth->get("/info", "getInfo");
$app->mount($auth);

/**
 * AdminController
 */
$admin = new MicroCollection();
$admin->setHandler(new App\Controllers\AdminController());
$admin->setPrefix("/admin");
$admin->post("/", "create");
$admin->delete("/", "delete");
$admin->put("/", "update");
$admin->get("/", "getInfo");
$admin->get("/list", "getList");
$app->mount($admin);

/**
 * ArticleController
 */
$article = new MicroCollection();
$article->setHandler(new App\Controllers\ArticleController());
$article->setPrefix("/article");
$article->post("/", "create");
$article->delete("/", "delete");
$article->put("/", "update");
$article->get("/", "getInfo");
$article->get("/list", "getList");
$app->mount($article);