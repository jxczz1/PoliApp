<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerFiles([APP_PATH . '/library/vendor/autoload.php']);
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
