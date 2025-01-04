<?php

declare(strict_types=1);

namespace Tests\Domain\Donation;

use App\Domain\Donation\Register;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Register::class)]
class RegisterTest extends TestCase
{
    public function testRegisterTest(): void
    {
        $register = new Register(1, 'name');

        $this->assertInstanceOf(Register::class, $register);
    }
}
