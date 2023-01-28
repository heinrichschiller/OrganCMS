<?php

declare(strict_types=1);

namespace App\Actions\Supporter;

use App\Domain\Supporter\Service\SupporterDeleter;
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
     * @var SupporterDeleter
     */
    private SupporterDeleter $deleter;

    /**
     * The constructor.
     *
     */
    public function __construct(SessionInterface $session, SupporterDeleter $deleter)
    {
        $this->session = $session;
        $this->deleter = $deleter;
    }

    /**
     * The invoker
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $id = (int) $args['id'];

        $this->deleter->delete($id);

        $flash = $this->session->getFlash();
        $flash->clear();
        $flash->add('success', 'Eintrag erfolgreich gelöscht.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('supporter');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
