<?php

declare(strict_types=1);

namespace App\Domain\Donation;

class DonationFormular
{
    /**
     * @var float
     */
    private float  $oneTimeDonationAmount = 0.0;

    /**
     * @var bool
     */
    private bool $isWishPipe = false;

    /**
     * @var string
     */
    private string $sound = '';

    /**
     * @var string
     */
    private string $register = '';

    /**
     * @var string
     */
    private string $work = '';

    /**
     * @var bool
     */
    private bool $isAlternativeForDonor = false;

    /**
     * @var bool
     */
    private bool $isGift = false;

    /**
     * @var string
     */
    private array $namesOfGiftRecipients = [];

    /**
     * @var bool
     */
    private bool $isDonationCertificate = false;

    /**
     * @var bool
     */
    private bool $agree = false;

    /**
     * Get one time donation amount
     *
     * @return bool
     */
    public function getOneTimeDonationAmount(): float
    {
        return $this->oneTimeDonationAmount;
    }

    /**
     * Set one time donation amount
     *
     * @return bool
     */
    public function setOneTimeDonationAmount(float $amount): void
    {
        $this->oneTimeDonationAmount = $amount;
    }


    /**
     * Get wish pipe
     *
     * @return bool
     */
    public function isWishPipe(): bool
    {
        return $this->isWishPipe;
    }

    /**
     * Set wish pipe
     *
     * @param string $wishPipe
     */
    public function setWishPipe(bool $isWishPipe): void
    {
        $this->isWishPipe = $isWishPipe;
    }

    /**
     * Get whistle sound
     *
     * @return string
     */
    public function getSound(): string
    {
        return $this->sound;
    }

    /**
     * Set whistle sound
     *
     * @param string $ound
     */
    public function setSound(string $sound): void
    {
        $this->sound = $sound;
    }

    /**
     * Get whistle register
     *
     * @return string
     */
    public function getRegister(): string
    {
        return $this->register;
    }

    /**
     * Set whistle register
     *
     * @param string
     */
    public function setRegister(string $register): void
    {
        $this->register = $register;
    }

    /**
     * Get whistle word
     *
     * @return string
     */
    public function getWork(): string
    {
        return $this->work;
    }

    /**
     * Set whistle work
     *
     * @param null|string $work
     */
    public function setWork(string $work): void
    {
        $this->work = $work;
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
        return $this->namesOfGiftRecipients;
    }

    /**
     * Set name of the gift recipient
     *
     * @param string $names
     */
    public function setNamesOfGiftRecipients(array $names): void
    {
        $this->namesOfGiftRecipients = $names;
    }

    /**
     * Is a donation receipt
     *
     * @var bool
     */
    public function isDonationCertificate(): bool
    {
        return $this->isDonationCertificate;
    }

    /**
     * Set donation receipt
     *
     * @param bool $isDonationReceipt
     */
    public function setDonationCertificate(bool $certificate): void
    {
        $this->isDonationCertificate = $certificate;
    }

    /**
     * Donor agrees with the donation
     *
     * @return bool
     */
    public function hasAgreed(): bool
    {
        return $this->agree;
    }

    /**
     * Set Agree
     *
     * @param bool $isAgree
     */
    public function setConsent(bool $consent): void
    {
        $this->agree = $consent;
    }
}
