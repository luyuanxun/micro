<?php

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

/**
 * The FactoryDefault Dependency Injector automatically registers the services that
 * provide a full stack framework. These default services can be Over covered with custom ones.
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

if (count($argv) < 3) {
    die('提示：命令错误' . PHP_EOL);
}

$arguments = [];
foreach ($argv as $k => $arg) {
    if ($k === 1) {
        if ($arg === 'scaffold' && $config->env !== 'dev') {
            die('提示：非开发环境禁止使用脚手架！' . PHP_EOL);
        }

        $arguments['task'] = 'App\Tasks\\' . $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        if (preg_match('/^--([^=]+)=(.*)/',$arg,$reg)) {
            $arguments['params'][$reg[1]] = $reg[2];
        } elseif(preg_match('/^-([a-zA-Z0-9])/',$arg,$reg)) {
            $arguments['params'][$reg[1]] = 'true';
        }
    }
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
