<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Domain\User\Service\UserUpdater;
use Odan\Session\SessionInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UpdateAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var UserUpdater
     */
    private UserUpdater $updater;

    /**
     * The constructor.
     *
     * @param SessionInterface $session Odan session
     * @param UserUpdater $updater User updater service
     */
    public function __construct(SessionInterface $session, UserUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
    }
    
    /**
     * The invoker
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();

        $identity = (string) ($formData['username'] ?? '');
        $firstPassword = (string) ($formData['firstPassword'] ?? '');
        $repeatPassword = (string) ($formData['repeatPassword'] ?? '');

        $flash = $this->session->getFlash();
        $flash->clear();
        
        if ($firstPassword === $repeatPassword) {
            $isUpdated = $this->updater->update($identity, $firstPassword);

            if ($isUpdated()) {
                $flash->add('success', 'Benutzer erfolgreich aktualisiert.');
            } else {
                $flash->add('error', 'Fehler. Aktualisierung fehlgeschlagen.');
            }
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('users');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
