<?php

declare(strict_types=1);

namespace App\Domain\Event\Exception;

use App\Domain\Exception\DomainValidationException;

final class EventValidationException extends DomainValidationException
{
    public function __construct(
        private array $errors
    ) {
        parent::__construct('Die Event-Daten sind ungültig.');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getMessages(): array
    {
        $messages = [];

        foreach ($this->errors as $error) {
            foreach ($error as $message) {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
