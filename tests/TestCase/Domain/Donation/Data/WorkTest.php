<?php

declare(strict_types=1);

namespace Tests\Domain\Donation\Data;

use App\Domain\Donation\Data\Work;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Work::class)]
class WorkTest extends TestCase
{
    #[Test]
    public function testWorkTest(): void
    {
        $work = new Work(1, 'name');

        $this->assertInstanceOf(Work::class, $work);
    }
}
