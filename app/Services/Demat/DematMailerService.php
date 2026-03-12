<?php

namespace App\Services\Demat;

use Illuminate\Support\Facades\Mail;
use App\Mail\ValidationDematMail;
use App\Mail\RemiseDematMail;

class DematMailerService
{
    private array $destinataires = [
        'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',
        //'noreplysitedt@gmail.com'
    ];

    private array $destinataires_remise = [
        'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',
        'assane.diouf@dakar-terminal.com',
        //'noreplysitedt@gmail.com',
        //'iosid242@gmail.com'
    ];

    public function send(array $data, array $files): void
    {
        Mail::to($this->destinataires)
            ->send(new ValidationDematMail($data, $files));
    }

    public function sendRemise(array $data, array $files): void
    {
        Mail::to($this->destinataires_remise)
            ->send(new RemiseDematMail($data, $files));
    }
}
