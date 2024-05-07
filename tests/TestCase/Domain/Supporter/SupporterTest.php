<?php

declare(strict_types=1);

namespace Tests\Domain\Supporter;

use App\Domain\Supporter\Supporter;
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

    public function testSupporterInstance(): void
    {
        $supporter = new Supporter;

        $this->assertInstanceOf(Supporter::class, $supporter);
    }

    public function testSupporterIdIsNullByDefault(): void
    {
        $supporter = new Supporter();

        $this->assertNull($supporter->getId());
    }

    public function testSupporterIdHasInput(): void
    {
        $supporter = new Supporter(1);

        $this->assertEquals(1, $supporter->getId());
    }
    
    public function testSupporterNameIsNullByDefault(): void
    {
        $supporter = new Supporter(0);

        $this->assertNull($supporter->getName());
    }

    public function testSupporterNameHasInput(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller');

        $this->assertEquals('Heinrich Schiller', $supporter->getName());
    }

    public function testSupporterNameDoesNotStartOrEndWithWhitespace(): void
    {
        $supporter = new Supporter(0, ' Heinrich Schiller ');

        $this->assertEquals('Heinrich Schiller', $supporter->getName());
    }

    public function testSupporterPublishedStatusIsFalseByDefault(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller');

        $this->assertFalse($supporter->isPublished());
    }

    public function testSupporterPublishedStatusIsTrue(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller', true);

        $this->assertTrue($supporter->isPublished());
    }

    public function testSupporterPublishedAtIsNullByDefault(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller', false);

        $this->assertNull($supporter->getPublishedAt());
    }

    public function testSupporterPublishedAtHasInput(): void
    {
        $supporter = new Supporter(1, 'Heinrich Schiller', true, '05-13-2022');

        $this->assertSame('05-13-2022', $supporter->getPublishedAt());
    }

    public function testSupporterCreatedAtIsNullByDefault(): void
    {
        $supporter = new Supporter(1, 'Heinrich Schiller', true, '05-13-2022');

        $this->assertNull($supporter->getCreatedAt());
    }

    public function testSupporterCreatedAtHasInput(): void
    {
        $supporter = new Supporter(
            1,
            'Heinrich Schiller',
            true,
            '05-13-2022',
            '05-13-2022'
        );

        $this->assertSame('05-13-2022', $supporter->getCreatedAt());
    }

    public function testSupporterUpdatedAtIsEmptyByDefault(): void
    {
        $supporter = new Supporter(
            1,
            'Heinrich Schiller',
            true,
            '05-13-2022',
            '05-13-2022'
        );

        $this->assertEmpty($supporter->getUpdatedAt());
    }

    public function testSupporterUpdatedAtHasInput(): void
    {
        $supporter = new Supporter(
            1,
            'Heinrich Schiller',
            true,
            '05-13-2022',
            '05-13-2022',
            '05-13-2022'
        );

        $this->assertSame('05-13-2022', $supporter->getUpdatedAt());
    }
}
