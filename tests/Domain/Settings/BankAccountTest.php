<?php

declare(strict_types = 1);

namespace Tests\Domain\Settings;

use App\Domain\Settings\BankAccount;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    public function setUp(): void
    {
        // do something ...
    }

    /**
     * @covers App\Domain\Settings\BankAccount
     */
    public function testBankAccountInstance(): void
    {
        $bankAccount = new BankAccount;

        $this->assertInstanceOf(BankAccount::class, $bankAccount);
    }

    /**
     * @covers App\Domain\Settings\BankAccount
     */
    public function testRecipientIsNullByDefault(): void
    {
        $bankAccount = new BankAccount;

        $this->assertNull($bankAccount->getRecipient());
    }

    /**
     * @covers App\Domain\Settings\BankAccount
     */
    public function testRecipientHasInput(): void
    {
        $bankAccount = new BankAccount('Ev.Luth.Lutherkirche Plauen');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }

    /**
     * @covers App\Domain\Settings\BankAccount
     */
    public function testRecipientDoesNotStartOrEndWithAnWhitespace(): void
    {
        $bankAccount = new BankAccount(' Ev.Luth.Lutherkirche Plauen ');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }

    /**
     * @covers App\Domain\Settings\BankAccount
     */
    public function testRecipientStartWithUppercase(): void
    {
        $bankAccount = new BankAccount(' ev.Luth.Lutherkirche Plauen ');

        $this->assertSame('Ev.Luth.Lutherkirche Plauen', $bankAccount->getRecipient());
    }
}
