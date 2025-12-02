<?php

declare(strict_types=1);

namespace App\Domain\Dashboard\Service;

use App\Domain\Donation\Service\DonationDetailsFinder;
use App\Domain\Event\Service\EventFinder;

final class DashboardReader
{
    /**
     * @Injection
     * @var DonationDetailsFinder
     */
    private DonationDetailsFinder $detailsFinder;

    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $eventFinder;

    /**
     * The constructor
     *
     * @param DonationDetailsFinder $detailsFinder
     * @param EventFinder $eventFinder,
     */
    public function __construct(
        DonationDetailsFinder $detailsFinder,
        EventFinder $eventFinder
    ) {
        $this->detailsFinder = $detailsFinder;
        $this->eventFinder = $eventFinder;
    }

    /**
     * Read all informations for the dashboard
     *
     * @return array<mixed>
     */
    public function read(): array
    {
        $donation = $this->detailsFinder->findOne();
        $event = $this->eventFinder->findPublishedEvents();

        return [
            'user' => '',
            'donation' => $donation,
            'event' => $event
        ];
    }
}
