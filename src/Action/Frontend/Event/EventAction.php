<?php

declare(strict_types=1);

namespace App\Action\Frontend\Event;

use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class EventAction
{
    public function __construct(
        private EventFinder $finder,
        private TemplateRenderer $renderer
    ) {
    }

    public function __invoke(Response $response): Response
    {
        $events = $this->finder->findPublishedEvents();

        $data = [
            'events' => $events
        ];

        $response = $this->renderer->renderFrontend(
            $response,
            'page/event/list.html',
            $data
        );
        
        return $response;
    }
}
