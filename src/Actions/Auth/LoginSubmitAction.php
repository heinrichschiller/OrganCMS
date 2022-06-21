<?php

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

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($user) {
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerateId();

            $this->session->set('user', $user);

            $urlFor ='users';
        } else {
            $flash = $this->session->getFlash();
            $flash->clear();
            $flash->add('failure', 'Unbekanntes Login oder Passwort.');

            $urlFor = 'login';
        }

        $url = $routeParser->urlFor($urlFor);

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
