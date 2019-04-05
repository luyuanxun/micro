<?php

use Phalcon\Loader;
use Phalcon\Di;

/**
 * Registering an autoloader
 */
$loader = new Loader();
$config = $config ?? Di::getDefault()->getConfig();

/**
 * Register some namespaces
 */
$loader->registerNamespaces(
    array(
        'App\Controllers' => $config->application->controllersDir,
        'App\Models' => $config->application->modelsDir,
        'App\Services' => $config->application->servicesDir,
        'App\Common' => $config->application->commonDir,
    )
);

$loader->register();