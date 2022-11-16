<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Domain\Post\Service\PostCreator;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class CreateAction
{
    private PostCreator $creator;
    private SessionInterface $session;

    /**
     * The constructor.
     *
     * @param PostCreator $creator Post creator service.
     */
    public function __construct(PostCreator $creator, SessionInterface $session)
    {
        $this->creator = $creator;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $formData = $request->getParsedBody();

        $this->creator->create($formData);

        $flash = $this->session->getFlash();
        $flash->clear();
        $flash->add('success', 'Eintrag erfolgreich angelegt.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('posts');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
