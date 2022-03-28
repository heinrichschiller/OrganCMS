<?php

/**
 * MIT License
 *
 * Copyright (c) 2022 Heinrich Schiller
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

namespace App\Actions\Auth;

use App\Domain\User\Service\Authenticator;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class LoginSubmitAction
{
    /**
     * @Injection
     * @var Authenticator
     */
    private Authenticator $auth;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * The constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(Authenticator $auth, SessionInterface $session)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    /**
     * The invoker
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = (array) $request->getParsedBody();

        $username = (string) ($data['username'] ?? '');
        $password = (string) ($data['password'] ?? '');

        $user = null;
        
        $this->auth->authenticate($username, $password);

        if ($this->auth->isAuth()) {
            $user = $this->auth->getUsername();
        }

        $flash = $this->session->getFlash();
        $flash->clear();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($user) {
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerateId();

            $this->session->set('user', $user);
            $flash->add('success', 'Login successfully');

            $urlFor ='users';
        } else {
            $flash->add('error', 'Login failed!');

            $urlFor = 'login';
        }

        $url = $routeParser->urlFor($urlFor);

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
