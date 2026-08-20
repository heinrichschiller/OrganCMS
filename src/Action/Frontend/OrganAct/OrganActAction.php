<?php

declare (strict_types=1);

namespace App\Action\Frontend\OrganAct;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class OrganActAction
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $response = $this->renderer->renderFrontend(
            $response,
            'frontend/organact/organ-act',
            []
        );

        return $response;
    }
}
