<?php

declare(strict_types=1);

namespace Tests\Domain\Supporter;

use App\Domain\Supporter\Supporter;
use PHPUnit\Framework\TestCase;

class SupporterTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterInstance(): void
    {
        $supporter = new Supporter;

        $this->assertInstanceOf(Supporter::class, $supporter);
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterIdIsEmptyByDefault(): void
    {
        $supporter = new Supporter();

        $this->assertEmpty($supporter->getId());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterIdHasInput(): void
    {
        $supporter = new Supporter(1);

        $this->assertEquals(1, $supporter->getId());
    }
    
    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterNameIsEmptyByDefault(): void
    {
        $supporter = new Supporter;

        $this->assertEmpty($supporter->getName());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterNameHasInput(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller');

        $this->assertEquals('Heinrich Schiller', $supporter->getName());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterNameDoesNotStartOrEndWithWhitespace(): void
    {
        $supporter = new Supporter(0, ' Heinrich Schiller ');

        $this->assertEquals('Heinrich Schiller', $supporter->getName());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterPublishedStatusIsFalseByDefault(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller');

        $this->assertFalse($supporter->isPublished());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterPublishedStatusIsTrue(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller', true);

        $this->assertTrue($supporter->isPublished());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterPublishedAtIsEmptyByDefault(): void
    {
        $supporter = new Supporter(0, 'Heinrich Schiller', false);

        $this->assertEmpty($supporter->getPublishedAt());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterPublishedAtHasInput(): void
    {
        $supporter = new Supporter(1, 'Heinrich Schiller', true, '05-13-2022');

        $this->assertSame('05-13-2022', $supporter->getPublishedAt());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterCreatedAtIsEmptyByDefault(): void
    {
        $supporter = new Supporter(1, 'Heinrich Schiller', true, '05-13-2022');

        $this->assertEmpty($supporter->getCreatedAt());
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
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

    /**
     * @covers App\Domain\Supporter\Supporter
     */
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

    /**
     * @covers App\Domain\Supporter\Supporter
     */
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
