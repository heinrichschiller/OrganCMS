<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Renderer\TemplateRenderer;
use App\Support\CustomFlash;
use Psr\Http\Message\ResponseInterface as Response;

final class NewAction
{
    public function __construct(
        private CustomFlash $flash,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $response = $this->renderer->renderBackend(
            $response,
            'admin/event/new',
            [
                'flash' => $this->flash->readStatus(),
            ]
        );
        
        return $response;
    }
}
