<?php

declare(strict_types=1);

namespace App\Action\Frontend\Event;

use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

final class PublicEventAction
{
    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $finder;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param EventFinder $finder EventFinder service
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(EventFinder $finder, TemplateRenderer $renderer)
    {
        $this->finder = $finder;
        $this->renderer = $renderer;
    }


    /**
     * The invoker.
     *
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
    {
        $events = $this->finder->findPublishedEvents();

        $data = [
            'events' => $events
        ];

        $response = $this->renderer->render($response, 'event/public-events.html', $data);
        
        return $response;
    }
}
