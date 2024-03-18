<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
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
     * The contstructor.
     *
     * @param EventFinder $finder Event finder service
     * @param SessionInterface $session Odan session
     * @param TemplateRenderer $renderer
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
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $isSuccess = '';
        $message = '';

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }
        
        $flash->clear();

        $id = (int) $args['id'];

        $event = $this->finder->findById($id);

        $data = [
            'event' => $event,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $response = $this->renderer->render($response, 'backend/event/edit', $data);

        return $response;
    }
}
