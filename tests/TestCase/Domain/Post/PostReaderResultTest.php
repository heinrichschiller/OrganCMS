<?php

declare(strict_types=1);

namespace Tests\Domain\Post\PostReaderResult;

use App\Domain\Post\Data\PostReaderResult;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostReaderResult::class)]
#[CoversMethod(PostReaderResult::class, 'getId')]
#[CoversMethod(PostReaderResult::class, 'getTitle')]
class PostReaderResultTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testPostIsCreatedWithValues(): void
    {
        $publishedAt = new DateTimeImmutable('2025-05-29');
        $createdAt = new DateTimeImmutable('2025-05-29');
        $updatedAt = new DateTimeImmutable('2025-05-29');

        $postResult = new PostReaderResult(
            id: 1,
            title: '  test post ',
            slug: 'test/slug',
            intro: 'Intro',
            content: 'Full content here.',
            onMainpage: true,
            publishedAt: $publishedAt,
            isPublished: false,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->assertSame(1, $postResult->getId());
        $this->assertSame('Test post', $postResult->getTitle());
        $this->assertSame('test/slug', $postResult->getSlug());
        $this->assertSame('Intro', $postResult->getIntro());
        $this->assertSame('Full content here.', $postResult->getContent());
        $this->assertTrue($postResult->onMainpage());
        $this->assertEquals($publishedAt, $postResult->getPublishedAt());
        $this->assertEquals('29.05.2025', $postResult->getPublishedAtFormated());
        $this->assertSame('29.05.2025', $postResult->getUpdatedAtFormated());
        $this->assertFalse($postResult->isPublished());
        $this->assertEquals($createdAt, $postResult->getCreatedAt());
        $this->assertSame('29.05.2025', $postResult->getCreatedAtFormated());
        $this->assertEquals($updatedAt, $postResult->getUpdatedAt());
        $this->assertSame('29.05.2025', $postResult->getUpdatedAtFormated());
    }
}
