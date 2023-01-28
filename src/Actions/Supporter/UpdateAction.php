<?php

declare(strict_types=1);

namespace App\Actions\Supporter;

use App\Domain\Supporter\Service\SupporterUpdater;
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
     * @param SessionInterface $sesson Odan session
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

        $this->updater->update($formData);

        $flash = $this->session->getFlash();
        $flash->clear();

        $flash->add('success', 'Beitrag erfolgreich aktualisiert.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('supporter', ['id' => $formData['id']]);

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
