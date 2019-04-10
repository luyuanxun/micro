<?php

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

/**
 * The FactoryDefault Dependency Injector automatically registers the services that
 * provide a full stack framework. These default services can be overidden with custom ones.
 */
$di = new CliDi();

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
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

/**
 * Include Vendor
 */
include APP_PATH . '/../vendor/autoload.php';

/**
 * Create a console application
 */
$console = new ConsoleApp($di);

if (count($argv) < 4) {
    die('提示：命令错误');
}

if ($argv[1] !== 'scaffold' || !in_array($argv[2], ['crud', 'controller', 'model'])) {
    die('提示：命令 run ' . $argv[1] . ' ' . $argv[2] . ' 错误');
}

/**
 * Process the console arguments
 */
$arguments = [
    'task' => "Luyuanxun\\Micro\\Scaffold\\Rest",
    'action' => $argv[2],
    'params' => [
        'conn' => $di->getShared('dbSlave'),
        'force' => false
    ]
];

foreach ($argv as $arg) {
    if (strpos($arg, '--table=') !== false) {
        $arguments['params']['table'] = substr($arg, 8);
    }

    if ($arg === '--force') {
        $arguments['params']['force'] = true;
    }
}

if (empty($arguments['params']['table'])) {
    die('提示：没有设置数据表参数');
}

try {

    /**
     * Handle
     */
    $console->handle($arguments);

    /**
     * If configs is set to true, then we print a new line at the end of each execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    if (isset($config["printNewLine"]) && $config["printNewLine"]) {
        echo PHP_EOL;
    }

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(255);
}
