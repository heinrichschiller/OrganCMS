<?php

declare(strict_types=1);

namespace App\Actions\Events;

use App\Domain\Event\Service\EventFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class PublicEventAction
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
    private ViewInterface $view;

    /**
     * The constructor.
     *
     * @param EventFinder $finder   EventFinder service
     * @param ViewInterface $view   Template engine
     */
    public function __construct(EventFinder $finder, ViewInterface $view)
    {
        $this->finder = $finder;
        $this->view = $view;
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

        $response = $this->view->render($response, 'veranstaltungen', $data);
        
        return $response;
    }
}
