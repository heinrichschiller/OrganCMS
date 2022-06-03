<?php

declare(strict_types=1);

namespace App\Actions\Events;

use App\Domain\Event\Service\EventUpdater;
use Odan\Session\SessionInterface;
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
     * @var EventUpdater
     */
    private EventUpdater $updater;

    /**
     * The constructor.
     * 
     * @param SessionInterface $session
     * @param EventUpdater $updater
     */
    public function __construct(SessionInterface $session, EventUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
    }

    /**
     * The invoker.
     * 
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     * 
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $formData = (array) $request->getParsedBody();

        $this->updater->update($formData);

        $flash = $this->session->getFlash();
        $flash->clear();

        $flash->add('success', 'Daten erfolgreich aktualisiert.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('read-event', ['id' => $formData['id']]);

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
