<?php

namespace App\Services\Proforma;

use Illuminate\Support\Facades\Mail;
use App\Mail\{
    ProformaDocumentsMail,
    ProformaGenerateMail,
    ProformaRelanceMail,
    ProformaValidateMail,
    ProformaExistMail
};

class ProformaMailerService
{
    private array $cc = [
        'sn004-proforma@dakar-terminal.com',
        'sn004-facturation@dakar-terminal.com',
        //'noreplysitedt@gmail.com'
    ];

    public function sendDocuments($rattachement, $proforma, array $documents): void
    {
        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new ProformaDocumentsMail([
                'prenom' => $rattachement->prenom,
                'nom' => $rattachement->nom,
                'bl' => $rattachement->bl,
                'date' => $proforma->created_at,
                'documents' => $documents,
            ]));
    }

    public function sendGenerate(array $data): void
    {
        Mail::to($this->cc)->send(new ProformaGenerateMail($data));
    }

    public function sendRelance(array $data): void
    {
        Mail::to($this->cc)->send(new ProformaRelanceMail($data));
    }

    public function sendValidate(array $data): void
    {
        Mail::to($this->cc)->send(new ProformaValidateMail($data));
    }
    
    public function sendReject($rattachement, $motif, $autreMotif): void
    {
        // Si le motif est "autre", on inclut le détail du motif personnalisé
        $motifMessage = $motif === 'autre' ? 'Motif personnalisé: ' . $autreMotif : $motif;

        Mail::to($rattachement->email)
            ->cc($this->cc)
            ->send(new ProformaExistMail(
                $rattachement->bl,
                $rattachement->nom,
                $rattachement->prenom,
                $motifMessage,  // Envoie le motif
                $autreMotif     // Le motif détaillé si nécessaire
            ));
    }
}
