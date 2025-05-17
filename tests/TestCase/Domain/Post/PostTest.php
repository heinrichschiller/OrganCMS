<?php

declare(strict_types=1);

namespace Tests\Domain\Post\PostTest;

use App\Domain\Post\Data\Post;
use DateTime;
use DateTimeImmutable;
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

    public function testPostIsCreatedWithValues(): void
    {
        $publishedAt = new DateTimeImmutable('2024-09-06 08:50:00');
        $createdAt = new DateTimeImmutable('2024-09-06 08:50:00');
        $updatedAt = new DateTimeImmutable('2024-09-06 08:50:00');

        $post = new Post(
            id: 1,
            title: ' post title ',
            slug: '/slug',
            intro: 'intro',
            content: 'content',
            authorId: 1,
            onMainpage: false,
            publishedAt: $publishedAt,
            isPublished: true,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->assertSame(1, $post->getId());
        $this->assertSame('Post title', $post->getTitle());
        $this->assertSame('/slug', $post->getSlug());
        $this->assertSame('intro', $post->getIntro());
        $this->assertSame('content', $post->getContent());
        $this->assertSame(1, $post->getAuthorId());
        $this->assertFalse($post->onMainpage());
        $this->assertEquals($publishedAt, $post->getPublishedAt());
        $this->assertTrue($post->isPublished());
        $this->assertEquals($publishedAt, $post->getPublishedAt());
        $this->assertEquals($createdAt, $post->getCreatedAt());
        $this->assertEquals($updatedAt, $post->getUpdatedAt());
    }
}
