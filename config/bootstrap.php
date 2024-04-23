<?php declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

if (version_compare(phpversion(), '8.2.0', '<')) {
    $message = 'This Slim-Skeleton is supported from PHP 8.2.0 or higher. Installed PHP version is: ' . phpversion();

    if ('cli' == PHP_SAPI) {
        echo $message;
    } else {
        exit($message);
    }
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Do not compile the container in a development environment, else all the
// changes you make to the definitions (attributes, configuration files, etc.)
// will not be taken into account.
// https://php-di.org/doc/performances.html#development-environment
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'prod'
    || isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'prod') {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/caches/php-di');
}

$container = $containerBuilder->build();

$app = Bridge::create($container);

(require __DIR__ . '/routes.php')($app);

(require __DIR__ . '/middleware.php')($app);

return $app;
