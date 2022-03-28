<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\User\Service\UserUpdater;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UserUpdateAction
{
    private SessionInterface $session;
    private UserUpdater $updater;

    public function __construct(SessionInterface $session, UserUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = $request->getParsedBody();

        $identity = (string) ($data['username'] ?? '');
        $firstPassword = (string) ($data['firstPassword'] ?? '');
        $repeatPassword = (string) ($data['repeatPassword'] ?? '');

        $flash = $this->session->getFlash();
        $flash->clear();
        
        if ($firstPassword === $repeatPassword) {
            $this->updater->update($identity, $firstPassword);

            if ($this->updater->isUpdated()) {
                $flash->add('success', 'User successfully updated.');
            } else {
                $flash->add('failure', 'User update failed.');
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('users');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
