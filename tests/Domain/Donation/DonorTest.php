<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Donor;
use PHPUnit\Framework\TestCase;

class DonorTest extends TestCase
{
    private Donor $donor;

    public function setUp(): void
    {
        $this->donor = new Donor;
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testExistsTheDonorClass(): void
    {
        $this->assertInstanceOf(Donor::class, $this->donor);
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testIsFirstNameIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstNameHasInput(): void
    {
        $this->donor->setFirstName('Heinrich');

        $this->assertEquals('Heinrich', $this->donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterInFirstNameIsUppercase(): void
    {
        $this->donor->setFirstName('heinrich');

        $this->assertEquals('Heinrich', $this->donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstNameDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setFirstName(' heinrich ');

        $this->assertEquals('Heinrich', $this->donor->getFirstName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameHasInput(): void
    {
        $this->donor->setGivenName('Schiller');

        $this->assertEquals('Schiller', $this->donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterInGivenNameIsUppercase(): void
    {
        $this->donor->setGivenName('schiller');

        $this->assertEquals('Schiller', $this->donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGivenNameDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setGivenName(' schiller ');

        $this->assertEquals('Schiller', $this->donor->getGivenName());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetHasInput(): void
    {
        $this->donor->setStreet('Kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $this->donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testFirstLetterOfStreetIsUppercase(): void
    {
        $this->donor->setStreet('kaiserstr. 53');

        $this->assertEquals('Kaiserstr. 53', $this->donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testStreetDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setStreet(' kaiserstr. 53 ');

        $this->assertEquals('Kaiserstr. 53', $this->donor->getStreet());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testZipCodeIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getZipCode());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testZipCodeHasInput(): void
    {
        $this->donor->setZipCode('08523');

        $this->assertEquals('08523', $this->donor->getZipCode());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testZipCodeDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setZipCode(' 08523 ');

        $this->assertEquals('08523', $this->donor->getZipCode());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testEmailAdressIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getEmailAdress());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testEmailAdressHasInput(): void
    {
        $this->donor->setEmailAdress('info@heinrich-schiller.de');

        $this->assertEquals('info@heinrich-schiller.de', $this->donor->getEmailAdress());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testEmailAdressDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setEmailAdress(' info@heinrich-schiller.de ');

        $this->assertEquals('info@heinrich-schiller.de', $this->donor->getEmailAdress());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testPhoneNumberIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donor->getPhoneNumber());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testPhoneNumberHasInput(): void
    {
        $this->donor->setPhoneNumber('0123456789');

        $this->assertEquals('0123456789', $this->donor->getPhoneNumber());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testPhoneNumberDoesNotStartOrEndWithWhitespace(): void
    {
        $this->donor->setPhoneNumber(' 0123456789 ');

        $this->assertEquals('0123456789', $this->donor->getPhoneNumber());
    }

    /**
     * @covers App\Domain\Donation\Donor
     */
    public function testGetFullName(): void
    {
        $this->donor->setFirstName('heinrich');
        $this->donor->setGivenName('schiller');

        $this->assertSame('Heinrich Schiller', $this->donor->getFullName());
    }
}
