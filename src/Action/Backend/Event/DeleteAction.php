<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventDeleter;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class DeleteAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var EventDeleter
     */
    private EventDeleter $deleter;

    /**
     * The constructor.
     *
     * @param SessionInterface $session Odan session interface
     * @param EventDeleter $deleter Support deleter service
     */
    public function __construct(SessionInterface $session, EventDeleter $deleter)
    {
        $this->session = $session;
        $this->deleter = $deleter;
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
        $id = (int) $request->getAttribute('id');
        $isDeleted = $this->deleter->delete($id);

        $key = 'success';
        $message = 'Eintrag erfolgreich gelöscht.';
        if (!$isDeleted) {
            $key = 'error';
            $message = 'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht gelöscht werden.';
        }

        $flash = $this->session->getFlash();
        $flash->clear();
        $flash->add($key, $message);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('events');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
