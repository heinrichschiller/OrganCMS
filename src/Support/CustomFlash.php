<?php

declare(strict_types=1);

namespace App\Support;

use Odan\Session\FlashInterface;

final class CustomFlash
{
    private FlashInterface $flash;

    public function __construct(FlashInterface $flash)
    {
        $this->flash = $flash;
    }

    public function success(string $message): void
    {
        $this->flash->clear();
        $this->flash->add('success', $message);
    }

    public function error(string $message): void
    {
        $this->flash->clear();
        $this->flash->add('error', $message);
    }

    /**
     * @return array {
     *   isSuccess: bool,
     *   isError: bool,
     *   message: string
     * }
     */
    public function readStatus(): array
    {
        $isSuccess = false;
        $isError = false;
        $message = '';

        if ($this->flash->has('success')) {
            $isSuccess = true;
            $message = $this->flash->get('success')[0] ?? '';
        }

        if ($this->flash->has('error')) {
            $isError = true;
            $message = $this->flash->get('error')[0] ?? '';
        }

        $this->flash->clear();

        return [
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];
    }
}
