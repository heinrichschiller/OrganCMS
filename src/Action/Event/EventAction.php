<?php

declare(strict_types=1);

namespace App\Action\Event;

use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class EventAction
{
    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $finder;

    /**
     * @Injection
     * @var ViewInterface
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param EventFinder $finder   EventFinder service
     * @param ViewInterface $view   Template engine
     */
    public function __construct(EventFinder $finder, TemplateRenderer $renderer)
    {
        $this->finder = $finder;
        $this->renderer = $renderer;
    }


    /**
     * The invoker
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $events = $this->finder->findPublishedEvents();

        $data = [
            'events' => $events
        ];

        $response = $this->renderer->render($response, 'event/public-events.html', $data);
        
        return $response;
    }
}
