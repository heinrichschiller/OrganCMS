<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Exception;

use App\Domain\Exception\DuplicateRecordException;

final class SupporterAlreadyExistsException extends DuplicateRecordException
{
    public function __construct(
        private string $supporterName
    ) {
        parent::__construct(
            sprintf(
                'Ein Supporter mit dem Namen "%s" existiert bereits.',
                $supporterName
            )
        );
    }

    public function getSupporterName(): string
    {
        return $this->supporterName;
    }
}
