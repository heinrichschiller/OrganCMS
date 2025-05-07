<?php

declare(strict_types=1);

namespace Tests\Domain\Post\PostTest;

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

    public function testPostPropertiesAreNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getId());
        $this->assertNull($post->getTitle());
        $this->assertNull($post->getSlug());
        $this->assertNull($post->getIntro());
        $this->assertNull($post->getContent());
        $this->assertNull($post->getAuthorId());
        $this->assertNull($post->onMainpage());
        $this->assertNull($post->getPublishedAt());
        $this->assertNull($post->getPublishedAtFormated());
        $this->assertNull($post->isPublished());
        $this->assertNull($post->getCreatedAt());
        $this->assertNull($post->getUpdatedAt());
    }

    public function testPostPropertiesHasInput(): void
    {
        $post = new Post(
            1,
            'Post title',
            '/slug',
            'intro',
            'content',
            1,
            false,
            '2024-09-06 08:50:00',
            true,
            '2024-09-06 08:50:00',
            '2024-09-06 08:50:00'
        );

        $this->assertEquals(1, $post->getId());
        $this->assertEquals('Post title', $post->getTitle());
        $this->assertEquals('/slug', $post->getSlug());
        $this->assertEquals('intro', $post->getIntro());
        $this->assertEquals('content', $post->getContent());
        $this->assertEquals(1, $post->getAuthorId());
        $this->assertEquals(false, $post->onMainpage());
        $this->assertEquals('2024-09-06 08:50:00', $post->getPublishedAt());
        $this->assertEquals(true, $post->isPublished());
        $this->assertEquals('06.09.2024', $post->getPublishedAtFormated());
        $this->assertEquals('06.09.2024', $post->getCreatedAtFormated());
        $this->assertEquals('06.09.2024', $post->getUpdatedAtFormated());
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
}
