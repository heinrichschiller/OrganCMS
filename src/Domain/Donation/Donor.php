<?php

declare(strict_types=1);

namespace App\Domain\Donation;

class Donor
{
    /**
     * @var string
     */
    private string $firstName = '';

    /**
     * @var string
     */
    private string $givenName = '';

    /**
     * @var string
     */
    private string $street = '';

    /**
     * @var string
     */
    private string $zipCode = '';

    /**
     * @var string
     */
    private string $emailAdress = '';

    /**
     * @var string
     */
    private string $phoneNumber = '';

    /**
     * Get first name
     * 
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set first name
     * 
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = ucfirst(trim($firstName));
    }

    /**
     * Get given name
     * 
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Set given name
     * 
     * @param string
     */
    public function setGivenName(string $givenName): void
    {
        $this->givenName = ucfirst(trim($givenName));
    }

    /**
     * Get street
     * 
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * Set street
     * 
     * @param string
     */
    public function setStreet(string $street): void
    {
        $this->street = ucfirst(trim($street));
    }

    /**
     * Get zip code
     * 
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * Set zip code
     * 
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = trim($zipCode);
    }

    /**
     * Get email adress
     * 
     * @return string
     */
    public function getEmailAdress(): string
    {
        return $this->emailAdress;
    }

    /**
     * Set email adress
     * 
     * @param string $emailAdress
     */
    public function setEmailAdress(string $emailAdress): void
    {
        $this->emailAdress = trim($emailAdress);
    }

    /**
     * Get phone number
     * 
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Set phone number
     * 
     * @return string
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = trim($phoneNumber);
    }
}
