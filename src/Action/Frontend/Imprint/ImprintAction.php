<?php

declare (strict_types=1);

namespace App\Action\Frontend\Imprint;

use App\Renderer\TemplateRenderer;
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
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
    {
        $response = $this->renderer->render($response, 'frontend/imprint/imprint.html', []);

        return $response;
    }
}
