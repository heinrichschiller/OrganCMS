<?php

declare(strict_types=1);

namespace Tests\Domain\Supporter;

use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Data\SupporterCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SupporterCollection::class)]
class SupporterCollectionTest extends TestCase
{
    public function testSupporterCollectionCanBeIterated():void
    {
        $collection = new SupporterCollection;

        $supporter1 = $this->createMock(Supporter::class);
        $supporter2 = $this->createMock(Supporter::class);

        $collection->add($supporter1);
        $collection->add($supporter2);

        $this->assertCount(3, iterator_to_array($collection));
        $this->assertSame([$supporter1, $supporter2], iterator_to_array($collection));
    }
}
