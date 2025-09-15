<?php

declare(strict_types=1);

namespace Tests\Domain\Event;

use App\Domain\Event\Data\EventNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(EventNotFoundException::class)]
#[CoversMethod(EventNotFoundException::class, 'functionWithoutName')]
class EventNotFoundExceptionTest extends TestCase
{
    public function testCoverageOnly(): void
    {
        $exception = new EventNotFoundException('Event not found.');

        // Einmal aufrufen, damit die Methode als getestet gilt
        $this->assertSame('Event not found.', $exception->functionWithoutName());
    }
}
