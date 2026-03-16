<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// @todo Der APCu Cache ist auf der https://www.lutherorgel-plauen.de/ nicht aktiviert, deshalb
// kommt es zu einen Laufzeit-Error und der Code hier deaktiviert.
// Wieder aktivieren wenn es dann in ein Docker-Container umgezogen ist und läuft.
//
// Do not compile the container in a development environment, else all the
// changes you make to the definitions (attributes, configuration files, etc.)
// will not be taken into account.
// https://php-di.org/doc/performances.html#development-environment
// if ($_ENV['APP_ENV'] === 'prod' || $_SERVER['APP_ENV'] === 'prod') {
//    $containerBuilder->enableCompilation(__DIR__ . '/../var/caches/php-di');
//    $containerBuilder->enableDefinitionCache();
// }

$container = $containerBuilder->build();

$app = Bridge::create($container);

(require __DIR__ . '/routes.php')($app);

(require __DIR__ . '/middleware.php')($app);

return $app;
