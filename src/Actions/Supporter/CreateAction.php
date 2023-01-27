<?php

declare(strict_types=1);

namespace App\Actions\Supporter;

use App\Domain\Supporter\Service\SupporterCreator;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class CreateAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var SupporterCreator
     */
    private SupporterCreator $creator;

    /**
     * The constructor.
     *
     * @param SupporterCreator $creator Supporter creator service
     * @param SessionInterface $session Session interface
     */
    public function __construct(SupporterCreator $creator, SessionInterface $session)
    {
        $this->creator = $creator;
        $this->session = $session;
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
        
        $this->creator->insert($formData);

        $flash = $this->session->getFlash();
        $flash->clear();
        $flash->add('success', 'Eintrag erfolgreich angelegt.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('supporter');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
