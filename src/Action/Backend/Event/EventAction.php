<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
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
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param EventFinder $finder Event finder service.
     * @param SessionInterface $session Odan session interface.
     * @param TemplateRenderer $renderer Template renderer.
     */
    public function __construct(
        EventFinder $finder,
        SessionInterface $session,
        TemplateRenderer $renderer
    ) {
        $this->finder = $finder;
        $this->session = $session;
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
        $isSuccess = false;
        $isError = false;
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }

        if ($flash->has('error')) {
            $isError = true;
            $message = $flash->get('error')[0];
        }

        $flash->clear();

        $events = $this->finder->findAllOrFail();

        $data = [
            'events' => $events,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $response = $this->renderer->render($response, 'backend/event/index', $data);
        
        return $response;
    }
}
