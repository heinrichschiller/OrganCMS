<?php

declare(strict_types=1);

namespace Tests\Domain\Posts\Post;

use App\Domain\Post\Data\Post;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Post::class)]
#[CoversMethod(Post::class, 'getId')]
#[CoversMethod(Post::class, 'getTitle')]
#[CoversMethod(Post::class, 'getSlug')]
#[CoversMethod(Post::class, 'getContent')]
class PostTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testPostInstance(): void
    {
        $post = new Post;

        $this->assertInstanceOf(Post::class, $post);
    }

    public function testPostIdIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getId());
    }

    public function testPostIdHasInput(): void
    {
        $post = new Post(1);

        $this->assertEquals(1, $post->getId());
    }

    public function testPostTitleIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getTitle());
    }

    public function testPostTitleHasInput(): void
    {
        $post = new Post(0, 'Post title');

        $this->assertEquals('Post title', $post->getTitle());
    }

    public function testPostTitleDoesNotStartOrEndWithAnWhitespace(): void
    {
        $post = new Post(0, ' Post title ');

        $this->assertEquals('Post title', $post->getTitle());
    }

    public function testPostTitleDoesStartWithUppercase(): void
    {
        $post = new Post(0, ' post title ');

        $this->assertEquals('Post title', $post->getTitle());
    }

    public function testPostSlugIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getSlug());
    }

    public function testPostContentIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getContent());
    }
}
