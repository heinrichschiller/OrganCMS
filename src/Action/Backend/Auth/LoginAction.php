<?php

declare(strict_types = 1);

namespace App\Action\Backend\Auth;

use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginAction
{
    public function __construct(
        private SessionInterface $session,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $isFailure = false;
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('failure')) {
            $isFailure = true;
            $message = $flash->get('failure')[0];
        }

        $data = [
            'isFailure' => $isFailure,
            'message' => $message
        ];

        $response = $this->renderer->render(
            $response,
            'admin/user/login',
            $data,
            'login'
        );

        return $response;
    }
}
