<?php

declare(strict_types=1);

namespace App\Domain\Dashboard\Service;

use App\Domain\Event\Service\EventFinder;

final class DashboardReader
{
    private EventFinder $eventFinder;

    /**
     * @param EventFinder $eventFinder,
     */
    public function __construct(
        EventFinder $eventFinder
    ) {
        $this->eventFinder = $eventFinder;
    }

    /**
     * @return array<mixed>
     */
    public function read(): array
    {
        $event = $this->eventFinder->findPublishedEvents();

        return [
            'user' => '',
            'event' => $event
        ];
    }
}
