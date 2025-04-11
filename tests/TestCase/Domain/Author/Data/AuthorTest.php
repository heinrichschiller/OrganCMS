<?php

declare(strict_types=1);

namespace Tests\Domain\Author\Data;

use App\Domain\Author\Data\Author;
use App\Domain\User\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Author::class)]
#[CoversMethod(Author::class, 'getId')]
class AuthorTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testAuthorInstance(): void
    {
        $author = new Author;

        $this->assertInstanceOf(Author::class, $author);
    }

    public function testIdIsNullByDefault(): void
    {
        $author = new Author;

        $this->assertNull($author->getId());
    }

    public function testIdHasInput(): void
    {
        $author = new Author(1);

        $this->assertSame(1, $author->getId());
    }

    public function testUserIdIsNullByDefault(): void
    {
        $author = new Author;

        $this->assertNull($author->getUserId());
    }

    public function testUserIdHasInput(): void
    {
        $author = new Author(1, 1);

        $this->assertSame(1, $author->getUserId());
    }

    public function testAuthorFullNameIsNullByDefault(): void
    {
        $author = new Author;

        $this->assertNull($author->getAuthorName());
    }

    public function testAuthorNameHasInput(): void
    {
        $author = new Author(1, 1, 'Heinrich Schiller');

        $this->assertSame('Heinrich Schiller', $author->getAuthorName());
    }
}
