<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Repository\EventRepository;
use App\Domain\Event\Service\EventValidator;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use DomainException;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

use function sprintf;

final class EventUpdater
{
    /**
     * @Injection
     * @var EventRepository
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
     * @param EventRepository $repository
     * @param LoggerFactory $loggerFactory
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(
        EventRepository $repository,
        LoggerFactory $loggerFactory,
        EventValidator $eventValidator
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('event_updater.log')->createLogger();
        $this->eventValidator = $eventValidator;
    }

    /**
     * Update event entry.
     *
     * @param array<string> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        $this->validateEventUpdate($formData);

        $event = $this->getEvent($formData);

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

    private function getEvent(array $formData): Event
    {
        $reader = new ArrayReader($formData);

        $id = $reader->findInt('id');
        $title = $reader->findString('title');
        $place = $reader->findString('place');
        $content = $reader->findString('content');
        $eventDate = $reader->findString('date');
        $isPublished = $reader->findBool('is_published');
        $updatedAt = new DateTimeImmutable(date('Y-m-d H:i:s'));
        
        $event = new Event(
            id: $id,
            title: $title,
            place: $place,
            content: $content,
            eventDate: $eventDate,
            isPublished: $isPublished,
            updatedAt: $updatedAt
        );

        return $event;
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
