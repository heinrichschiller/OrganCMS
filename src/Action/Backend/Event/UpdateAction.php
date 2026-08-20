<?php

declare(strict_types=1);

namespace App\Action\Backend\Event;

use App\Domain\Event\Exception\EventValidationException;
use App\Domain\Event\Service\EventUpdater;
use App\Factory\LoggerFactory;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class UpdateAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private EventUpdater $updater,
        private RedirectResponder $responder,
        LoggerFactory $loggerFactory,
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-updater-error.log')
            ->createLogger();
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');

        if ($id <= 0) {
            throw new RuntimeException('Ungültige Event Id!');
        }

        $formData = (array) $request->getParsedBody();

        try {
            $this->updater->update($id, $formData);

            $this->flash->success('Event erfolgreich aktualisiert');

            return $this->responder->toRoute(
                $response,
                'read-event',
                ['id' => $id],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        } catch (EventValidationException $e) {
            $message = $e->getMessages();

            $this->logger->error(
                'Die Validierung ist fehlgeschlagen.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error($message[0]);

            return $this->responder->toRoute(
                $response,
                'read-event',
                ['id' => $id],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        } catch (RuntimeException $e) {
            $message = $e->getMessage();

            $this->logger->error(
                'Die Validierung ist fehlgeschlagen.',
                [
                    'exception' => $e,
                ]
            );

            $this->flash->error($message[0]);

            return $this->responder->toRoute(
                $response,
                'read-event',
                ['id' => $id],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        }
    }
}
