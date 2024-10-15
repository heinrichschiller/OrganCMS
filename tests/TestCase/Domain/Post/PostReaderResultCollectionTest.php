<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Post\Data\PostReaderResultCollection;
use App\Domain\Post\Data\PostReaderResult;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PostReaderResultCollection::class)]
final class PostReaderResultCollectionTest extends TestCase
{
    public function testAddAndIterate(): void
    {
        $collection = new PostReaderResultCollection();
        
        $post1 = $this->createMock(PostReaderResult::class);
        $post2 = $this->createMock(PostReaderResult::class);
        
        $collection->add($post1);
        $collection->add($post2);
        
        $this->assertCount(2, iterator_to_array($collection));
        $this->assertSame([$post1, $post2], iterator_to_array($collection));
    }
}
