<?php

declare(strict_types = 1);

namespace App\Domain\Settings;

final class BankAccount
{
    public function __construct(
        private ?string $recipient = null,
    ) {
        $this->setRecipient($recipient);
    }

    public function getRecipient(): string|null
    {
        return $this->recipient;
    }

    private function setRecipient(string|null $recipient): void
    {
        if (null !== $recipient) {
            $recipient = trim($recipient, " \n\r\t\v\0");
            $recipient = ucfirst($recipient);
        }

        $this->recipient = $recipient;
    }
}
