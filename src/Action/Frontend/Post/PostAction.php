<?php

declare(strict_types=1);

namespace App\Action\Frontend\Post;

use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class PostAction
{
    /**
     * @Injection
     * @var PostFinder
     */
    private PostFinder $finder;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param PostFinder $finder Post finder service
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(PostFinder $finder, TemplateRenderer $renderer)
    {
        $this->finder = $finder;
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
        $postItems = $this->finder->findAllPublicPosts();

        $data = [
            'post' => $postItems
        ];

        $response = $this->renderer->render($response, 'frontend/post/index.html', $data);

        return $response;
    }
}
