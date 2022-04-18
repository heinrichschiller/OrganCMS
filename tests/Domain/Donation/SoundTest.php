<?php

declare(strict_types=1);

use App\Domain\Donation\Sound;
use PHPUnit\Framework\TestCase;

class SoundTest extends TestCase
{
    /** @covers App\Domain\Donation\Sound */
    public function testSoundTest(): void
    {
        $sound = new Sound(1, 'name');

        $this->assertInstanceOf(Sound::class, $sound);
    }
}
