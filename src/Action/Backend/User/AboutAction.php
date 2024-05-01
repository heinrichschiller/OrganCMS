<?php

declare(strict_types=1);

namespace App\Action\Backend\User;

use App\Domain\User\Service\UserFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
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
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
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
