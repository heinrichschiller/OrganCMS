<?php

declare (strict_types=1);

namespace App\Action\Imprint;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ImprintAction
{
    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(TemplateRenderer $renderer)
    {
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
        $response = $this->renderer->render($response, 'imprint/imprint.html', []);

        return $response;
    }
}
