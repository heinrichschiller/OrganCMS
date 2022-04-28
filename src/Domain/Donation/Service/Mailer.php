<?php

declare( strict_types = 1 );

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Donation;
use App\Domain\Donation\Donor;
use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    /**
     * @Injection
     * @var PHPMailer
     */
    private PHPMailer $mailer;

    /**
     * The constructor.
     *
     * @param PHPMailer $mailer
     */
    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Donation $donation, Donor $donor)
    {
        // $this->mailer->setFrom('info@mailtrap.io', 'Mailtrap');
        // $this->mailer->addAddress('recipient1@mailtrap.io', $donation->getFullName());
        // $this->mailer->addReplyTo('info@mailtrap.io', 'Mailtrap');
        // $this->mailer->Subject = 'Ihr Spendenantrag';

        // $this->mailer->setFrom('info@lutherorgel-plauen.de', 'Orgelfreunde-Plauen');
        // $this->mailer->addAddress('info@heinrich-schiller.de', $donation->getFullName());
        // $this->mailer->addAddress($donation->getEmail(), $donation->getFullName());
        // $this->mailer->addReplyTo('info@lutherorgel-plauen.de', 'Information');
        // $this->mailer->Subject = 'Ihr Spendenantrag';

        // $mailContent = $donation->getMailBody();

        // $this->mailer->isHTML(true);
        // $this->mailer->Body = $mailContent;

        if ($this->mailer->send()) {
            echo 'Vielen Dank für ihre Spende! Sie bekommen in kürze eine Email.';
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
        }
    }
}
