<?php

declare(strict_types = 1);

namespace Tests\Domain\Settings;

use App\Domain\Settings\BankAccount;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(BankAccount::class)]
#[CoversMethod(BankAccount::class, 'getRecipient')]

class BankAccountTest extends TestCase
{
    public function setUp(): void
    {
        // do something ...
    }

    public function testBankAccountInstance(): void
    {
        $bankAccount = new BankAccount;

        $this->assertInstanceOf(BankAccount::class, $bankAccount);
    }

    public function testRecipientIsNullByDefault(): void
    {
        $bankAccount = new BankAccount;

        $this->assertNull($bankAccount->getRecipient());
    }

    public function testRecipientHasInput(): void
    {
        $bankAccount = new BankAccount('Ev.Luth.Lutherkirche Plauen');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }

    public function testRecipientDoesNotStartOrEndWithAnWhitespace(): void
    {
        $bankAccount = new BankAccount(' Ev.Luth.Lutherkirche Plauen ');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }

    public function testRecipientStartWithUppercase(): void
    {
        $bankAccount = new BankAccount(' ev.Luth.Lutherkirche Plauen ');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }
}
