<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Donation;
use App\Domain\Donation\DonationFormular;
use App\Domain\Donation\Donor;
use Cake\Validation\Validator;
use Psr\Log\LoggerInterface;

final class DonationCreator
{
    private LoggerInterface $logger;

    private Mailer $mailer;

    private Validator $validator;

    public function __construct(LoggerInterface $logger, Mailer $mailer, Validator $validator)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->validator = $validator;
    }

    private function validate(array $formData): void
    {
        $this->validator
            ->requirePresence('firstname')
            ->notEmptyString('firstname', 'Bitte geben Sie einen Namen ein.')
            ->requirePresence('street')
            ->notEmptyString('street', 'Bitte geben Sie ihre Straße an.')
            ->requirePresence('zip')
            ->notEmptyString('zip', 'Bitte geben Sie ihre Postleitzahl ein.')
            ->requirePresence('city')
            ->notEmptyString('city', 'Bitte geben Sie ihre Stadt ein.')
            ->requirePresence('email')
            ->notEmptyString('email', 'Bitte geben Sie ihre Email-Addresse ein.')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'Bitte geben Sie eine korrekte E-Mail-Addresse ein.']);

        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                foreach ($error as $value) {
                    echo "<p>$value</p>";
                }
            }
            
            die;
        }
    }

    public function create(array $formData): void
    {
        $this->validate($formData);

        $formular = new DonationFormular;
        $formular->setOneTimeDonationAmount((float) $formData['one-time-donation']);
        $formular->setWishPipe((bool) $formData['no-wish-pipe']);
        $formular->setWork((string) $formData['work']);
        $formular->setRegister((string) $formData['register']);
        $formular->setSound((string) $formData['sound'] ?? '');
        $formular->setAlternativeForDonor((bool) $formData['alternative-pipe']);
        $formular->setWishPipe((bool) $formData['wishorganpipe']);
        $formular->setGift((bool) $formData['gift']);
        $formular->setNamesOfGiftRecipients((array) $formData['name-recipients']);
        $formular->setDonationCertificate((bool) $formData['donation-certificate']);
        $formular->setConsent((bool) $formData['consent']);

        $donor = new Donor;
        $donor->setFirstName($formData['firstname']);
        $donor->setGivenName($formData['givenname']);
        $donor->setStreet($formData['street']);
        $donor->setZipCode($formData['zip']);
        $donor->setCity($formData['city']);
        $donor->setEmailAdress($formData['email']);
        $donor->setPhoneNumber($formData['phone']);

        $donation = new Donation($formular, $donor);
        $res = $donation->create();

        dd($formData, $donor, $formular, $res);
    }
}
