<?php

declare(strict_types=1);

use App\Middleware\User\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    /**
     *----------------------------------------------------------------------------
     * Frontend
     *----------------------------------------------------------------------------
    */

    $app->get('/', \App\Action\Frontend\Home\HomeAction::class);
    $app->get('/datenschutzerklaerung.html', \App\Action\Frontend\Dsgvo\DsgvoAction::class);
    $app->get('/gallerie.html', \App\Action\Frontend\Gallery\GalleryAction::class);
    $app->get('/impressum.html', \App\Action\Frontend\Imprint\ImprintAction::class);
    $app->get('/orgelakte.html', \App\Action\Frontend\OrganAct\OrganActAction::class);
    $app->get('/orgelfreunde.html', \App\Action\Frontend\OrganFriend\OrganFriendAction::class);
    $app->get('/unsere-orgel.html', \App\Action\Frontend\OurOrgan\OurOrganAction::class);
    $app->get('/veranstaltungen.html', \App\Action\Frontend\Event\EventAction::class);
    $app->get('/videos.html', \App\Action\Frontend\Movie\MovieAction::class);

    /**
     *----------------------------------------------------------------------------
     * Backend
     *----------------------------------------------------------------------------
     */

    $app->get('/organcms', \App\Action\Backend\Auth\LoginAction::class)->setName('organcms');
    $app->post('/organcms', \App\Action\Backend\Auth\LoginSubmitAction::class);

    $app->group('/dashboard', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Backend\Dashboard\DashboardAction::class)->setName('dashboard');
    })->add(UserAuthMiddleware::class);

    $app->group('/donation', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Backend\Donation\DonationDetailsAction::class)->setName('donation');
        $group->post('/update', \App\Action\Donation\UpdateAction::class)->setName('donation');
    })->add(UserAuthMiddleware::class);

    $app->group('/event', function (RouteCollectorProxy $group) {
        $group->get('/all', \App\Action\Backend\Event\EventAction::class)->setName('events');
        $group->get('/new', \App\Action\Backend\Event\NewAction::class);
        $group->get('/read/{id}', \App\Action\Backend\Event\ReadAction::class)->setName('read-event');
        $group->get('/delete/{id}', \App\Action\Backend\Event\DeleteAction::class);
        $group->post('/create', \App\Action\Backend\Event\CreateAction::class);
        $group->post('/update', \App\Action\Backend\Event\UpdateAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/settings', function (RouteCollectorProxy $group) {
        $group->get('/general', \App\Action\Backend\Settings\GeneralAction::class);
        $group->get('/dsgvo', \App\Action\Backend\Settings\GeneralAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/dsgvo', function (RouteCollectorProxy $group) {
        $group->get('/read', \App\Action\Backend\Dsgvo\ReadAction::class)->setName('dsgvo');
        $group->post('/update', \App\Action\Backend\Dsgvo\UpdateAction::class);
    })->add(UserAuthMiddleware::class);

    $app->group('/supporter', function (RouteCollectorProxy $group) {
        $group->get('/', \App\Action\Backend\Supporter\SupporterAction::class)->setName('supporter');
        $group->get('/new', \App\Action\Backend\Supporter\NewSupporterAction::class)->setName('new-supporter');
        $group->get('/edit/{id}', \App\Action\Backend\Supporter\ReadAction::class);
        $group->get('/delete/{id}', \App\Action\Backend\Supporter\DeleteAction::class);
        $group->post('/create', \App\Action\Backend\Supporter\CreateAction::class);
        $group->post('/update', \App\Action\Backend\Supporter\UpdateAction::class);
    });

    $app->group('/user', function (RouteCollectorProxy $group) {
        $group->get('/user', \App\Action\Backend\User\AboutAction::class)->setName('users');
        $group->post('/user/update', \App\Action\User\UpdateAction::class)->setName('users');
        $group->get('/logout', \App\Action\Backend\Auth\LogoutAction::class)->setName('logout');
    })->add(UserAuthMiddleware::class);
};
