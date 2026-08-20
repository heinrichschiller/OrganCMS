<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Supporter\Service\SupporterFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
{
    public function __construct(
        private SupporterFinder $finder,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $supporter  = $this->finder->findById($id);

        $data = [
            'supporter' => $supporter
        ];

        $response = $this->renderer->render(
            $response,
            'backend/supporter/edit',
            $data
        );

        return $response;
    }
}
