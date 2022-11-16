<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Sound;
use PHPUnit\Framework\TestCase;

class SoundTest extends TestCase
{
    /** @covers App\Domain\Donation\Sound */
    public function testSoundTest(): void
    {
        $sound = new Sound(1, 'name', 500);

        $this->assertInstanceOf(Sound::class, $sound);
    }
}
