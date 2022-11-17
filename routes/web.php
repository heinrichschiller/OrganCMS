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
        $group->get('/supporter', \App\Actions\Donation\SupporterAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/events', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\Events\IndexAction::class)->setName('events');
        $group->get('/new', \App\Actions\Events\NewEventAction::class)->setName('events');
        $group->get('/update/{id}', \App\Actions\Events\ReadAction::class)->setName('read-event');
        $group->post('/create', \App\Actions\Events\CreateAction::class);
        $group->post('/update', \App\Actions\Events\UpdateAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/posts', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\Post\IndexAction::class)->setName('posts');
        $group->get('/new', \App\Actions\Post\NewPostAction::class);
        $group->post('/create', \App\Actions\Post\CreateAction::class);
        $group->post('/update', \App\Actions\Post\UpdateAction::class);
        $group->get('/edit/{id}', \App\Actions\Post\ReadAction::class)->setName('read-post');
    })->add(UserAuthMiddleware::class);

    $app->group('/users', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\User\UserAction::class)->setName('users');
        $group->get('/user', \App\Actions\User\AboutAction::class)->setName('users');
        $group->post('/user/update', \App\Actions\User\UserUpdateAction::class)->setName('users');
        $group->get('/logout', \App\Actions\Auth\LogoutAction::class)->setName('logout');
    })->add(UserAuthMiddleware::class);

    $app->get('/', \App\Actions\Pages\IndexAction::class);

    $app->get('/organcms', \App\Actions\Auth\LoginAction::class)->setName('organcms');
    $app->post('/organcms', \App\Actions\Auth\LoginSubmitAction::class);

    $app->get('/neuigkeiten', \App\Actions\Post\ReadPublicPostsAction::class);
    $app->get('/blog/{id}/{slug}', \App\Actions\Post\ReadSinglePublicPostAction::class);
    $app->get('/veranstaltungen.html', \App\Actions\Events\PublicEventAction::class);
    $app->get('/impressum.html', \App\Actions\Imprint\PublicImprintAction::class);
    $app->get('/{page}', \App\Actions\Pages\PagesAction::class);    
};