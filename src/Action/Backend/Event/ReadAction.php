<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Event\Exception\EventValidationException;
use App\Domain\Event\Service\EventFinder;
use App\Factory\LoggerFactory;
use App\Renderer\TemplateRenderer;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Throwable;

final class ReadAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private EventFinder $finder,
        private RedirectResponder $responder,
        private TemplateRenderer $renderer,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-read-error.log')
            ->createLogger();
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');

        try {
            if ($id <= 0) {
                throw new EventNotFoundException($id);
            }

            $event = $this->finder->findById($id);
        } catch (EventNotFoundException $e) {
            $this->logger->error(
                'Die Event-Daten konnten nicht gelesen werden.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error(
                sprintf(
                    'Event mit Id %d wurde nicht gefunden.',
                    $id
                )
            );

            return $this->responder->toRoute($response, 'events');
        } catch (EventValidationException $e) {
            $this->logger->error(
                'Logg Text %d',
                [
                        'exception' => $e
                    ]
            );

            $this->flash->error(
                sprintf(
                    'Dies ist Sparda!!! %d',
                    $id
                )
            );

            return $this->responder->toRoute($response, 'events');
        } catch (Throwable $t) {
            $this->logger->error(
                'Die Event-Daten konnten nicht gelesen werden.',
                [
                    'exception' => $t,
                ]
            );

            $this->flash->error(
                'Die Event-Daten konnten nicht gelesen werden.'
            );

            $event = new Event();
        }

        $response = $this->renderer->renderBackend(
            $response,
            'admin/event/read',
            [
                'event' => $event,
                'flash' => $this->flash->readStatus()
            ]
        );

        return $response;
    }
}
