<?php

declare (strict_types=1);

namespace App\Domain\User\Data;

use DateTimeImmutable;

final class User
{
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

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getFirstName(): string|null
    {
        return $this->firstName;
    }

    private function setFirstName(string|null $firstName): void
    {
        if ($firstName !== null) {
            $firstName = trim($firstName, " \n\r\t\v\0");
            $firstName = ucfirst($firstName);
        }
        
        $this->firstName = $firstName;
    }

    public function getGivenName(): string|null
    {
        return $this->givenName;
    }

    private function setGivenName(string|null $givenName): void
    {
        if ($givenName !== null) {
            $givenName = trim($givenName, " \n\r\t\v\0");
            $givenName = ucfirst($givenName);
        }
        
        $this->givenName = $givenName;
    }

    public function getUsername(): string|null
    {
        return $this->username;
    }

    private function setUsername(string|null $username): void
    {
        if ($username !== null) {
            $username = trim($username, " \n\r\t\v\0");
        }

        $this->username = $username;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    private function setEmail(string|null $email): void
    {
        if ($email !== null) {
            $email = trim($email, " \n\r\t\v\0");
        }
        $this->email = $email;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    private function setPassword(string|null $password): void
    {
        if ($password !== null) {
            $password = trim($password, " \n\r\t\v\0");
        }
        $this->password = $password;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->givenName);
    }

    public function isActive(): bool|null
    {
        return $this->isActive;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }
}
