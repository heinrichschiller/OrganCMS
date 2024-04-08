<?php

declare(strict_types=1);

namespace App\Action\Backend\User;

use App\Domain\User\Service\UserFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AboutAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * @Injection
     * @var UserFinder
     */
    private UserFinder $finder;

    /**
     * The constructor
     *
     * @param SessionInterface $session
     * @param TemplateRenderer $renderer
     * @param UserFinder $finder
     */
    public function __construct(
        SessionInterface $session,
        TemplateRenderer $renderer,
        UserFinder $finder
    ) {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->finder = $finder;
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
        $username = $this->session->get('user');

        $user = $this->finder->findByUsername($username);

        $data = [
            'user' => $user
        ];

        $response = $this->renderer->render($response, 'backend/user/about', $data);

        return $response;
    }
}
