<?php

namespace App\Services\Facture;

use Illuminate\Support\Facades\Mail;
use App\Mail\{
    FactureDocumentsMail,
    FactureValidateMail,
    FactureRelanceMail,
    FactureExistMail,
    ProformaGenerateMail
};

class FactureMailerService
{
    private array $cc = [
        /*'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',*/
        'noreplysitedt@gmail.com'
    ];

    public function sendDocuments($rattachement, $facture, array $documents): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new FactureDocumentsMail([
                'email' => $rattachement->email,
                'prenom' => $rattachement->prenom,
                'nom' => $rattachement->nom,
                'bl' => $rattachement->bl,
                'date' => $facture->created_at,
                'documents' => $documents,
            ]));
    }

    public function sendComplement(array $data): void
    {
        Mail::to($this->cc)->send(new ProformaGenerateMail($data));
    }

    public function sendValidate(array $data): void
    {
        Mail::to($this->cc)->send(new FactureValidateMail($data));
    }

    public function sendRelance(array $data): void
    {
        Mail::to($this->cc)->send(new FactureRelanceMail($data));
    }

    /*
    public function sendReject($rattachement, $motif, $autreMotif): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new FactureExistMail(
                $rattachement->bl,
                $rattachement->nom,
                $rattachement->prenom,
                $motif,
                $autreMotif
            ));
    }*/

    public function sendReject($rattachement, string $motif): void
{
    Mail::to($rattachement->email)
        ->cc($this->cc)
        ->send(new FactureExistMail(
            $rattachement->bl,
            $rattachement->nom,
            $rattachement->prenom,
            $motif
        ));
}

}
