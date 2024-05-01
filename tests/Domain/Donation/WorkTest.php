<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Work;
use PHPUnit\Framework\TestCase;

class WorkTest extends TestCase
{
    /** @covers App\Domain\Donation\Work */
    public function testWorkTest(): void
    {
        $work = new Work(1, 'name');

        $this->assertInstanceOf(Work::class, $work);
    }
}
