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

    public function testPostIntroIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getIntro());
    }

    public function testPostContentIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getContent());
    }

    public function testPostAuthorIdIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getAuthorId());
    }

    public function testPostMainpageIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->onMainpage());
    }

    public function testPostPublishedAtIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getPublishedAt());
    }

    public function testPostPublishedAtFormatedAtIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getPublishedAtFormated());
    }

    public function testPostPublishedAtFormatedHasInput(): void
    {
        $post = new Post(0, 'title', '/slug', 'intro', 'content', 1, false, '2024-09-06 08:50:00');

        $this->assertEquals('06.09.2024', $post->getPublishedAtFormated());
    }

    public function testPostIsPublishedIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->isPublished());
    }

    public function testPostCreatedAtIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getCreatedAt());
    }

    public function testPostCreatedAtFormatedIsNullByDefault(): void
    {
        $post = new Post(
            0,
            'Title',
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

        $this->assertEquals('06.09.2024', $post->getCreatedAtFormated());
    }
    public function testPostUpdatedAtIsNullByDefault(): void
    {
        $post = new Post;

        $this->assertNull($post->getUpdatedAt());
    }

    public function testPostUpdatedFormatedAtIsNullByDefault(): void
    {
        $post = new Post(
            0,
            'Title',
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

        $this->assertEquals('06.09.2024', $post->getUpdatedAtFormated());
    }
}
