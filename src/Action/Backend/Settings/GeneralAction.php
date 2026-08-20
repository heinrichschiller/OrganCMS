<?php

declare (strict_types=1);

namespace App\Action\Backend\Settings;

use App\Domain\Settings\Service\SettingsReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class GeneralAction
{
    public function __construct(
        private SettingsReader $reader,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $data = $this->reader->read();

        $response = $this->renderer->renderBackend(
            $response,
            'backend/settings/general',
            $data
        );

        return $response;
    }
}
