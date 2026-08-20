<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Supporter\Service\SupporterDeleter;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class DeleteAction
{
    public function __construct(
        private SessionInterface $session,
        private SupporterDeleter $deleter
    ) {
    }

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
        $url = $routeParser->urlFor('supporter');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
