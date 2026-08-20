<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Exception\EventAlreadyExistsException;
use App\Domain\Event\Exception\EventValidationException;
use App\Domain\Event\Service\EventCreator;
use App\Factory\LoggerFactory;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class CreateAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private EventCreator $creator,
        private LoggerFactory $loggerFactory,
        private RedirectResponder $responder,
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-creator-error.log')
            ->createLogger();
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();

        try {
            $this->creator->create($formData);

            $this->flash->success('Event erfolgreich erstellt.');

            return $this->responder->toRoute(
                $response,
                'events',
                [],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        } catch (EventAlreadyExistsException $e) {
            $this->logger->error(
                'Event mit dem Namen existiert bereits.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error(
                sprintf(
                    'Event mit dem Namen "%s" existiert bereits.',
                    $e->getEventName()
                )
            );

            return $this->responder->toRoute(
                $response,
                'create-event',
                [],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        } catch (EventValidationException $e) {
            $this->logger->error(
                'Event Validierung.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error($e->getMessages()[0]);

            return $this->responder->toRoute(
                $response,
                'create-event',
                [],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        }
    }
}
