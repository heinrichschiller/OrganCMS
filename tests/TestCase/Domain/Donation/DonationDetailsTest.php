<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\DonationDetails;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(DonationDetails::class)]
#[CoversMethod(DonationDetails::class, 'getTotal')]
#[CoversMethod(DonationDetails::class, 'getDate')]
#[CoversMethod(DonationDetails::class, 'getUser')]
final class DonationDetailsTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testDonationInstance(): void
    {
        $this->assertInstanceOf(DonationDetails::class, new DonationDetails);
    }

    public function testTotalIsNullByDefault(): void
    {
        $donation = new DonationDetails;

        $this->assertNull($donation->getTotal());
    }

    public function testTotalHasInput(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertEquals('566.850,39', $donation->getTotal());
    }

    public function testTotalDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertEquals('566.850,39', $donation->getTotal());
    }

    public function testDateIsNullByDefault(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertNull($donation->getDate());
    }

    public function testDateHasInput(): void
    {
        $donation = new DonationDetails('566.850,39', '28.02.2022');

        $this->assertEquals('28.02.2022', $donation->getDate());
    }

    public function testDateDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ');

        $this->assertEquals('28.02.2022', $donation->getDate());
    }

    public function testUserIsNullByDefault(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ');

        $this->assertNull($donation->getUser());
    }

    public function testUserHasUsername(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ', 'heinrich');

        $this->assertEquals('heinrich', $donation->getUser());
    }

    public function testUserDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ', ' heinrich ');

        $this->assertEquals('heinrich', $donation->getUser());
    }

    public function testConvertToGermanDate(): void
    {
        $donation = new DonationDetails('566.850,39', ' 22-10-28 ', ' heinrich ');

        $this->assertEquals('28.10.22', $donation->getGermanDate());
    }
}
