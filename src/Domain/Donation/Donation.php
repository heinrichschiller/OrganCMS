<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Donation
{
    private string $donationAmountOption = '';
    private string $wishPipeOption = '';
    private string $alternativePipeOption = '';
    private string $pipeSponsorshipOption = '';
    private string $giftOption = '';
    private string $certificateOption = '';
    private string $agreementOption = '';
    private array $mailPieces = [];

    private DonationFormular $formular;
    private Donor $donor;

    public function __construct(DonationFormular $formular, Donor $donor)
    {
        $this->formular = $formular;
        $this->donor = $donor;
    }

    public function create(): array
    {
        $this->getHeader();
        $this->getDonationAmountOption();
        $this->getWishPipeOption();
        $this->getAlternativePipeOption();
        $this->getFooter();

        return $this->mailPieces;
    }

    public function getHeader(): void
    {
        $text = '<p>Sehr geehrte/r Herr/Frau '
            . $this->donor->getFullName()
            . ',</p><p>vielen Dank für ihre großzügige Spende.</p>'
            .'<p>Das ist eine automatisch generierte Antwort und wir werden uns mit ihnen bald in Verbindung setzen.</p>'
            .'<p>Weiter können Sie ihre Eingaben nochmal einsehen und prüfen.</p><hr>';
        
        $this->mailPieces[] = $text;
    }

    public function getFooter(): void
    {
        $text = '<hr>'
            . '<p>Sollte ihnen ein Fehler unterlaufen sein, können wir das natürlich nachträglich korrigieren.</p>'
            . '<br>'
            . '<p>Mit freundliche Grüßen</p>'
            . '<p>Orgelfreunde Plauen</p>';

        $this->mailPieces[] = $text;
    }

    public function getDonationAmountOption(): void
    {
        $title = '';
        $text = '';

        if ($this->formular->getOneTimeDonationAmount()) {
            $title = '<h3>Sie möchten den Neubau der Orgel in der '
            . 'Lutherkirche zu Plauen mit einer Spende unterstützen?</h3>';

            $text = '<p>Ja, ich/wir möchte(n) den Neubau der Orgel in der '
                . 'Lutherkirche zu Plauen mit einer einmaligen Spende unterstützen. Den Betrag von ' 
            . $this->formular->getOneTimeDonationAmount() 
            . ' € werde(n) ich/wir auf das Konto der '
            . 'Ev.-Luth. Lutherkirche Plauen, Zahlungsgrund: Orgel überweisen.</p>';

            $this->mailPieces[] = $title;
            $this->mailPieces[] = $text;
        }
    }

    public function getWishPipeOption(): void
    {
        $text = '';

        if ( $this->formular->isWishPipe() ) {
            $text = '<p>Ich/wir haben keine Wunschorgelpfeife. Bitte weisen Sie' 
                . ' mir/uns eine Pfeife zu, die dem angegebenen Betrag entspricht.</p>';

            $this->mailPieces[] = $text;
        }
    }

    public function getAlternativePipeOption(): void
    {
        if ( $this->formular->isAlternativeForDonor() ) {
            $text = '<p>Ich/wir haben keine Wunschorgelpfeife. Bitte weisen Sie' 
                . ' mir/uns eine Pfeife zu, die dem angekreuzten Betrag entspricht.</p>';

            $this->mailPieces[] = $text;
        } 
    }

    public function getDonor(): Donor
    {
        return $this->donor;
    }
}