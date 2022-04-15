<?php

/**
 * MIT License
 *
 * Copyright (c) 2022 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare (strict_types=1);

use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        $this->user = new User;
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserIdIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getId());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasId(): void
    {
        $this->user->setId(1);

        $this->assertEquals(1, $this->user->getId());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasFirstName(): void
    {
        $this->user->setFirstName('heinrich');

        $this->assertEquals('Heinrich', $this->user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->user->setFirstName(' heinrich ');

        $this->assertEquals('Heinrich', $this->user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testFirstNameDoesStartWithUppercase(): void
    {
        $this->user->setFirstName('heinrich');

        $this->assertEquals('Heinrich', $this->user->getFirstName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasGivenName(): void
    {
        $this->user->setGivenName('Schiller');

        $this->assertEquals('Schiller', $this->user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->user->setGivenName(' Schiller ');

        $this->assertEquals('Schiller', $this->user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testGivenNameDoesStartWithUppercase(): void
    {
        $this->user->setGivenName(' schiller ');

        $this->assertEquals('Schiller', $this->user->getGivenName());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUsernameIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasUsername(): void
    {
        $this->user->setUsername('heinrich');

        $this->assertEquals('heinrich', $this->user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUsernameDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->user->setUsername(' heinrich ');

        $this->assertEquals('heinrich', $this->user->getUsername());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserEmailIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasEmail(): void
    {
        $this->user->setEmail('max.musterman@email.com');

        $this->assertEquals('max.musterman@email.com', $this->user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testEmailDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->user->setEmail(' max.musterman@email.com ');

        $this->assertEquals('max.musterman@email.com', $this->user->getEmail());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserPasswordIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->user->getPassword());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testUserHasPassword(): void
    {
        $this->user->setPassword('secret');

        $this->assertEquals('secret', $this->user->getPassword());
    }

    /**
     * @covers App\Domain\User\User
     */
    public function testPasswordDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->user->setPassword(' secret ');

        $this->assertEquals('secret', $this->user->getPassword());
    }
}
