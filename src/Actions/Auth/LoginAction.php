<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class LoginAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor
     *
     * @param ViewInterface $view
     */
    public function __construct(SessionInterface $session, ViewInterface $view)
    {
        $this->session = $session;
        $this->view = $view;
    }

    /**
     * The invoker
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
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

        $response = $this->view->render($response, 'auth/login', $data);

        return $response;
    }
}
