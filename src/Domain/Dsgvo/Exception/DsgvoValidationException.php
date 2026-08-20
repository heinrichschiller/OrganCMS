<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Exception;

use App\Domain\Exception\DomainValidationException;

final class DsgvoValidationException extends DomainValidationException
{
    /**
     * @param array<mixed> $errors
     */
    public function __construct(
        private array $errors
    ) {
        parent::__construct('Die DSGVO-Daten sind ungültig.');
    }

    /**
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array<mixed>
     */
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
