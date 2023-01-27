<?php

declare(strict_types=1);

namespace Tests\Domain\Supporter;

use App\Domain\Supporter\Supporter;
use App\Domain\Supporter\SupporterCollection;
use ArrayIterator;
use PHPUnit\Framework\TestCase;

class SupporterCollectionTest extends TestCase
{
    public function setUp(): void
    {
        // nothing here
    }

    /**
     * @covers App\Domain\Supporter\SupporterCollection
     */
    public function testSupporterCollectionInstance(): void
    {
        $collection = new SupporterCollection;

        $this->assertInstanceOf(SupporterCollection::class, $collection);
    }

    /**
     * @covers App\Domain\Supporter\Supporter
     */
    public function testSupporterCollectionCanBeIterated():void
    {
        $heinrich = new Supporter(1, 'Heinrich Schiller');
        $ella = new Supporter(2, 'Ella Lemke');
        $david = new Supporter(3, 'David Kreller');

        $collection = new SupporterCollection;

        $collection->add($heinrich);
        $collection->add($ella);
        $collection->add($david);

        foreach ($collection as $item) {
            $items[] = $item;
        }

        $this->assertCount(3, $items);
        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
    }
}
