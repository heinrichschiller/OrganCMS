<?php

declare(strict_types=1);

namespace App\Domain\Dashboard\Service;

use App\Domain\Donation\Service\DonationDetailsReader;
use App\Domain\Event\Service\EventFinder;

final class DashboardReader
{
    /**
     * @Injection
     * @var DonationDetailsReader
     */
    private DonationDetailsReader $reader;

    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $finder;

    /**
     * The constructor
     *
     * @param DonationDetailsReader $reader
     * @param EventFinder $finder,
     */
    public function __construct(DonationDetailsReader $reader, EventFinder $finder)
    {
        $this->reader = $reader;
        $this->finder = $finder;
    }

    /**
     * Read all informations for the dashboard
     *
     * @return array
     */
    public function read(): array
    {
        $donation = $this->reader->read();
        $event = $this->finder->findPublishedEvents();

        return [
            'user' => '',
            'donation' => $donation,
            'event' => $event
        ];
    }
}
