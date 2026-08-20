<?php

declare(strict_types=1);

namespace App\Domain\Home\Service;

use App\Domain\Event\Service\EventFinder;
use App\Domain\Supporter\Service\SupporterFinder;

final class HomeReader
{
    public function __construct(
        private EventFinder $eventFinder,
        private SupporterFinder $supporterFinder
    ) {
    }

    /**
     * @return array<mixed>
     */
    public function read(): array
    {
        $limit = 5;

        // $events = $this->eventFinder->findLatestPublishedEvents($limit);
        $supporter = $this->supporterFinder->findAllPublicSupporter();

        return [
            // 'events' => $events,
            'supporter' => $supporter
        ];
    }
}
