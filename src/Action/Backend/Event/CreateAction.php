<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventCreator;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class CreateAction
{
    /**
     * @Injection
     * @var EventCreator
     */
    private EventCreator $creator;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * The constructor.
     *
     * @param EventCreator $creator Event creator service
     * @param SessionInterface $session
     */
    public function __construct(EventCreator $creator, SessionInterface $session)
    {
        $this->creator = $creator;
        $this->session = $session;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $data = (array) $request->getParsedBody();

        $isCreated = $this->creator->create($data);

        $key = 'success';
        $message = 'Eintrag erfolgreich angelegt.';
        if (!$isCreated) {
            $key = 'error';
            $message = 'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht gespeichert werden.';
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
