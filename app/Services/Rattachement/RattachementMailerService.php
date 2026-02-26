<?php

namespace App\Services\Rattachement;

use Illuminate\Support\Facades\Mail;
use App\Mail\{
    RattachementBlValideMail,
    RattachementBlInvalideMail,
    RattachementRemiseRejeteMail
};

class RattachementMailerService
{
    private array $cc = [
        'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',
        //'noreplysitedt@gmail.com'
    ];

    private array $cc_remise = [
        //'sn004-proforma@dakar-terminal.com',
        //'sn004-facturation@dakar-terminal.com',
        'noreplysitedt@gmail.com'
    ];

    public function sendValidation($rattachement): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(
                new RattachementBlValideMail(
                    $rattachement->bl,
                    $rattachement->nom,
                    $rattachement->prenom
                )
            );
    }

    public function sendRejection($rattachement, string $motif): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(
                new RattachementBlInvalideMail(
                    $rattachement->bl,
                    $rattachement->nom,
                    $rattachement->prenom,
                    $motif
                )
            );
    }

    /*
    public function sendRemiseValidation($rattachement): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(
                new RattachementBlValideMail(
                    $rattachement->bl,
                    $rattachement->nom,
                    $rattachement->prenom
                )
            );
    }*/

    public function sendRemiseRejete($rattachement, string $motif): void
{
    Mail::to($rattachement->email)
        ->cc($this->cc_remise)
        ->send(
            new RattachementRemiseRejeteMail(
                $rattachement->bl,
                $rattachement->nom,
                $rattachement->prenom,
                $motif
            )
        );
}
}
