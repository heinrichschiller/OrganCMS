<?php

declare(strict_types=1);

use Slim\App;

/*
 *----------------------------------------------------------------------------
 * Set up routes with nikic/fast-route
 *----------------------------------------------------------------------------
 *
 * For more informations see: 
 * https://www.slimframework.com/docs/v4/objects/routing.html
 *
 */
return function(App $app)
{
    $app->get('/api/v1/work', \App\Actions\Donation\WorkFinderAction::class);
    $app->get('/api/v1/register/{register}', \App\Actions\Donation\RegisterFinderAction::class);
    $app->get('/api/v1/sound/{work}/{register}', \App\Actions\Donation\SoundFinderAction::class);
};