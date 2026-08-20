<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Event\Service\EventDeleter;
use App\Factory\LoggerFactory;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class DeleteAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private EventDeleter $deleter,
        private RedirectResponder $responder,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-delete-error.log')
            ->createLogger();
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');

        try {
            if ($id <= 0) {
                throw new EventNotFoundException($id);
            }

            $this->deleter->delete($id);

            $this->flash->success(
                sprintf(
                    'Event %d erfolgreich gelöscht.',
                    $id
                )
            );

            return $this->responder->toRoute(
                $response,
                'events',
                ['id' => $id],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        } catch (EventNotFoundException $e) {
            $message = $e->getMessage();

            $this->logger->error(
                'Event nicht gefunden.',
                [
                    'exception' => $e
                ]
            );

            $this->flash->error($message[0]);

            return $this->responder->toRoute(
                $response,
                'events',
                ['id' => $id],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        }
    }
}
