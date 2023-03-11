<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Donor;
use PHPUnit\Framework\TestCase;

class DonorTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testExistsTheDonorClass(): void
    {
        $this->assertInstanceOf(Donor::class, new Donor);
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testIsFirstNameIsNullByDefault(): void
    {
        $donor = new Donor;

        $this->assertNull($donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstNameHasInput(): void
    {
        $donor = new Donor('Heinrich');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterInFirstNameIsUppercase(): void
    {
        $donor = new Donor('heinrich');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstNameDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor(' heinrich ');

        $this->assertEquals('Heinrich', $donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich');

        $this->assertNull($donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameHasInput(): void
    {
        $donor = new Donor('Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterInGivenNameIsUppercase(): void
    {
        $donor = new Donor('Heinrich', 'schiller');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor('Heinrich', ' schiller ');

        $this->assertEquals('Schiller', $donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich', 'Schiller');

        $this->assertNull($donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetHasInput(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'Kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterOfStreetIsUppercase(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetDoesNotStartOrEndWithWhitespace(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', ' kaiserstr. 53 ');

        $this->assertEquals('Kaiserstr. 53', $donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testZipCodeIsNullByDefault(): void
    {
        $donor = new Donor('Heinrich', 'Schiller', 'Kaiserstr. 53');

        $this->assertNull($donor->getZipCode());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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

    /**
     * @covers App\Domain\Donation\Donor
     */
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
