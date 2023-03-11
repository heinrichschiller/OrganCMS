<?php

declare(strict_types=1);

namespace App\Domain\Donation;

class Donor
{
    public function __construct(
        private ?string $firstName = null,
        private ?string $givenName = null,
        private ?string $street = null,
        private ?string $city = null,
        private ?string $zipCode = null,
        private ?string $emailAdress = null,
        private ?string $phoneNumber = null
    )
    {
        $this->setFirstName($firstName);
        $this->setGivenName($givenName);
        $this->setStreet($street);
        $this->setCity($city);
        $this->setZipCode($zipCode);
        $this->setEmailAdress($emailAdress);
        $this->setPhoneNumber($phoneNumber);
    }

    public function getFirstName(): string|null
    {
        return $this->firstName;
    }

    /**
     * Set first name
     *
     * @param string|null $firstName
     */
    private function setFirstName(string|null $firstName): void
    {
        if (null !== $firstName) {
            $firstName = trim($firstName);
            $firstName = ucfirst($firstName);
        }

        $this->firstName = $firstName;
    }

    /**
     * Get given name
     *
     * @return string|null
     */
    public function getGivenName(): string|null
    {
        return $this->givenName;
    }

    /**
     * Set given name
     *
     * @param string|null $givenName
     */
    private function setGivenName(string|null $givenName): void
    {
        if (null !== $givenName) {
            $givenName = trim($givenName);
            $givenName = ucfirst($givenName);
        }

        $this->givenName = $givenName;
    }

    /**
     * Get street
     *
     * @return string|null
     */
    public function getStreet(): string|null
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @param string|null $street
     */
    private function setStreet(string|null $street): void
    {
        if (null !== $street) {
            $street = trim($street);
            $street = ucfirst($street);
        }

        $this->street = $street;
    }

    public function getCity(): string|null
    {
        return $this->city;
    }

    private function setCity(string|null $city): void
    {
        $this->city = $city;
    }
    
    /**
     * Get zip code
     *
     * @return string|null
     */
    public function getZipCode(): string|null
    {
        return $this->zipCode;
    }

    /**
     * Set zip code
     *
     * @param string|null $zipCode
     */
    private function setZipCode(string|null $zipCode): void
    {
        if (null !== $zipCode) {
            $zipCode = trim($zipCode);
        }

        $this->zipCode = $zipCode;
    }

    /**
     * Get email adress
     *
     * @return string|bull
     */
    public function getEmailAdress(): string|null
    {
        return $this->emailAdress;
    }

    /**
     * Set email adress
     *
     * @param string|null $emailAdress
     */
    private function setEmailAdress(string|null $emailAdress): void
    {
        if (null !== $emailAdress) {
            $emailAdress = trim($emailAdress);
        }

        $this->emailAdress = $emailAdress;
    }

    /**
     * Get phone number
     *
     * @return string|null
     */
    public function getPhoneNumber(): string|null
    {
        return $this->phoneNumber;
    }

    /**
     * Set phone number
     *
     * @param string|null $phoneNumber
     */
    private function setPhoneNumber(string|null $phoneNumber): void
    {
        if (null !== $phoneNumber) {
            $phoneNumber = trim($phoneNumber);
        }

        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->givenName;
    }
}
