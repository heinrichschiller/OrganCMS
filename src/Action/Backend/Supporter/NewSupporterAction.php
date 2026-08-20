<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class NewSupporterAction
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $response = $this->renderer->render(
            $response,
            'backend/supporter/create',
            []
        );

        return $response;
    }
}
