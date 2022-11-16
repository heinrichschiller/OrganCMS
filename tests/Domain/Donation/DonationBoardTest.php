<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\DonationBoard;
use PHPUnit\Framework\TestCase;

final class DonationBoardTest extends TestCase
{
    private DonationBoard $donation;

    public function setUp(): void
    {
        $this->donation = new DonationBoard;
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testDonationInstance(): void
    {
        $this->assertInstanceOf(DonationBoard::class, new DonationBoard);
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testTotalIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testTotalHasInput(): void
    {
        $this->donation->setTotal('566.850,39');

        $this->assertEquals('566.850,39', $this->donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testTotalDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setTotal(' 566.850,39 ');

        $this->assertEquals('566.850,39', $this->donation->getTotal());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testDateIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testDateHasInput(): void
    {
        $this->donation->setDate('28.02.2022');

        $this->assertEquals('28.02.2022', $this->donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testDateDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setDate(' 28.02.2022 ');

        $this->assertEquals('28.02.2022', $this->donation->getDate());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testUserIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testUserHasUsername(): void
    {
        $this->donation->setUser('heinrich');

        $this->assertEquals('heinrich', $this->donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testUserDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setUser(' heinrich ');

        $this->assertEquals('heinrich', $this->donation->getUser());
    }

    /**
     * @covers App\Domain\Donation\DonationBoard
     */
    public function testConvertToGermanDate(): void
    {
        $this->donation->setDate('22-10-28');

        $this->assertEquals('28.10.22', $this->donation->getGermanDate());
    }
}
