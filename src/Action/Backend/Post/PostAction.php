<?php

declare(strict_types=1);

namespace App\Action\Backend\Post;

use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
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
     * @param PostFinder $finder Post finder service
     * @param SessionInterface $session Odan session interface
     * @param TemplateRenderer $renderer
     */
    public function __construct(
        PostFinder $finder,
        SessionInterface $session,
        TemplateRenderer $renderer
    ) {
        $this->finder = $finder;
        $this->session = $session;
        $this->renderer = $renderer;
    }

    /**
     * The invoker
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $isSuccess = false;
        $isError = false;
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }

        if ($flash->has('error')) {
            $isError = true;
            $message = $flash->get('error')[0];
        }

        $flash->clear();

        $postItems = $this->finder->findAll();

        $data = [
            'posts' => $postItems,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $response = $this->renderer->render($response, 'backend/post/index', $data);

        return $response;
    }
}
