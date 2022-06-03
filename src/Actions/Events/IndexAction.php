<?php

declare(strict_types=1);

namespace App\Actions\Events;

use App\Domain\Event\Service\EventFinder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $finder;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor.
     *
     * @param EventFinder $finder
     * @param SessionInterface $session
     * @param ViewInterface $view
     */
    public function __construct(
        EventFinder $finder,
        SessionInterface $session,
        ViewInterface $view
    ) {
        $this->finder = $finder;
        $this->session = $session;
        $this->view = $view;
    }

    /**
     * The invoker.
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $isSuccess = false;
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }

        $flash->clear();

        $events = $this->finder->findAll();

        $data = [
            'events' => $events,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $response = $this->view->render($response, 'event/index', $data);
        
        return $response;
    }
}
