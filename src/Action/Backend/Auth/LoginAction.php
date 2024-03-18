<?php

declare(strict_types = 1);

namespace App\Action\Backend\Auth;

use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginAction
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
     * The constructor.
     *
     * @param SessionInterface $session
     * @param TemplateRenderer $renderer
     */
    public function __construct(SessionInterface $session, TemplateRenderer $renderer)
    {
        $this->session = $session;
        $this->renderer = $renderer;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
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

        $response = $this->renderer->render($response, 'backend/auth/login', $data);

        return $response;
    }
}
