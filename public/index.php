<?php

use App\Common\Code;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use App\Common\CustomException;
use App\Common\Authorization;

//TODO 关闭
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Include Helper
     */
    include APP_PATH . '/common/helpers.php';

    /**
     * Include Vendor
     */
    include APP_PATH . '/../vendor/autoload.php';

    /**
     * 校验授权
     */
    $app->before(
        function () use ($app, $config) {
            $pattern = $app->router->getMatchedRoute()->getCompiledPattern();
            $method = $app->router->getMatchedRoute()->getHttpMethods();
            $noAuth = $config->noAuth->$method ?? [];
            if(!in_array($pattern, (array)$noAuth)){
                $auth = Authorization::check($app->request->getHeader('Authorization'));
                $app->setService('auth', $auth);
            }

        }
    );

    /**
     * Handle Result
     */
    $app->after(
        function () use ($app) {
            handleResult(Code::OK, '', $app->getReturnedValue() ?? []);
        }
    );

    /**
     * Handle the request
     */
    $app->handle();

} catch (Exception $e) {
    if ($e instanceof CustomException) {
        handleResult($e->getCode(), $e->getMessage());
    } else {
        echo $e->getMessage() . '<br>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
}
