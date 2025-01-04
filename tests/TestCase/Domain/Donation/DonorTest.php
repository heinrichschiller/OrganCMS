<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Donor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Donor::class)]
#[CoversMethod(Donor::class, 'getFirstName')]
#[CoversMethod(Donor::class, 'getGivenName')]
#[CoversMethod(Donor::class, 'getStreet')]
#[CoversMethod(Donor::class, 'getZipCode')]
#[CoversMethod(Donor::class, 'getEmailAdress')]
#[CoversMethod(Donor::class, 'getPhoneNumber')]
#[CoversMethod(Donor::class, 'getFullName')]
class DonorTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testExistsTheDonorClass(): void
    {
        $this->assertInstanceOf(Donor::class, new Donor);
    }

    public function testIsFirstNameIsNullByDefault(): void
    {
        $donor = new Donor;

        $this->assertNull($donor->getFirstName());
    }

    public function testFirstNameHasInput(): void
    {
        $donor = new Donor('Heinrich');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    public function testFirstLetterInFirstNameIsUppercase(): void
    {
        $donor = new Donor('heinrich');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    public function testFirstNameDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor(' heinrich ');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    public function testGivenNameIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich');

        $this->assertNull($donor->getGivenName());
    }

    public function testGivenNameHasInput(): void
    {
        $donor = new Donor('Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    public function testFirstLetterInGivenNameIsUppercase(): void
    {
        $donor = new Donor('Heinrich', 'schiller');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    public function testGivenNameDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor('Heinrich', ' schiller ');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    public function testStreetIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich', 'Schiller');

        $this->assertNull($donor->getStreet());
    }

    public function testStreetHasInput(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'Kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    public function testFirstLetterOfStreetIsUppercase(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    public function testStreetDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', ' kaiserstr. 53 ');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    public function testZipCodeIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'Kaiserstr. 53');

        $this->assertNull($donor->getZipCode());
    }

    public function testZipCodeHasInput(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523'
        );

        $this->assertEquals('08523', $donor->getZipCode());
    }

    public function testZipCodeDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            ' 08523 '
        );

        $this->assertEquals('08523', $donor->getZipCode());
    }

    public function testEmailAdressIsNullByDefault(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523'
        );

        $this->assertNull($donor->getEmailAdress());
    }

    public function testEmailAdressHasInput(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            'info@heinrich-schiller.de'
        );

        $this->assertEquals('info@heinrich-schiller.de', $donor->getEmailAdress());
    }

    public function testEmailAdressDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            ' info@heinrich-schiller.de '
        );

        $this->assertEquals('info@heinrich-schiller.de', $donor->getEmailAdress());
    }

    public function testPhoneNumberIsNullByDefault(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            'info@heinrich-schiller.de'
        );

        $this->assertNull($donor->getPhoneNumber());
    }

    public function testPhoneNumberHasInput(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            'info@heinrich-schiller.de',
            '0123456789'
        );

        $this->assertEquals('0123456789', $donor->getPhoneNumber());
    }

    public function testPhoneNumberDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            'info@heinrich-schiller.de',
            ' 0123456789 '
        );

        $this->assertEquals('0123456789', $donor->getPhoneNumber());
    }

    public function testGetFullName(): void
    {
        $donor = new Donor(
            'Heinrich',
            'Schiller',
            'Kaiserstr. 53',
            'Plauen',
            '08523',
            'info@heinrich-schiller.de',
            '0123456789'
        );

        $this->assertSame('Heinrich Schiller', $donor->getFullName());
    }
}
