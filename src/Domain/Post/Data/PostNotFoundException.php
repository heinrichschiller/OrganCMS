<?php

declare(strict_types=1);

namespace App\Domain\Post\Data;

use App\Domain\DomainException\DomainRecordNotFoundException;

class PostNotFoundException extends DomainRecordNotFoundException
{
    protected $message = 'Post not found.';

    public function functionWithoutName()
    {
        return $this->message;
    }
}
