<?php

declare (strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testUserInstance(): void
    {
        $user = new User;

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserIdIsNullByDefault(): void
    {
        $user = new User(null);

        $this->assertNull($user->getId());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasId(): void
    {
        $user = new User(1);

        $this->assertEquals(1, $user->getId());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameIsNullByDefault(): void
    {
        $user = new User(1);

        $this->assertNull($user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasFirstName(): void
    {
        $user = new User(1, 'Heinrich');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, ' Heinrich ');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameDoesStartWithUppercase(): void
    {
        $user = new User(1, ' heinrich ');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich');

        $this->assertNull($user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasGivenName(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameDoesStartWithUppercase(): void
    {
        $user = new User(1, 'Heinrich', ' schiller ');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUsernameIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertNull($user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasUsername(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', 'heinrich');

        $this->assertEquals('heinrich', $user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUsernameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', ' heinrich ');

        $this->assertEquals('heinrich', $user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserEmailIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', 'heinrich');

        $this->assertNull($user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasEmail(): void
    {
        $user = new User(
            1,
            'Heinrich',
            'Schiller',
            'heinrich',
            'max.musterman@email.com'
        );

        $this->assertEquals('max.musterman@email.com', $user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testEmailDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(
            1,
            'Heinrich',
            'Schiller',
            'heinrich',
            ' max.musterman@email.com '
        );

        $this->assertEquals('max.musterman@email.com', $user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserPasswordIsNullByDefault(): void
    {
        $user = new User(
            1,
            'Heinrich',
            'Schiller',
            'heinrich',
            'max.musterman@email.com'
        );

        $this->assertNull($user->getPassword());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasPassword(): void
    {
        $user = new User(
            1,
            'Heinrich',
            'Schiller',
            'heinrich',
            'max.musterman@email.com',
            'secret'
        );

        $this->assertEquals('secret', $user->getPassword());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testPasswordDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(
            1,
            'Heinrich',
            'Schiller',
            'heinrich',
            'max.musterman@email.com',
            ' secret '
        );

        $this->assertEquals('secret', $user->getPassword());
    }
}
