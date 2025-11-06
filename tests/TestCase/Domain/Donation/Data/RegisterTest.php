<?php

declare(strict_types=1);

namespace Tests\Domain\Donation\Data;

use App\Domain\Donation\Data\Register;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Register::class)]
class RegisterTest extends TestCase
{
    #[Test]
    public function registerTest(): void
    {
        $register = new Register(1, 'name');

        $this->assertInstanceOf(Register::class, $register);
    }
}
