<?php

declare(strict_types=1);

namespace Tests\Domain\Donation\Data;

use App\Domain\Donation\Data\Donor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Donor::class)]
class DonorTest extends TestCase
{
    #[Test]
    public function testGetFullName(): void
    {
        $donor = new Donor(
            ' heinrich ',
            ' schiller ',
            'Mustermann Str.',
            'Musterstadt',
            '01234',
            'info@meine-email.de',
            '0123456789'
        );

        $this->assertInstanceOf(Donor::class, $donor);
        $this->assertSame('Heinrich', $donor->getFirstName());
        $this->assertSame('Schiller', $donor->getGivenName());
        $this->assertSame('Mustermann Str.', $donor->getStreet());
        $this->assertSame('Musterstadt', $donor->getCity());
        $this->assertSame('01234', $donor->getZipCode());
        $this->assertSame('info@meine-email.de', $donor->getEmailAdress());
        $this->assertSame('0123456789', $donor->getPhoneNumber());
        $this->assertSame('Heinrich Schiller', $donor->getFullName());
    }
}
