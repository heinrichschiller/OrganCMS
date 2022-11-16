<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Register;
use PHPUnit\Framework\TestCase;

class RegisterClass extends TestCase
{
    /** @covers App\Domain\Donation\Register */
    public function testRegisterTest(): void
    {
        $register = new Register(1, 'name');

        $this->assertInstanceOf(Register::class, $register);
    }
}
