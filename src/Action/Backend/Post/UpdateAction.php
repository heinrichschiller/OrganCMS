<?php

declare(strict_types=1);

namespace App\Action\Backend\Post;

use App\Domain\Post\Service\PostUpdater;
use Odan\Session\SessionInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UpdateAction
{
    /**
     * @Injection
     * @var PostUpdater
     */
    private PostUpdater $updater;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * The constructor.
     *
     * @param SessionInterface $session Odan session interface
     * @param PostUpdater $updater Post updater service
     */
    public function __construct(SessionInterface $session, PostUpdater $updater)
    {
        $this->session = $session;
        $this->updater = $updater;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $user = $this->session->get('user');

        $formData = (array) $request->getParsedBody();
        $formData['author_id'] = $user->getId();

        $isUpdated = $this->updater->updatePost($formData);

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
        $url = $routeParser->urlFor('read-post', ['id' => $formData['id']]);
        
        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
