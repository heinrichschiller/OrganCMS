<?php

declare(strict_types=1);

namespace App\Action\Frontend\Home;

use App\Domain\Home\Service\HomeReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeAction
{
    public function __construct(
        private HomeReader $reader,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        // $data = $this->reader->read();

        $response = $this->renderer->renderFrontend(
            $response,
            'page/homepage',
            [
                'title' => 'Startseite',
                'intro' => 'Willkommen bei Orgelfreunde Plauen',
                'body' => '<p>Neues aus Schlumpfenhausen...</p>',
            ]
        );

        return $response;
    }
}
