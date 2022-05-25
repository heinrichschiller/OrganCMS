<?php

declare(strict_types=1);

use App\Middleware\User\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

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
    $app->group('/donation', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\Donation\DonationBoardAction::class)->setName('donation');
        $group->post('/update', \App\Actions\Donation\DonationUpdateAction::class)->setName('donation');
    })->add(UserAuthMiddleware::class);

    $app->group('/events', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\Events\IndexAction::class)->setName('events');
        $group->get('/new', \App\Actions\Events\NewEventAction::class)->setName('events');
        $group->post('/create', \App\Actions\Events\CreateAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/users', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\User\UserAction::class)->setName('users');
        $group->get('/user', \App\Actions\User\AboutAction::class)->setName('users');
        $group->post('/user/update', \App\Actions\User\UserUpdateAction::class)->setName('users');
        $group->get('/logout', \App\Actions\Auth\LogoutAction::class)->setName('logout');
    })->add(UserAuthMiddleware::class);

    $app->get('/', \App\Actions\Pages\IndexAction::class);

    $app->get('/login', \App\Actions\Auth\LoginAction::class)->setName('login');
    $app->post('/login', \App\Actions\Auth\LoginSubmitAction::class);

    // $app->post('/send', \App\Actions\Donation\CreateAction::class);

    $app->get('/veranstaltungen.html', \App\Actions\Events\PublicEventAction::class);
    $app->get('/{page}', \App\Actions\Pages\PagesAction::class);    
};