<?php

declare(strict_types=1);

namespace Tests\Domain\Supporter;

use App\Domain\Supporter\Data\Supporter;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Supporter::class)]
#[CoversMethod(Supporter::class, 'getId')]
#[CoversMethod(Supporter::class, 'getName')]
#[CoversMethod(Supporter::class, 'isPublished')]
#[CoversMethod(Supporter::class, 'getPublishedAt')]
#[CoversMethod(Supporter::class, 'getCreatedAt')]
#[CoversMethod(Supporter::class, 'getUpdatedAt')]
class SupporterTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testSupporterIsCreatedWithValues(): void
    {
        $publishedAt = new DateTimeImmutable('2025-05-16');
        $createdAt = new DateTimeImmutable('2025-05-16');
        $updatedAt = new DateTimeImmutable('2025-05-16');

        $supporter = new Supporter(
            id: 1,
            name: ' test name ',
            isPublished: true,
            publishedAt: $publishedAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->assertSame(1, $supporter->getId());
        $this->assertSame('test name', $supporter->getName());
        $this->assertTrue($supporter->isPublished());
        $this->assertEquals($publishedAt, $supporter->getPublishedAt());
        $this->assertEquals($createdAt, $supporter->getCreatedAt());
        $this->assertEquals($updatedAt, $supporter->getUpdatedAt());
    }
}
