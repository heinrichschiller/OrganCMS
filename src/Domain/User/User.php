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
     * Get user id.
     *
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * Set user id.
     *
     * @param int|null $id
     */
    private function setId(int|null $id): void
    {
        $this->id = $id;
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
        if (null !== $firstName) {
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
        if (null !== $givenName) {
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
        if (null !== $username) {
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
        if (null !== $email) {
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
        if (null !== $password) {
            $password = trim($password, " \n\r\t\v\0");
        }
        $this->password = $password;
    }
}
