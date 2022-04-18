<?php

declare(strict_types=1);

namespace App\Domain\Donation;

class Donation
{
    /**
     * @var bool
     */
    private bool   $isOneTimeDonation = false;

    /**
     * @var float
     */
    private float  $oneTimeDonationSum = 0.0;

    /**
     * @var bool
     */
    private bool   $isSponsorship = false;

    /**
     * @var float
     */
    private float  $sponsorshipSum = 0.0;

    /**
     * @var string
     */
    private string $wishPipe = '';

    /**
     * @var string
     */
    private string $whistleSound = '';

    /**
     * @var string
     */
    private string $whistleRegister = '';

    /**
     * @var string
     */
    private string $whistleWork = '';

    /**
     * @var bool
     */
    private bool   $isDonorWish = false;

    /**
     * @var bool
     */
    private bool   $isAlternativeForDonor = false;

    /**
     * @var bool
     */
    private bool   $isGift = false;

    /**
     * @var string
     */
    private string $nameOfGiftRecipient = '';

    /**
     * @var bool
     */
    private bool   $isBankTransfer = false;

    /**
     * @var bool
     */
    private bool   $isDonationReceipt = false;

    /**
     * @var bool
     */
    private bool   $isAgree = false;

    /**
     * Get one time donation
     * 
     * @return bool
     */
    public function getOneTimeDonation(): bool
    {
        return $this->isOneTimeDonation;
    }

    /**
     * Set one time donation
     * 
     * @param bool $isOneTimeDonation
     */
    public function setOneTimeDonation(bool $isOneTimeDonation): void
    {
        $this->isOneTimeDonation = $isOneTimeDonation;
    }

    /**
     * Get one time donation sum
     * 
     * @return bool
     */
    public function getOneTimeDonationSum(): float
    {
        return $this->oneTimeDonationSum;
    }

    /**
     * Set one time donation sum
     * 
     * @return bool
     */
    public function setOneTimeDonationSum(float $sum): void
    {
        $this->oneTimeDonationSum = $sum;
    }

    /**
     * Get sponsorship
     * 
     * @return bool
     */
    public function getSponsorship(): bool
    {
        return $this->isSponsorship;
    }

    /**
     * Set sponsorship
     * 
     * @param bool
     */
    public function setSponsorship(bool $isSponsorship):void
    {
        $this->isSponsorship = $isSponsorship;
    }

    /**
     * Get sponsorship sum
     * 
     * @return float
     */
    public function getSponsorshipSum(): float
    {
        return $this->sponsorshipSum;
    }

    /**
     * Set sponsorship sum
     * 
     * @param float $sponsorshipSum
     */
    public function setSponsorshipSum(float $sponsorshipSum): void
    {
        $this->sponsorshipSum = $sponsorshipSum;
    }

    /**
     * Get wish pipe
     * 
     * @return string
     */
    public function getWishPipe(): string
    {
        return $this->wishPipe;
    }

    /**
     * Set wish pipe
     * 
     * @param string $wishPipe
     */
    public function setWishPipe(string $wishPipe): void
    {
        $this->wishPipe = $wishPipe;
    }

    /**
     * Get whistle sound
     * 
     * @return string
     */
    public function getWhistleSound(): string
    {
        return $this->whistleSound;
    }

    /**
     * Set whistle sound
     * 
     * @param string $whistleSound
     */
    public function setWhistleSound(string $whistleSound): void
    {
        $this->whistleSound = $whistleSound;
    }

    /**
     * Get whistle register
     * 
     * @return string
     */
    public function getWhistleRegister(): string
    {
        return $this->whistleRegister;
    }

    /**
     * Set whistle register
     * 
     * @param string
     */
    public function setWhistleRegister(string $whistleRegister): void
    {
        $this->whistleRegister = $whistleRegister;
    }

    /**
     * Get whistle word
     * 
     * @return string
     */
    public function getWhistleWork(): string
    {
        return $this->whistleWork;
    }

    /**
     * Set whistle work
     * 
     * @param string $whistleWork
     */
    public function setWhistleWork(string $whistleWork): void
    {
        $this->whistleWork = $whistleWork;
    }

    /**
     * Is a donor wish pipe
     * 
     * @return bool
     */
    public function isDonorWish(): bool
    {
        return $this->isDonorWish;
    }

    /**
     * Set donor wish
     * 
     * @param bool $isDonorWish
     */
    public function setDonorWish(bool $isDonorWish): void
    {
        $this->isDonorWish = $isDonorWish;
    }

    /**
     * Is an alternative for donor
     * 
     * @return bool
     */
    public function isAlternativeForDonor(): bool
    {
        return $this->isAlternativeForDonor;
    }

    /**
     * Set alternative for donor
     * 
     * @param bool $isAlternativeForDonor
     */
    public function setAlternativeForDonor(bool $isAlternativeForDonor): void
    {
        $this->isAlternativeForDonor = $isAlternativeForDonor;
    }

    /**
     * Is a gift
     * 
     * @return bool
     */
    public function isGift(): bool
    {
        return $this->isGift;
    }

    /**
     * Set gift
     * 
     * @param bool $isGift
     */
    public function setGift(bool $isGift): void
    {
        $this->isGift = $isGift;
    }

    /**
     * Get name of the gift recipient
     * 
     * @return string
     */
    public function getNameOfGiftRecipient(): string
    {
        return $this->nameOfGiftRecipient;
    }

    /**
     * Set name of the gift recipient
     * 
     * @param string $nameOfGiftRecipient
     */
    public function setNameOfGiftRecipient(string $nameOfGiftRecipient): void
    {
        $this->nameOfGiftRecipient = $nameOfGiftRecipient;
    }

    /**
     * Is a bank transfer
     */
    public function isBankTransfer(): bool
    {
        return $this->isBankTransfer;
    }

    /**
     * Set bank transfer
     * 
     * @param bool $isBankTransfer
     */
    public function setBankTransfer(bool $isBankTransfer): void
    {
        $this->isBankTransfer = $isBankTransfer;
    }

    /**
     * Is a donation receipt
     * 
     * @var bool
     */
    public function isDonationReceipt(): bool
    {
        return $this->isDonationReceipt;
    }

    /**
     * Set donation receipt
     * 
     * @param bool $isDonationReceipt
     */
    public function setDonationReceipt(bool $isDonationReceipt): void
    {
        $this->isDonationReceipt = $isDonationReceipt;
    }

    /**
     * Donor agrees with the donation
     * 
     * @return bool
     */
    public function isAgree(): bool
    {
        return $this->isAgree;
    }

    /**
     * Set Agree
     * 
     * @param bool $isAgree
     */
    public function setAgree(bool $isAgree): void
    {
        $this->isAgree = $isAgree;
    }
}
