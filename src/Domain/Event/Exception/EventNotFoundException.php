<?php

declare(strict_types=1);

namespace App\Domain\Event\Exception;

use App\Domain\Exception\DomainRecordNotFoundException;

final class EventNotFoundException extends DomainRecordNotFoundException
{
    public function __construct(
        private int $eventId
    ) {
        parent::__construct(
            sprintf(
                'Event mit Id %d wurde nicht gefunden',
                $eventId
            )
        );
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }
}
