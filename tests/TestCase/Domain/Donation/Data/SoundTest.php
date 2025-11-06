<?php

declare(strict_types=1);

namespace Tests\Domain\Data\Donation\Data;

use App\Domain\Donation\Data\Sound;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Sound::class)]
class SoundTest extends TestCase
{
    #[Test]
    public function testSoundTest(): void
    {
        $sound = new Sound(1, 'name', 500);

        $this->assertInstanceOf(Sound::class, $sound);
    }
}
