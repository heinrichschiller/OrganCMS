<?php

declare (strict_types=1);

namespace App\Domain\User;

final class User
{
    /**
     * User id
     *
     * @var int
     */
    private int $id = 0;

    /**
     * User first name
     *
     * @var string
     */
    private string $firstName = '';

    /**
     * User given name
     *
     * @var string
     */
    private string $givenName = '';

    /**
     * Username of an user
     *
     * @var string
     */
    private string $username = '';

    /**
     * User email
     * @var string
     */
    private string $email = '';

    /**
     * User password
     *
     * @var string
     */
    private string $password = '';

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
    public function setId(int $id): void
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
    public function setFirstName(string $firstName): void
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
    public function setGivenName(string $givenName): void
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
    public function setUsername(string $username): void
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
    public function setEmail(string $email): void
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
    public function setPassword(string $password): void
    {
        $this->password = trim($password, " \n\r\t\v\0");
    }
}
