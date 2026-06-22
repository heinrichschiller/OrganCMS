<?php

declare(strict_types=1);

namespace App\Action\Backend\Dashboard;

use App\Domain\Dashboard\Service\DashboardReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class DashboardAction
{
    public function __construct(
        private DashboardReader $reader,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $data = $this->reader->read();

        $response = $this->renderer->renderBackend(
            $response,
            'admin/dashboard',
            $data
        );

        return $response;
    }
}
