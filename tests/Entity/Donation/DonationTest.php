<?php

declare(strict_types=1);

use App\Domain\Donation\Donation;
use PHPUnit\Framework\TestCase;

final class DonationTest extends TestCase
{
    private Donation $donation;

    public function setUp(): void
    {
        $this->donation = new Donation;
    }

    public function testDonationInstance(): void
    {
        $this->assertInstanceOf(Donation::class, new Donation);
    }

    public function testTotalIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getTotal());
    }

    public function testTotalHasInput(): void
    {
        $this->donation->setTotal('566.850,39');

        $this->assertEquals('566.850,39', $this->donation->getTotal());
    }

    public function testTotalDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setTotal(' 566.850,39 ');

        $this->assertEquals('566.850,39', $this->donation->getTotal());
    }

    public function testDateIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getDate());
    }

    public function testDateHasInput(): void
    {
        $this->donation->setDate('28.02.2022');

        $this->assertEquals('28.02.2022', $this->donation->getDate());
    }

    public function testDateDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setDate(' 28.02.2022 ');

        $this->assertEquals('28.02.2022', $this->donation->getDate());
    }

    public function testUserIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getUser());
    }

    public function testUserHasUsername(): void
    {
        $this->donation->setUser('heinrich');

        $this->assertEquals('heinrich', $this->donation->getUser());
    }

    public function testUserDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donation->setUser(' heinrich ');

        $this->assertEquals('heinrich', $this->donation->getUser());
    }
}
