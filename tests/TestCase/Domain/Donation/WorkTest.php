<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Work;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Work::class)]
class WorkTest extends TestCase
{
    public function testWorkTest(): void
    {
        $work = new Work(1, 'name');

        $this->assertInstanceOf(Work::class, $work);
    }
}
