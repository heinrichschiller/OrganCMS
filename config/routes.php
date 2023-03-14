<?php

declare(strict_types=1);

use App\Middleware\User\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class);
    $app->get('/blog/{id}/{slug}.html', \App\Action\Post\ReadSinglePublicPostAction::class);
    $app->get('/datenschutzerklaerung.html', \App\Action\Dsgvo\DsgvoAction::class);
    $app->get('/gallerie.html', \App\Action\Gallery\GalleryAction::class);
    $app->get('/impressum.html', \App\Action\Imprint\ImprintAction::class);
    $app->get('/neuigkeiten.html', \App\Action\Post\PublicPostAction::class);
    $app->get('/orgelakte.html', \App\Action\OrganAct\OrganActAction::class);
    $app->get('/orgelfreunde.html', \App\Action\OrganFriend\OrganFriendAction::class);
    $app->get('/unsere-orgel.html', \App\Action\OurOrgan\OurOrganAction::class);
    $app->get('/veranstaltungen.html', \App\Action\Event\PublicEventAction::class);
    $app->get('/videos.html', \App\Action\Movie\MovieAction::class);

    $app->get('/organcms', \App\Action\Auth\LoginAction::class)->setName('organcms');
    $app->post('/organcms', \App\Action\Auth\LoginSubmitAction::class);

    $app->group('/dashboard', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Dashboard\DashboardAction::class)->setName('dashboard');
    })->add(UserAuthMiddleware::class);

    $app->group('/donation', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Donation\DonationDetailsAction::class)->setName('donation');
        $group->post('/update', \App\Action\Donation\UpdateAction::class)->setName('donation');
    })->add(UserAuthMiddleware::class);

    $app->group('/event', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Event\EventAction::class)->setName('events');
        $group->get('/new', \App\Action\Event\NewEventAction::class)->setName('events');
        $group->get('/read/{id}', \App\Action\Event\ReadAction::class)->setName('read-event');
        $group->get('/delete/{id}', \App\Action\Event\DeleteAction::class);
        $group->post('/create', \App\Action\Event\CreateAction::class);
        $group->post('/update', \App\Action\Event\UpdateAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/post', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Post\PostAction::class)->setName('posts');
        $group->get('/new', \App\Action\Post\NewPostAction::class);
        $group->post('/create', \App\Action\Post\CreateAction::class);
        $group->post('/update', \App\Action\Post\UpdateAction::class);
        $group->get('/edit/{id}', \App\Action\Post\ReadAction::class)->setName('read-post');
        $group->get('/delete/{id}', \App\Action\Post\DeleteAction::class)->setName('read-post');
    })->add(UserAuthMiddleware::class);

    $app->group('/supporter', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Supporter\SupporterAction::class)->setName('supporter');
        $group->get('/new', \App\Action\Supporter\NewSupporterAction::class);
        $group->get('/edit/{id}', \App\Action\Supporter\ReadAction::class);
        $group->get('/delete/{id}', \App\Action\Supporter\DeleteAction::class);
        $group->post('/create', \App\Action\Supporter\CreateAction::class);
        $group->post('/update', \App\Action\Supporter\UpdateAction::class);
    });

    $app->group('/user', function (RouteCollectorProxy $group) {
        $group->get('/user', \App\Action\User\AboutAction::class)->setName('users');
        $group->post('/user/update', \App\Action\User\UpdateAction::class)->setName('users');
        $group->get('/logout', \App\Action\Auth\LogoutAction::class)->setName('logout');
    })->add(UserAuthMiddleware::class);
};
