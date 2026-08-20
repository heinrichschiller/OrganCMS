<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Exception\EventValidationException;
use App\Domain\Event\Repository\EventRepository;
use App\Domain\Event\Service\EventValidator;
use DateTimeImmutable;
use DomainException;
use Selective\ArrayReader\ArrayReader;

final class EventUpdater
{
    public function __construct(
        private EventRepository $repository,
        private EventValidator $eventValidator
    ) {
    }

    /**
     * @param array{} $formData The form data
     */
    public function update(int $id, array $formData): void
    {
        $errors = $this->validateEventUpdate($id, $formData);

        if ($errors !== []) {
            throw new EventValidationException($errors);
        }

        $event = $this->transformDataToEvent($id, $formData);

        $this->repository->update($event);
    }

    /**
     * @param array<string> $formData
     */
    private function transformDataToEvent(int $id, array $formData): Event
    {
        $reader = new ArrayReader($formData);

        $event = new Event(
            id: $id,
            title: $reader->findString('title'),
            place: $reader->findString('place'),
            content: $reader->findString('content'),
            eventDate: $reader->findChronos('event_date'),
            isPublished: $reader->findBool('is_published') ? true : false,
            updatedAt: new DateTimeImmutable()
        );

        return $event;
    }

    /**
     * @param array<mixed> $formData The form data
     */
    public function validateEventUpdate(int $id, array $formData): array
    {
        if (!$this->repository->existsEventId($id)) {
            throw new DomainException(sprintf(
                'Event nicht gefunden: %s',
                $id
            ));
        }

        return $this->eventValidator->validateEvent($formData);
    }
}
