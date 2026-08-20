<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Exception\EventAlreadyExistsException;
use App\Domain\Event\Exception\EventValidationException;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Domain\Event\Repository\EventRepository;
use App\Domain\Event\Service\EventValidator;
use DateTimeImmutable;
use Selective\ArrayReader\ArrayReader;

final class EventCreator
{
    public function __construct(
        private EventRepository $repository,
        private EventFinderRepository $finderRepository,
        private EventValidator $eventValidator
    ) {
    }

    /**
     * @param array<mixed> $formData
     */
    public function create(array $formData): void
    {
        $errors = $this->validateEventCreate($formData);

        if ($errors !== []) {
            throw new EventValidationException($errors);
        }

        $event = $this->transformDataToEvent($formData);

        $this->repository->insertEvent($event);
    }

    /**
     * @param array<string> $formData The form data.
     */
    private function transformDataToEvent(array $formData): Event
    {
        $reader = new ArrayReader($formData);

        $isPublished = $reader->findBool('is_published') ? true : false;
        $publishedAt = $isPublished ? new DateTimeImmutable() : null;

        $event = new Event(
            id: null,
            title: $reader->findString('title'),
            place: $reader->findString('place'),
            content: $reader->findString('content'),
            eventDate: $reader->findChronos('event_date'),
            isPublished: $isPublished,
            publishedAt: $publishedAt,
            createdAt: new DateTimeImmutable()
        );

        return $event;
    }

    /**
     * @param array<mixed> $formData
     */
    public function validateEventCreate(array $formData): array
    {
        if ($this->finderRepository->findByName($formData['title']) !== []) {
            throw new EventAlreadyExistsException($formData['title']);
        }

        return $this->eventValidator->validateEvent($formData);
    }
}
