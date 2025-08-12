<?php

declare(strict_types=1);

namespace Tests\Domain\Post;

use App\Domain\Post\Data\PostNotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostNotFoundException::class)]
#[CoversMethod(PostNotFoundException::class, 'functionWithoutName')]
class PostNotFoundExceptionTest extends TestCase
{
    public function testCoverageOnly(): void
    {
        $exception = new PostNotFoundException('Post not found.');

        // Einmal aufrufen, damit die Methode als getestet gilt
        $this->assertSame('Post not found.', $exception->functionWithoutName());
    }
}
