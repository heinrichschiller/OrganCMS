<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Domain\Post\Service\PostFinder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class ReadAction
{
    private SessionInterface $session;

    /**
     * @Injection
     * @var PostFinder
     */
    private PostFinder $finder;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor.
     *
     * @param ViewInterface
     */
    public function __construct(SessionInterface $session, PostFinder $finder, ViewInterface $view)
    {
        $this->session = $session;
        $this->finder = $finder;
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $isSuccess = '';
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }

        $id = (int) $args['id'];

        $post = $this->finder->whereId($id);

        $data = [
            'post' => $post,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $response = $this->view->render($response, 'post/edit', $data);

        return $response;
    }
}
