<?php

declare(strict_types=1);

namespace App\Domain\Event\Exception;

use App\Domain\Exception\DuplicateRecordException;

final class EventAlreadyExistsException extends DuplicateRecordException
{
    public function __construct(
        private string $eventName
    ) {
        parent::__construct(
            sprintf(
                'Ein Event mit dem Namen "%s" existiert bereits.',
                $eventName
            )
        );
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }
}
