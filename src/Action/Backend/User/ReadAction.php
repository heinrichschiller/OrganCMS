<?php

declare(strict_types=1);

namespace App\Action\Backend\User;

use App\Domain\User\Service\UserFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
{
    public function __construct(
        private SessionInterface $session,
        private TemplateRenderer $renderer,
        private UserFinder $finder
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $username = $this->session->get('user');

        $user = $this->finder->findByUsername($username);

        $data = [
            'user' => $user
        ];

        $response = $this->renderer->render(
            $response,
            'backend/user/about',
            $data
        );

        return $response;
    }
}
