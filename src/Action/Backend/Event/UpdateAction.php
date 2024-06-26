<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventUpdater;
use Fig\Http\Message\StatusCodeInterface;
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
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();

        $this->updater->update($formData);

        $flash = $this->session->getFlash();
        $flash->clear();

        $flash->add('success', 'Daten erfolgreich aktualisiert.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('read-event', ['id' => $formData['id']]);

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
