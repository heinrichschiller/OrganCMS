<?php

declare(strict_types=1);

namespace Tests\Domain\Post\PostReaderResult;

use App\Domain\Post\Data\PostReaderResult;
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

    public function testIdIsNullByDefault(): void
    {
        $result = new PostReaderResult;

        $this->assertNull($result->getId());
    }

    public function testTitleIsNullByDefault(): void
    {
        $result = new PostReaderResult;

        $this->assertNull($result->getTitle());
    }

    public function testTitleHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title');

        $this->assertEquals('Title', $result->getTitle());
    }

    public function testSlugHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug');

        $this->assertEquals('/slug', $result->getSlug());
    }

    public function testIntroHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'Intro');

        $this->assertEquals('Intro', $result->getIntro());
    }

    public function testContentHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'Intro', 'Content');

        $this->assertEquals('Content', $result->getContent());
    }

    public function testAuthorIdHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'Intro', 'Content', 1);

        $this->assertEquals(1, $result->getAuthorId());
    }

    public function testOnMainpageHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'Intro', 'Content', 1, true);

        $this->assertTrue($result->onMainpage());
    }

    public function testPublishedAtHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'intro', 'content', 1, false, '2024-09-06 08:50:00');

        $this->assertEquals('2024-09-06 08:50:00', $result->getPublishedAt());
    }

    public function testPublishedAtFormatedIsNullByDefault(): void
    {
        $result = new PostReaderResult;

        $this->assertNull($result->getPublishedAtFormated());
    }

    public function testPublishedAtFormatedHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'intro', 'content', 1, false, '2024-09-06 08:50:00');

        $this->assertEquals('06.09.2024', $result->getPublishedAtFormated());
    }

    public function testIsPublishedHasInput(): void
    {
        $result = new PostReaderResult(0, 'Title', '/slug', 'intro', 'content', 1, false, '2024-09-06 08:50:00', true);

        $this->assertTrue($result->isPublished());
    }

    public function testCreatedAtHasInput(): void
    {
        $result = new PostReaderResult(
            0,
            'Title',
            '/slug',
            'intro',
            'content',
            1,
            false,
            '2024-09-06 08:50:00',
            true,
            '2024-09-06 08:50:00'
        );

        $this->assertEquals('2024-09-06 08:50:00', $result->getCreatedAt());
    }

    public function testUpdatedAtHasInput(): void
    {
        $result = new PostReaderResult(
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

        $this->assertEquals('2024-09-06 08:50:00', $result->getUpdatedAt());
    }
}
