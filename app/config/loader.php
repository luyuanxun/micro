<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
        'App\Common' => $config->application->commonDir,
        'App\Controllers' => $config->application->controllersDir,
        'App\Models' => $config->application->modelsDir,
        'App\Services' => $config->application->servicesDir,
    ]
);

$loader->register();