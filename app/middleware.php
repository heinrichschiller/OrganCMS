<?php

declare(strict_types=1);

use Odan\Session\Middleware\SessionMiddleware;
use App\Error\Renderer\HtmlErrorRenderer;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function(App $app)
{
    /*
     *----------------------------------------------------------------------------
     * Parse json, form data and xml
     *----------------------------------------------------------------------------
     */
    $app->addBodyParsingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->registerErrorRenderer('text/html', HtmlErrorRenderer::class);

    /*
     *----------------------------------------------------------------------------
     * Start Odan session
     *----------------------------------------------------------------------------
     */
    $app->add(SessionMiddleware::class);

    /*
     *----------------------------------------------------------------------------
     * Add the Slim built-in routing middleware
     *----------------------------------------------------------------------------
     */
    $app->addRoutingMiddleware();
        
    /*
     *----------------------------------------------------------------------------
     * Catch exceptions and errors
     *----------------------------------------------------------------------------
     */
    $app->add(ErrorMiddleware::class);

    
};