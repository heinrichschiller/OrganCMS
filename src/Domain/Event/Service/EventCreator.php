<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Repository\EventRepository;
use App\Domain\Event\Service\EventValidator;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

final class EventCreator
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
     * The contstructor.
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
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->eventValidator = $eventValidator;
    }

    /**
     * Create an event entry
     *
     * @param array<mixed> $formData
     *
     * @return bool
     */
    public function create(array $formData): bool
    {
        $this->validate($formData);

        $event = $this->getEvent($formData);

        try {
            $this->repository->createEvent($event);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventCreator->create(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventCreator->create(): %s", $e->getMessage()));
            
            return false;
        }
    }

    /**
     * Get event object.
     *
     * @param array<string> $formData The form data.
     *
     * @return Event
     */
    private function getEvent(array $formData): Event
    {
        $reader = new ArrayReader($formData);

        if (!isset($formData['is_published'])) {
            $formData['is_published'] = '';
        }

        $id = null;
        $title = $reader->findString('title');
        $place = $reader->findString('place');
        $content = $reader->findString('content');
        $eventDate = $reader->findChronos('event_date');
        $isPublished = $reader->findBool('is_published');

        $publishedAt = $isPublished ? new DateTimeImmutable(date('Y-m-d H:i:s')) : null;
        $createdAt = new DateTimeImmutable(date('Y-m-d H:i:s'));

        $event = new Event(
            id: $id,
            title: $title,
            place: $place,
            content: $content,
            eventDate: $eventDate,
            isPublished: $isPublished,
            publishedAt: $publishedAt,
            createdAt: $createdAt
        );

        return $event;
    }

    /**
     * Validate data
     *
     * @param array<mixed> $formData
     */
    public function validate(array $formData): void
    {
        $this->eventValidator->validateEvent($formData);
    }
}
