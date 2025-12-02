<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Donation\Service;

use App\Domain\Donation\Data\DonationDetails;
use App\Domain\Donation\Repository\DonationDetailsRepository;
use App\Domain\Donation\Service\DonationDetailsFinder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DonationDetailsFinder::class)]
#[UsesClass(DonationDetails::class)]
class DonationDetailsFinderTest extends TestCase
{
    #[Test]
    public function donationDetailsReaderTest(): void
    {
        $repository = $this->createMock(DonationDetailsRepository::class);

        $repository->expects($this->once())
            ->method('findOne')->willReturn([
                'total' => '50.0',
                'date'  => '2025-11-01',
                'user' => 'mustermann'
        ]);

        $service = new DonationDetailsFinder($repository);

        $details = $service->findOne();

        $this->assertInstanceOf(DonationDetails::class, $details);
    }
}
