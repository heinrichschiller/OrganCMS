<?php

declare(strict_types=1);

namespace App\Action\Backend\Auth;

use App\Domain\User\Service\Authenticator;
use Odan\Session\SessionInterface;
use Fig\Http\Message\StatusCodeInterface;
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
     * @param Authenticator $auth
     * @param SessionInterface $session
     */
    public function __construct(Authenticator $auth, SessionInterface $session)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $formData = (array) $request->getParsedBody();

        $username = (string) ($formData['username'] ?? '');
        $password = (string) ($formData['password'] ?? '');

        $user = null;
        
        $this->auth->authenticate($username, $password);

        if ($this->auth->isAuth()) {
            $user = $this->auth->getUser();
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($user) {
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerateId();

            $this->session->set('user', $user);

            $urlFor ='dashboard';
        } else {
            $flash = $this->session->getFlash();
            $flash->clear();
            $flash->add('failure', 'Unbekanntes Login oder Passwort.');

            $urlFor = 'organcms';
        }

        $url = $routeParser->urlFor($urlFor);

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
