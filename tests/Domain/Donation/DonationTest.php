<?php

declare(strict_types=1);

use App\Domain\Donation\Donation;
use PHPUnit\Framework\TestCase;

class DonationTest extends TestCase
{
    private Donation $donation;

    public function setUp(): void
    {
        $this->donation = new Donation;
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testExistTheDonationClass(): void
    {
        $this->assertInstanceOf(Donation::class, $this->donation);
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testOneTimeDonationIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->getOneTimeDonation());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testOneTimeDonationInputIsTrue(): void
    {
        $this->donation->setOneTimeDonation(true);

        $this->assertTrue($this->donation->getOneTimeDonation());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testOneTimeDonationSumIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getOneTimeDonationSum());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testOneTimeDonationSumHasInput():void
    {
        $this->donation->setOneTimeDonationSum(10.0);

        $this->assertEquals(10.0, $this->donation->getOneTimeDonationSum());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testSponsorshipIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->getSponsorship());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testSponsorshipHasInput(): void
    {
        $this->donation->setSponsorship(true);

        $this->assertTrue($this->donation->getSponsorship());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testSponsorshipSumIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getSponsorshipSum());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testSponsorshipSumHasInput(): void
    {
        $this->donation->setSponsorshipSum(10);

        $this->assertEquals(10.0, $this->donation->getSponsorshipSum());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWishPipeIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getWishPipe());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWishPipeHasInput(): void
    {
        $this->donation->setWishPipe('Prinzipal 8´');

        $this->assertEquals('Prinzipal 8´', $this->donation->getWishPipe());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleSoundIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getWhistleSound());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleSoundHasInput(): void
    {
        $this->donation->setWhistleSound('c');

        $this->assertEquals('c', $this->donation->getWhistleSound());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleRegisterIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getWhistleRegister());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleRegisterHasInput(): void
    {
        $this->donation->setWhistleRegister('Principal 8');

        $this->assertEquals('Principal 8', $this->donation->getWhistleRegister());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleWorkIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->donation->getWhistleWork());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testWhistleWorkHasInput(): void
    {
        $this->donation->setWhistleWork('Hauptwerk');

        $this->assertEquals('Hauptwerk', $this->donation->getWhistleWork());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsDonorWishIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isDonorWish());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsDonorWishHasInput(): void
    {
        $this->donation->setDonorWish(true);

        $this->assertTrue($this->donation->isDonorWish());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsAlternativeForDonorIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isAlternativeForDonor());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsAlternativeHasInput(): void
    {
        $this->donation->setAlternativeForDonor(true);

        $this->assertTrue($this->donation->isAlternativeForDonor());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsGiftIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isGift());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsGiftHasInput(): void
    {
        $this->donation->setGift(true);

        $this->assertTrue($this->donation->isGift());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testNameOfGiftRecipientIsEmpty(): void
    {
        $this->assertEmpty($this->donation->getNameOfGiftRecipient());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testNameOfGiftRecipientHasInput(): void
    {
        $this->donation->setNameOfGiftRecipient('Heinrich Schiller');

        $this->assertEquals('Heinrich Schiller', $this->donation->getNameOfGiftRecipient());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsBankTransferIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isBankTransfer());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsBankTransferHasInput(): void
    {
        $this->donation->setBankTransfer(true);

        $this->assertTrue($this->donation->isBankTransfer());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsDonationReceiptIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isDonationReceipt());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsDonationReceiptHasInput(): void
    {
        $this->donation->setDonationReceipt(true);

        $this->assertTrue($this->donation->isDonationReceipt());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsAgreeIsFalseByDefault(): void
    {
        $this->assertFalse($this->donation->isAgree());
    }

    /**
     * @covers App\Domain\Donation\Donation
     */
    public function testIsAgreeHasInput(): void
    {
        $this->donation->setAgree(true);

        $this->assertTrue($this->donation->isAgree());
    }
}
