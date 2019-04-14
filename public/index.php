<?php

use App\Common\Code;
use App\Common\CodeMsg;
use Phalcon\Crypt;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Lyx\Micro\Tools\CustomException;
use Lyx\Micro\Tools\Authorization;
use Phalcon\Mvc\Router;

//TODO 关闭
error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Injecting Configuration Dependency
     */
    $di->set(
        'config',
        function () {
            return include APP_PATH . "/config/config.php";
        }
    );

    $config = $di->get('config');

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Crypt：Set a global encryption key
     */
    $di->set(
        'crypt',
        function () use ($config) {
            $crypt = new Crypt();
            $crypt->setKey($config->cryptKey);
            return $crypt;
        },
        true
    );

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
     * Set Uri Source
     */
    $app->router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Include Vendor
     */
    include APP_PATH . '/../vendor/autoload.php';

    /**
     * 设置返回需要加密的字段，默认对所有返回的id加密
     * 注：可在对应控制器的方法中修改需要加密的字段：
     * $this->di->getService('encryptFields')->setDefinition(['id']);
     */
    $app->setService('encryptFields', ['id']);

    /**
     * 校验授权
     */
    $app->before(
        function () use ($app, $config) {
            $pattern = $app->router->getMatchedRoute()->getCompiledPattern();
            $method = $app->router->getMatchedRoute()->getHttpMethods();
            $noAuth = $config->noAuth->$method ?? [];
            if (!in_array($pattern, (array)$noAuth)) {
                Authorization::analyzeToken();
            }
        }
    );

    /**
     * Handle Result 统一处理返回值
     */
    $app->after(
        function () use ($app, $config) {
            $data = $app->getReturnedValue() ?? [];
            $whiteList = $app->di->getService('encryptFields')->getDefinition();
            handleCryptBase64($app->crypt, $data, $whiteList);
            handleResult(Code::OK, CodeMsg::get(Code::OK), $data);
        }
    );

    /**
     * Handle the request
     */
    $app->handle();

} catch (Exception $e) {
    /**
     * 可能返回其它response识别不了的code，
     * 所以统一定义为500服务器端错误
     */
    $code = Code::SERVER_ERROR;
    //自定义抛出的错误]
    if ($e instanceof CustomException) {
        $code = $e->getCode();
    }
    /*else{
        //调试时，查看非自定义的完整错误信息
        var_dump($e->getMessage(), $e->getTraceAsString());
        exit();
    }*/

    handleResult($code, $e->getMessage());
}
