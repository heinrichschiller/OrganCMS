<?php

declare(strict_types=1);

namespace Tests\Post;

use App\Domain\Post\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostInstance(): void
    {
        $post = new Post;

        $this->assertInstanceOf(Post::class, $post);
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostIdIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getId());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostIdHasInput(): void
    {
        $post = new Post(1);

        $this->assertEquals(1, $post->getId());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostTitleIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getTitle());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostTitleHasInput(): void
    {
        $post = new Post(0, 'Post title');

        $this->assertEquals('Post title', $post->getTitle());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostTitleDoesNotStartOrEndWithAnWhitespace(): void
    {
        $post = new Post(0, ' Post title ');

        $this->assertEquals('Post title', $post->getTitle());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostTitleDoesStartWithUppercase(): void
    {
        $post = new Post(0, ' post title ');

        $this->assertEquals('Post title', $post->getTitle());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostSlugIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getSlug());
    }

    /**
     * @covers App\Domain\Post\Post
     */
    public function testPostContentIsEmptyByDefault(): void
    {
        $post = new Post;

        $this->assertEmpty($post->getContent());
    }
}
