<?php

declare (strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(User::class)]
#[CoversMethod(User::class, 'getId')]
#[CoversMethod(User::class, 'getFirstName')]
#[CoversMethod(User::class, 'getGivenName')]
#[CoversMethod(User::class, 'getUserName')]
#[CoversMethod(User::class, 'getEmail')]
#[CoversMethod(User::class, 'getPassword')]
class UserTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testUserInstance(): void
    {
        $user = new User;

        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserIdIsNullByDefault(): void
    {
        $user = new User(null);

        $this->assertNull($user->getId());
    }

    public function testUserHasId(): void
    {
        $user = new User(1);

        $this->assertEquals(1, $user->getId());
    }

    public function testFirstNameIsNullByDefault(): void
    {
        $user = new User(1);

        $this->assertNull($user->getFirstName());
    }

    public function testUserHasFirstName(): void
    {
        $user = new User(1, 'Heinrich');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    public function testFirstNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, ' Heinrich ');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    public function testFirstNameDoesStartWithUppercase(): void
    {
        $user = new User(1, ' heinrich ');

        $this->assertEquals('Heinrich', $user->getFirstName());
    }

    public function testGivenNameIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich');

        $this->assertNull($user->getGivenName());
    }

    public function testUserHasGivenName(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    public function testGivenNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    public function testGivenNameDoesStartWithUppercase(): void
    {
        $user = new User(1, 'Heinrich', ' schiller ');

        $this->assertEquals('Schiller', $user->getGivenName());
    }

    public function testUsernameIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller');

        $this->assertNull($user->getUsername());
    }

    public function testUserHasUsername(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', 'heinrich');

        $this->assertEquals('heinrich', $user->getUsername());
    }

    public function testUsernameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', ' heinrich ');

        $this->assertEquals('heinrich', $user->getUsername());
    }

    public function testUserEmailIsNullByDefault(): void
    {
        $user = new User(1, 'Heinrich', 'Schiller', 'heinrich');

        $this->assertNull($user->getEmail());
    }

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
