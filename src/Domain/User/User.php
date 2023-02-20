<?php

declare (strict_types=1);

namespace App\Domain\User;

final class User
{
    /**
     * The constructor.
     *
     * @param int|null $id User id.
     * @param string|null $firstName User first name.
     * @param string|null $givenName User given name.
     * @param string|null $username Login name
     * @param string|null $email User email.
     * @param string|null $password User password
     */
    public function __construct(
        private ?int $id = null,
        private ?string $firstName = null,
        private ?string $givenName = null,
        private ?string $username = null,
        private ?string $email = null,
        private ?string $password = null
    ) {
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setGivenName($givenName);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    /**
     * Get user id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set user id
     *
     * @param int $id
     */
    private function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get first name of an user
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set first name of an user
     *
     * @param string $firstName
     */
    private function setFirstName(string $firstName): void
    {
        $firstName = trim($firstName, " \n\r\t\v\0");
        $firstName = ucfirst($firstName);

        $this->firstName = $firstName;
    }

    /**
     * Get given name of an user
     *
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Set given name of an user
     *
     * @param string $givenName
     */
    private function setGivenName(string $givenName): void
    {
        $givenName = trim($givenName, " \n\r\t\v\0");
        $givenName = ucfirst($givenName);

        $this->givenName = $givenName;
    }

    /**
     * Get username of an user
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set username of an user
     *
     * @param string $username
     */
    private function setUsername(string $username): void
    {
        $this->username = trim($username, " \n\r\t\v\0");
    }

    /**
     * Get email adress of an user
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email adress of an user
     *
     * @param string $email
     */
    private function setEmail(string $email): void
    {
        $this->email = trim($email, " \n\r\t\v\0");
    }

    /**
     * Get password of an user
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password of an user
     *
     * @param string $password
     */
    private function setPassword(string $password): void
    {
        $this->password = trim($password, " \n\r\t\v\0");
    }
}
