<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\DonationFormular;
use PHPUnit\Framework\TestCase;

class DonationTest extends TestCase
{
    private DonationFormular $formular;

    public function setUp(): void
    {
        $this->formular = new DonationFormular;
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testDonationInstance(): void
    {
        $this->assertInstanceOf(DonationFormular::class, $this->formular);
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testOneTimeDonationAmountIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->formular->getOneTimeDonationAmount());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testOneTimeDonationAmountHasInput():void
    {
        $this->formular->setOneTimeDonationAmount(10.0);

        $this->assertEquals(10.0, $this->formular->getOneTimeDonationAmount());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsWishPipeIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->formular->isWishPipe());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsWishPipeHasInput(): void
    {
        $this->formular->setWishPipe(true);

        $this->assertTrue($this->formular->isWishPipe());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testSoundIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->formular->getSound());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testSoundHasInput(): void
    {
        $this->formular->setSound('c');

        $this->assertEquals('c', $this->formular->getSound());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testRegisterIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->formular->getRegister());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testRegisterHasInput(): void
    {
        $this->formular->setRegister('Principal 8');

        $this->assertEquals('Principal 8', $this->formular->getRegister());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testWorkIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->formular->getWork());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testWorkHasInput(): void
    {
        $this->formular->setWork('Hauptwerk');

        $this->assertEquals('Hauptwerk', $this->formular->getWork());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsAlternativeForDonorIsFalseByDefault(): void
    {
        $this->assertFalse($this->formular->isAlternativeForDonor());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsAlternativeHasInput(): void
    {
        $this->formular->setAlternativeForDonor(true);

        $this->assertTrue($this->formular->isAlternativeForDonor());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsGiftIsFalseByDefault(): void
    {
        $this->assertFalse($this->formular->isGift());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsGiftHasInput(): void
    {
        $this->formular->setGift(true);

        $this->assertTrue($this->formular->isGift());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsDonationReceiptIsFalseByDefault(): void
    {
        $this->assertFalse($this->formular->isDonationCertificate());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testIsDonationReceiptHasInput(): void
    {
        $this->formular->setDonationCertificate(true);

        $this->assertTrue($this->formular->isDonationCertificate());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testAgreeIsFalseByDefault(): void
    {
        $this->assertFalse($this->formular->hasAgreed());
    }

    /**
     * @covers App\Domain\Donation\DonationFormular
     */
    public function testContentHasInput(): void
    {
        $this->formular->setConsent(true);

        $this->assertTrue($this->formular->hasAgreed());
    }
}
