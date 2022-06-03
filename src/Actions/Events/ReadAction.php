<?php

declare(strict_types=1);

namespace App\Actions\Events;

use App\Domain\Event\Service\EventFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class ReadAction
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
     * The contstructor.
     * 
     * @param EventFinder $finder
     * @param ViewInterface $view
     */
    public function __construct(EventFinder $finder, ViewInterface $view)
    {
        $this->finder = $finder;
        $this->view = $view;
    }

    /**
     * The invoker.
     * 
     * @param Request $request
     * @param Response $response
     * @param array<mixed>
     * 
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $id = (int) $args['id'];

        $event = $this->finder->whereId($id);

        $data = [
            'event' => $event
        ];

        $response = $this->view->render($response, 'event/update', $data);

        return $response;
    }
}
