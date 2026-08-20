<?php

declare (strict_types=1);

namespace App\Action\Frontend\Imprint;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class ImprintAction
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $response = $this->renderer->renderFrontend(
            $response,
            'page/imprint/detail',
            []
        );

        return $response;
    }
}
