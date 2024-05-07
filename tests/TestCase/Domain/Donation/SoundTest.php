<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Sound;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Sound::class)]
class SoundTest extends TestCase
{
    public function testSoundTest(): void
    {
        $sound = new Sound(1, 'name', 500);

        $this->assertInstanceOf(Sound::class, $sound);
    }
}
