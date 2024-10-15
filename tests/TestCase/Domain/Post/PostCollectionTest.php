<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Post\Data\PostCollection;
use App\Domain\Post\Data\Post;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PostCollection::class)]
final class PostCollectionTest extends TestCase
{
    public function testAddAndIterate(): void
    {
        $collection = new PostCollection();
        
        $post1 = $this->createMock(Post::class);
        $post2 = $this->createMock(Post::class);
        
        $collection->add($post1);
        $collection->add($post2);
        
        $this->assertCount(2, iterator_to_array($collection));
        $this->assertSame([$post1, $post2], iterator_to_array($collection));
    }
}
