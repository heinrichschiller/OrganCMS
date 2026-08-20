<?php

declare (strict_types=1);

namespace App\Action\Frontend\Dsgvo;

use App\Domain\Dsgvo\Service\DsgvoFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class DsgvoAction
{
    public function __construct(
        private DsgvoFinder $finder,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $dsgvo = $this->finder->find();

        $response = $this->renderer->renderFrontend(
            $response,
            'page/dsgvo/detail.html',
            [
                'dsgvo' => $dsgvo,
            ]
        );

        return $response;
    }
}
