<?php

declare(strict_types=1);

namespace Tests\Domain\Post;

use App\Domain\Post\Data\PostNotFoundException;
use PHPUnit\Framework\TestCase;

class PostNotFoundExceptionTest extends TestCase
{
    public function testCoverageOnly(): void
    {
        $exception = new PostNotFoundException('Just for coverage');

        // Einmal aufrufen, damit die Methode als getestet gilt
        $this->assertSame('Just for coverage', $exception->functionWithoutName());
    }
}
