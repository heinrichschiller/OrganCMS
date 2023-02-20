<?php

declare(strict_types=1);

namespace App\Action\Supporter;

use App\Domain\Supporter\Service\SupporterUpdater;
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
     * @var SupporterUpdater
     */
    private SupporterUpdater $updater;

    /**
     * The constructor.
     *
     * @param SessionInterface $session Odan session
     * @param SupporterUpdater $updater Supporter updater service
     */
    public function __construct(SessionInterface $session, SupporterUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
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
        $formData = (array) $request->getParsedBody();

        $isUpdated = $this->updater->update($formData);

        $key = 'success';
        $message = 'Eintrag erfolgreich aktualisiert.';
        if (!$isUpdated) {
            $key = 'error';
            $message = 'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht aktualisiert werden.';
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
