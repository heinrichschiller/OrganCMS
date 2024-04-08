<?php

declare(strict_types=1);

namespace App\Action\Supporter;

use App\Domain\Supporter\Service\SupporterDeleter;
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
     * @var SupporterDeleter
     */
    private SupporterDeleter $deleter;

    /**
     * The constructor.
     *
     * @param SessionInterface $session Odan session interface
     * @param SupporterDeleter $deleter Support deleter service
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
        $url = $routeParser->urlFor('supporter');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
