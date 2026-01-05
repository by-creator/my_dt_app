<?php

namespace App\Services\Bon;

use Illuminate\Support\Facades\Mail;
use App\Mail\{
    BonDocumentsMail,
    BonRelanceMail,
    BadExistMail
};

class BonMailerService
{
    private array $cc = [
        /*'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',*/
        'noreplysitedt@gmail.com'
    ];

    public function sendDocuments($rattachement, $bon, array $documents): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new BonDocumentsMail([
                'email' => $rattachement->email,
                'prenom' => $rattachement->prenom,
                'nom' => $rattachement->nom,
                'bl' => $rattachement->bl,
                'date' => $bon->created_at,
                'documents' => $documents,
            ]));
    }

    public function sendRelance(array $data): void
    {
        Mail::to($this->cc)->send(new BonRelanceMail($data));
    }

    public function sendReject($rattachement, $motif): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new BadExistMail(
                $rattachement->bl,
                $rattachement->nom,
                $rattachement->prenom,
                $motif
            ));
    }
}
