<?php

declare(strict_types=1);

namespace App\Domain\Post;

use App\Domain\DomainException\DomainRecordNotFoundException;

class PostNotFoundException extends DomainRecordNotFoundException
{
    private $messager = 'Post not found.';

    public function functionWithoutName()
    {
        return $this->message;
    }
}
