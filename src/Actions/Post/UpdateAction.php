<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Domain\Post\Service\PostUpdater;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UpdateAction
{
    private PostUpdater $updater;
    private SessionInterface $session;

    public function __construct(SessionInterface $session, PostUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $formData = (array) $request->getParsedBody();

        $this->updater->update($formData);

        $flash = $this->session->getFlash();
        $flash->clear();

        $flash->add('success', 'Beitrag erfolgreich aktualisiert.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('read-post', ['id' => $formData['id']]);
        
        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
