<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\User\Service\UserReader;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class AboutAction
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
     * @Injection
     * @var UserReader
     */
    private UserReader $reader;

    /**
     * The constructor
     *
     * @param SessionInterface $session
     * @param ViewInterface $view
     */
    public function __construct(SessionInterface $session, ViewInterface $view, UserReader $reader)
    {
        $this->session = $session;
        $this->view = $view;
        $this->reader = $reader;
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
        $username = $this->session->get('user');

        $user = $this->reader->getByUsername($username);

        $data = [
            'user' => $user
        ];

        $response = $this->view->render($response, 'about', $data);

        return $response;
    }
}
