<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class DonationDetails
{
    /**
     * The constructor.
     *
     * @param string $total Total donations sum
     * @param string $date Date of last donation sum
     * @param string $user Author
     */
    public function __construct(
        private ?string $total = null,
        private ?string $date = null,
        private ?string $user = null
    ) {
        $this->setTotal($total);
        $this->setDate($date);
        $this->setUser($user);
    }

    /**
     * Get total sum
     *
     * @return string|null
     */
    public function getTotal(): string|null
    {
        return $this->total;
    }

    /**
     * Set total sum
     *
     * @param string $total|null
     */
    private function setTotal(string|null $total): void
    {
        if (null !== $total) {
            $total = trim($total, " \n\r\t\v\0");
        }

        $this->total = $total;
    }

    /**
     * Get date.
     *
     * @return string|null
     */
    public function getDate(): string|null
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param string|null $date
     */
    private function setDate(string|null $date): void
    {
        if (null !== $date) {
            $date = trim($date, " \n\r\t\v\0");
        }
        
        $this->date = $date;
    }

    /**
     * Get user
     *
     * @return string|null $user
     */
    public function getUser(): string|null
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param string|null $user
     */
    private function setUser(string|null $user): void
    {
        if (null !== $user) {
            $user = trim($user, " \n\r\t\v\0");
        }

        $this->user = $user;
    }

    /**
     * Get german date.
     *
     * @return string
     */
    public function getGermanDate(): string
    {
        $datePieces = explode('-', $this->date);

        return sprintf('%s.%s.%s', $datePieces[2], $datePieces[1], $datePieces[0]);
    }
}
