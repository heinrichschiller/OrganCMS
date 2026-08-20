<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Exception;

use App\Domain\Exception\DomainRecordNotFoundException;

final class DsgvoNotFoundException extends DomainRecordNotFoundException
{
    public function __construct()
    {
        parent::__construct('Die DSGVO-Daten wurden nicht gefunden.');
    }
}
