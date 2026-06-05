<?php

declare(strict_types=1);

use Odan\Session\Middleware\SessionStartMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

/*
 * For more informations see:
 * https://www.slimframework.com/docs/v4/concepts/middleware.html
 *
 */
return function (App $app) {

    $app->addBodyParsingMiddleware();
    
    $app->add(SessionStartMiddleware::class);

    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class);

    $app->add(ErrorMiddleware::class);
};
