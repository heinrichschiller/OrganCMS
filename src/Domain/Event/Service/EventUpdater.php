<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Repository\EventRepository;
use App\Factory\LoggerFactory;
use App\Domain\Event\Service\EventValidator;
use DomainException;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

final class EventUpdater
{
    /**
     * @Injection
     * @var EventUpdaterRepository
     */
    private EventRepository $repository;

    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var EventValidator
     */
    private EventValidator $eventValidator;

    /**
     * The constructor.
     *
     * @param EventUpdaterRepository $repository
     * @param LoggerFactory $loggerFactory
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(
        EventRepository $repository,
        LoggerFactory $loggerFactory,
        EventValidator $eventValidator
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->eventValidator = $eventValidator;
    }

    /**
     * Update data
     *
     * @param array<mixed> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        $this->validateEventUpdate($formData);

        $reader = new ArrayReader($formData);

        $id = $reader->findInt('id');
        $title = $reader->findString('title');
        $place = $reader->findString('place');
        $desc = $reader->findString('desc');
        $date = $reader->findString('date');
        $isPublished = $reader->findBool('publish');
        
        $event = new Event(
            $id,
            $title,
            $place,
            $desc,
            $date,
            $isPublished,
            date('Y-m-d H:i:s')
        );

        try {
            $this->repository->update($event);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->update(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->update(): %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * Validate data
     *
     * @param array<mixed> $formData The form data
     */
    public function validateEventUpdate(array $formData): void
    {
        $eventId = (int) $formData['id'];

        if (!$this->repository->existsEventId($eventId)) {
            throw new DomainException(sprintf('Event nicht gefunden: %s', $eventId));
        }

        $this->eventValidator->validateEvent($formData);
    }
}
