<?php

/**
 * MIT License
 *
 * Copyright (c) 2020 - 2021 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

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
    $app->group('/users', function(RouteCollectorProxy $group) {
        $group->get('/', \App\Actions\User\UserAction::class)->setName('users');
        $group->get('/user', \App\Actions\User\AboutAction::class)->setName('users');
        $group->post('/user/update', \App\Actions\User\UserUpdateAction::class)->setName('users');
        $group->get('/logout', \App\Actions\Auth\LogoutAction::class)->setName('logout');

        $group->get('/donation', \App\Actions\Donation\DonationBoardAction::class)->setName('donation');
        $group->post('/donation/update', \App\Actions\Donation\DonationUpdateAction::class)->setName('users');

    })->add(UserAuthMiddleware::class);

    $app->get('/', \App\Actions\Pages\IndexAction::class);

    $app->get('/login', \App\Actions\Auth\LoginAction::class)->setName('login');
    $app->post('/login', \App\Actions\Auth\LoginSubmitAction::class);

    // $app->post('/send', \App\Actions\Donation\CreateAction::class);

    $app->get('/{page}', \App\Actions\Pages\PagesAction::class);    
};