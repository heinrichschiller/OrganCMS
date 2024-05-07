<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\DonationDetails;
use PHPUnit\Framework\TestCase;

final class DonationDetailsTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testDonationInstance(): void
    {
        $this->assertInstanceOf(DonationDetails::class, new DonationDetails);
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testTotalIsNullByDefault(): void
    {
        $donation = new DonationDetails;

        $this->assertNull($donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testTotalHasInput(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertEquals('566.850,39', $donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testTotalDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertEquals('566.850,39', $donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testDateIsNullByDefault(): void
    {
        $donation = new DonationDetails('566.850,39');

        $this->assertNull($donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testDateHasInput(): void
    {
        $donation = new DonationDetails('566.850,39', '28.02.2022');

        $this->assertEquals('28.02.2022', $donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testDateDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ');

        $this->assertEquals('28.02.2022', $donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testUserIsNullByDefault(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ');

        $this->assertNull($donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testUserHasUsername(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ', 'heinrich');

        $this->assertEquals('heinrich', $donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testUserDoesNotStartOrEndWithWhitespace(): void
    {
        $donation = new DonationDetails('566.850,39', ' 28.02.2022 ', ' heinrich ');

        $this->assertEquals('heinrich', $donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationDetails
     */
    public function testConvertToGermanDate(): void
    {
        $donation = new DonationDetails('566.850,39', ' 22-10-28 ', ' heinrich ');

        $this->assertEquals('28.10.22', $donation->getGermanDate());
    }
}
