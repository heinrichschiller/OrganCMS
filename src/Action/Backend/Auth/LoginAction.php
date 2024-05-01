<?php

declare(strict_types = 1);

namespace App\Action\Backend\Auth;

use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
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
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
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

        $response = $this->renderer->render($response, 'backend/auth/login', $data);

        return $response;
    }
}
