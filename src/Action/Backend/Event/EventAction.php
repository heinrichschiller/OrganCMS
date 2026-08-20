<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Service\EventFinder;
use App\Domain\Exception\DomainRecordNotFoundException;
use App\Factory\LoggerFactory;
use App\Renderer\TemplateRenderer;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class EventAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private EventFinder $finder,
        private TemplateRenderer $renderer,
        private RedirectResponder $responder,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-all-error.log')
            ->createLogger();
    }

    public function __invoke(Response $response): Response
    {
        try {
            $events = $this->finder->findAll();

            $data = [
                'events' => $events,
                'flash' => $this->flash->readStatus()
            ];

            return $this->renderer->renderBackend(
                $response,
                'admin/event/index',
                $data
            );
        } catch (DomainRecordNotFoundException $e) {
            $this->logger->error(
                'Event mit dem Namen existiert bereits.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error($e->getMessage());

            return $this->responder->toRoute(
                $response,
                'events',
                [],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        }
    }
}
