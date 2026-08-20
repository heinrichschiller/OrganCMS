<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Supporter\Service\SupporterUpdater;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UpdateAction
{
    public function __construct(
        private SessionInterface $session,
        private SupporterUpdater $updater
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
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
