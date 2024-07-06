<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use App\Domain\DomainException\DomainRecordNotFoundException;

class EventNotFoundException extends DomainRecordNotFoundException
{
    private $message = 'Event not found.';

    public function functionWithoutName()
    {
        return $this->message;
    }
}
