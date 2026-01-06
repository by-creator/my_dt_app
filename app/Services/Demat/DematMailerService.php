<?php

namespace App\Services\Demat;

use Illuminate\Support\Facades\Mail;
use App\Mail\ValidationDematMail;

class DematMailerService
{
    private array $destinataires = [
        /*'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',*/
        'noreplysitedt@gmail.com'
    ];

    public function send(array $data, array $files): void
    {
        Mail::to($this->destinataires)
            ->send(new ValidationDematMail($data, $files));
    }
}
