<?php

namespace App\Console\Commands;

use App\Enums\StatutDossier;
use App\Mail\RattachementBlRappelMail;
use Illuminate\Console\Command;
use App\Models\RattachementBl;
use Illuminate\Support\Facades\Mail;

class SendRappelRattachementBl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappel:rattachement-bl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un rappel si des dossiers sont toujours EN ATTENTE DE VALIDATION';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // On récupère les dossiers en attente
        $dossiersEnAttente = RattachementBl::where('statut', StatutDossier::EN_ATTENTE_VALIDATION)->get();

        if ($dossiersEnAttente->isEmpty()) {
            $this->info('Aucun dossier en attente.');
            return 0;
        }

        // Compter le nombre total
        $count = $dossiersEnAttente->count();

        // Définir le ou les destinataires du mail
        $destinataires = [
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',
            // 'noreplysitedt@gmail.com'
        ]; 

        foreach ($destinataires as $email) {
            Mail::to($email)->send(new RattachementBlRappelMail($count, $dossiersEnAttente));
        }

        $this->info("Rappel envoyé à " . implode(', ', $destinataires));
        return 0;
    }
    
}
