<?php

declare(strict_types=1);

namespace App\Actions\Events;

use App\Domain\Event\Service\EventCreator;
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
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = (array) $request->getParsedBody();

        $this->creator->create($data);

        $flash = $this->session->getFlash();
        $flash->clear();
        $flash->add('success', 'Event erfolgreich angelegt.');
        
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('events');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
