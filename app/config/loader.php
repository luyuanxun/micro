<?php

use Phalcon\Loader;

/**
 * Registering an autoloader
 */
$loader = new Loader();

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