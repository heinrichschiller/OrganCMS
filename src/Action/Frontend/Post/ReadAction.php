<?php

declare(strict_types=1);

namespace App\Action\Frontend\Post;

use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
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
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $post = $this->finder->findByIdOrFail($id);

        $data = [
            'post' => $post
        ];

        $response = $this->renderer->render($response, 'frontend/post/single-post', $data);
        
        return $response;
    }
}
