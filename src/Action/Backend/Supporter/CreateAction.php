<?php

declare(strict_types=1);

namespace App\Action\Supporter;

use App\Domain\Supporter\Service\SupporterCreator;
use Fig\Http\Message\StatusCodeInterface;
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
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();
        
        $isCreated = $this->creator->insert($formData);

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
        $url = $routeParser->urlFor('supporter');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
