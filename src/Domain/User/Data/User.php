<?php

declare (strict_types=1);

namespace App\Domain\User\Data;

use DateTimeImmutable;

use function trim;
use function ucfirst;
use function sprintf;

final class User
{
    /**
     * The constructor.
     *
     * @param int|null $id User id.
     * @param string|null $firstName User first name.
     * @param string|null $givenName User given name.
     * @param string|null $username Login name.
     * @param string|null $email User email.
     * @param string|null $password User password.
     * @param bool|null $isActive Status of the user.
     * @param DateTimeImmutable|null $createdAt Created date of the user.
     * @param DateTimeImmutable|null $updatedAt Updated date of the user.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $firstName = null,
        private ?string $givenName = null,
        private ?string $username = null,
        private ?string $email = null,
        private ?string $password = null,
        private ?bool $isActive = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null
    ) {
        $this->setFirstName($firstName);
        $this->setGivenName($givenName);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    /**
     * Get user id.
     *
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * Get first name of an user
     *
     * @return string|null
     */
    public function getFirstName(): string|null
    {
        return $this->firstName;
    }

    /**
     * Set first name of an user
     *
     * @param string|null $firstName
     */
    private function setFirstName(string|null $firstName): void
    {
        if ($firstName !== null) {
            $firstName = trim($firstName, " \n\r\t\v\0");
            $firstName = ucfirst($firstName);
        }
        
        $this->firstName = $firstName;
    }

    /**
     * Get given name of an user
     *
     * @return string|null
     */
    public function getGivenName(): string|null
    {
        return $this->givenName;
    }

    /**
     * Set given name of an user
     *
     * @param string|null $givenName
     */
    private function setGivenName(string|null $givenName): void
    {
        if ($givenName !== null) {
            $givenName = trim($givenName, " \n\r\t\v\0");
            $givenName = ucfirst($givenName);
        }
        
        $this->givenName = $givenName;
    }

    /**
     * Get username of an user
     *
     * @return string|null
     */
    public function getUsername(): string|null
    {
        return $this->username;
    }

    /**
     * Set username of an user
     *
     * @param string|null $username
     */
    private function setUsername(string|null $username): void
    {
        if ($username !== null) {
            $username = trim($username, " \n\r\t\v\0");
        }

        $this->username = $username;
    }

    /**
     * Get email adress of an user
     *
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * Set email adress of an user
     *
     * @param string|null $email
     */
    private function setEmail(string|null $email): void
    {
        if ($email !== null) {
            $email = trim($email, " \n\r\t\v\0");
        }
        $this->email = $email;
    }

    /**
     * Get password of an user
     *
     * @return string|null
     */
    public function getPassword(): string|null
    {
        return $this->password;
    }

    /**
     * Set password of an user
     *
     * @param string|null $password
     */
    private function setPassword(string|null $password): void
    {
        if ($password !== null) {
            $password = trim($password, " \n\r\t\v\0");
        }
        $this->password = $password;
    }

    /**
     * Get full name of the user.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->givenName);
    }

    /**
     * Get active status of the user.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Get created date of the user.
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get update date of the user.
     *
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }
}
