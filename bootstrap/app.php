<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\App;

require __DIR__ . '/../app/constants.php';
require __DIR__ . '/../app/helper.php';

require ROOT_DIR . 'vendor/autoload.php';

/*
 *----------------------------------------------------------------------------
 * Php version validation
 *----------------------------------------------------------------------------
 */
if( !defined('PHP_VERSION_ID') || 80000 > PHP_VERSION_ID ) {
    if( 'cli' == PHP_SAPI ) {
        echo 'This Slim-Skeleton support PHP 8.0 or later.';
    } else {
        echo <<<HTML
            <div>
                <p>This Slim-Skeleton supports PHP 8.0 or later.</p>
            </div>
        HTML;
        exit(1);
    }
}

/*
 *----------------------------------------------------------------------------
 * Loads environment variables from .env
 *----------------------------------------------------------------------------
 *
 * You should never store sensitive credentials in your code.
 * https://github.com/vlucas/phpdotenv
 *
 */

$dotenv = Dotenv\Dotenv::createMutable( ROOT_DIR );
$dotenv->load();

/*
 *----------------------------------------------------------------------------
 * Instantiate PHP-DI ContainerBuilder
 *----------------------------------------------------------------------------
 *
 * The dependency injection container for humans, see:
 * https://php-di.org/
 *
 */

$builder = new ContainerBuilder;

/*
 *----------------------------------------------------------------------------
 * Slim skeleton containers
 *----------------------------------------------------------------------------
 *
 */
(require ROOT_DIR . 'app/containers.php')($builder);

/*
 *----------------------------------------------------------------------------
 * User containers
 *----------------------------------------------------------------------------
 *
 */
(require ROOT_DIR . 'src/Containers/containers.php')($builder);
(require ROOT_DIR . 'src/Containers/dependencies.php')($builder);

$container = $builder->build();

$app = $container->get(App::class);

(require ROOT_DIR . 'app/middleware.php')($app);

/*
 *----------------------------------------------------------------------------
 * Set up routes with nikic/fast-route
 *----------------------------------------------------------------------------
 *
 * For more informations see: 
 * https://www.slimframework.com/docs/v4/objects/routing.html
 *
 * Include the routes that you need. You can use web-routes for classic php
 * applications or api-routes for REST-API applications. And of course you 
 * can use both.
 *
 */

(require ROOT_DIR . 'routes/api.php')($app);

(require ROOT_DIR . 'routes/web.php')($app);

return $app;