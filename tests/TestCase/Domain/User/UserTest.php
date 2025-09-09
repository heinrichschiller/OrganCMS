<?php

declare (strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\Data\User;
use DateTimeImmutable;
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

    public function testUserData(): void
    {
        $createdAt = new DateTimeImmutable('2025-09-09');
        $updatedAt = new DateTimeImmutable('2025-09-09');

        $user = new User(
            id: 1,
            firstName: ' heinrich ',
            givenName: ' schiller ',
            username: ' heinrich ',
            email: 'max.mustermann@email.com',
            password: ' secret ',
            isActive: true,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->assertSame(1, $user->getId());
        $this->assertSame('Heinrich', $user->getFirstName());
        $this->assertSame('Schiller', $user->getGivenName());
        $this->assertSame('heinrich', $user->getUsername());
        $this->assertSame('max.mustermann@email.com', $user->getEmail());
        $this->assertEquals('secret', $user->getPassword());
        $this->assertTrue($user->isActive());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        $this->assertSame('Heinrich Schiller', $user->getFullName());
    }
}
