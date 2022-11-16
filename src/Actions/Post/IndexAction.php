<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Domain\Post\Service\PostFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
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
     * @param ViewInterface $view
     */
    public function __construct(PostFinder $finder, ViewInterface $view)
    {
        $this->finder = $finder;
        $this->view = $view;
    }

    /**
     * The invoker.
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $postItems = $this->finder->findAll();

        $data = [
            'posts' => $postItems
        ];

        $this->response = $this->view->render($response, 'post/index', $data);

        return $this->response;
    }
}
