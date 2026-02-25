<?php
namespace App\Http\Controllers;

use App\Http\Requests\DematValidationRequest;
use App\Enums\StatutDossier;
use App\Services\Demat\{
    DematService,
    DematMailerService
};
use Illuminate\Support\Facades\Log;

class DematController extends Controller
{
    public function __construct(
        private DematService $service,
        private DematMailerService $mailer
    ) {}

    public function index()
    {
        return redirect()->route('login');
    }

    public function validation(DematValidationRequest $request)
    {
        try {
            $data = $request->validated();

            // Vérifications BL
            if ($this->service->blEnAttente($data['bl'])) {
                return back()->with(
                    'info',
                    'Ce BL est en cours de validation. Merci de patienter le mail de réponse de la facturation'
                );
            }

            if ($this->service->blValide($data['bl'])) {
                return back()->with(
                    'info',
                    'Ce BL est déjà validé !'
                );
            }

            // Gestion des fichiers (toujours tableau)
            $files = $request->file('documents');
            if ($files instanceof \Illuminate\Http\UploadedFile) {
                $files = [$files];
            }

            // Envoi mail
            $this->mailer->send($data, $files);

            Log::info('Demande de validation envoyée', [
                'email' => $data['email'],
                'bl' => $data['bl']
            ]);

            // Création rattachement BL
            $this->service->createRattachement([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'bl' => $data['bl'],
                'compte' => $data['compte'],
            ]);

            return back()->with(
                'success',
                'Votre dossier sera disponible dans 10 minutes.'
            );
        } catch (\Throwable $e) {
            Log::error('Erreur mail validation DEMAT', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()->with(
                'error',
                'Une erreur est survenue lors de l’envoi.'
            );
        }
    }

    public function remise(DematValidationRequest $request)
    {
        try {
            $data = $request->validated();

            // Vérifications BL
            if ($this->service->RemiseEnAttente($data['bl'])) {
                return back()->with(
                    'info',
                    'Ce dossier est en cours de validation. Merci de patienter le mail de réponse de la facturation'
                );
            }

            if ($this->service->RemiseValide($data['bl'])) {
                return back()->with(
                    'info',
                    'Ce dossier est déjà validé !'
                );
            }


            // Gestion des fichiers (toujours tableau)
            $files = $request->file('documents');
            if ($files instanceof \Illuminate\Http\UploadedFile) {
                $files = [$files];
            }

            // Envoi mail
            $this->mailer->sendRemise($data, $files);

            Log::info('Demande de remise envoyée', [
                'email' => $data['email'],
                'bl' => $data['bl']
            ]);

            // Création rattachement BL
            $this->service->createRattachement([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'bl' => $data['bl'],
                'compte' => $data['compte'],
                'statut' => StatutDossier::REMISE_EN_ATTENTE_VALIDATION_FACTURATION,
            ]);

            return back()->with(
                'success',
                'Votre demande de remise a été envoyée avec succès.'
            );
        } catch (\Throwable $e) {
            Log::error('Erreur mail remise DEMAT', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()->with(
                'error',
                'Une erreur est survenue lors de l’envoi de la demande de remise.'
            );
        }
        }
}
