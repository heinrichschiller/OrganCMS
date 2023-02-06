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
        private string $total,
        private string $date,
        private string $user
    ) {
        $this->setTotal($total);
        $this->setDate($date);
        $this->setUser($user);
    }

    /**
     * Get total sum
     *
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * Set total sum
     *
     * @param string $total
     */
    public function setTotal(string $total): void
    {
        $total = trim($total, " \n\r\t\v\0");

        $this->total = $total;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $date = trim($date, " \n\r\t\v\0");
        
        $this->date = $date;
    }

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $user = trim($user, " \n\r\t\v\0");

        $this->user = $user;
    }

    /**
     * Get german date
     * @return string
     */
    public function getGermanDate(): string
    {
        $datePieces = explode('-', $this->date);

        return sprintf('%s.%s.%s', $datePieces[2], $datePieces[1], $datePieces[0]);
    }
}
