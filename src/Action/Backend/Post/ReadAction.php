<?php

declare(strict_types=1);

namespace App\Action\Backend\Post;

use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
{
    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

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
     * @param SessionInterface $session Odan session interface.
     * @param PostFinder $finder Post finder service
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(
        SessionInterface $session,
        PostFinder $finder,
        TemplateRenderer $renderer
    ) {
        $this->session = $session;
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
        $isSuccess = '';
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

        $id = (int) $request->getAttribute('id');
        $post = $this->finder->findByIdOrFail($id);

        $data = [
            'post' => $post,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $response = $this->renderer->render($response, 'backend/post/edit', $data);

        return $response;
    }
}
