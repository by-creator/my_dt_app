<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\FactureDocumentsMail;
use App\Mail\FactureExistMail;
use App\Mail\FactureRelanceMail;
use App\Mail\FactureValidateMail;
use App\Mail\ProformaGenerateMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationFacture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Throwable;


class DossierFacturationFactureController extends Controller
{
    public function facture()
    {
        $dossiers = DossierFacturation::whereIn(
            'statut',
            [
                StatutDossier::EN_ATTENTE_FACTURE,
                StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE,
            ]
        )
            ->orderBy('id', 'desc')
            ->get();
        $users = User::all();
        $user = Auth::user();
        return view('dossier_facturation.facture', compact('dossiers', 'users', 'user'));
    }

    public function list()
    {
        // Charger les dossiers et leurs factures associés
        $dossiers = DossierFacturation::with('factures')->orderBy('id', 'desc')->get();
        $user = Auth::user();

        // Passer la collection de dossiers à la vue
        return view('dossier_facturation.list_facture', compact('dossiers', 'user'));
    }

    public function complement(Request $request, $id)
    {
        $request->validate([
            'documentDate' => 'required|date',
        ]);

        $dossier = DossierFacturation::findOrFail($id);

        if (
            $dossier->statut === StatutDossier::FACTURE_VALIDE ||
            $dossier->statut === StatutDossier::EN_ATTENTE_BAD ||
            $dossier->statut === StatutDossier::BAD_VALIDE ||
            $dossier->statut === StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE
        ) {
            // Exemple : générer le document avec la date choisie
            $date = Carbon::parse($request->input('documentDate'));


            // On récupère le rattachement BL
            $rattachement = $dossier->rattachement_bl;

            // On prépare les données à envoyer dans le mail
            $data = [
                'date' => $date,
                'prenom'  => $rattachement->prenom,
                'nom'     => $rattachement->nom,
                'email'   => $rattachement->email,
                'bl'      => $rattachement->bl,
                'compte'  => $rattachement->compte,
            ];

            // Liste des destinataires
            $destinataires = [
                'sn004-proforma@dakar-terminal.com',
                'sn004-facturation@dakar-terminal.com',
                //'noreplysitedt@gmail.com'
            ];

            // Envoi du mail
            Mail::to($destinataires)->send(new ProformaGenerateMail($data));


            Log::info('Demande de facture proforma complémentaire envoyée');

            $dossier->date_proforma = $date;

            $dossier->statut = StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE;

            $dossier->date_en_attente_proforma = now();


            // Sauvegarde les changements
            $dossier->save();

            return redirect()->back()->with('success', "Votre proforma complémentaire sera disponible dans 10 minutes ");
        } elseif ($dossier->statut === StatutDossier::VALIDE) {
            return redirect()->back()->with('info', "Votre dossier ne contient pas encore de facture à prolonger");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE) {
            return redirect()->back()->with('info', "Votre proforma complémentaire est en cours de traitement");
        } elseif ($dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {
            return redirect()->back()->with('info', "Votre proforma complémentaire est déjà disponible");
        } else {
            return redirect()->back()->with('info', "Tout est ok !");;
        }
    }


    // -----------------------------
    // Étape 1 : Récupérer le dossier
    // -----------------------------
    private function getDossier($id)
    {
        return DossierFacturation::findOrFail($id);
    }

    // -----------------------------
    // Étape 2 : Récupérer le rattachement
    // -----------------------------
    private function getRattachement(DossierFacturation $dossier)
    {
        $rattachement = $dossier->rattachement_bl;

        if (!$rattachement || !$rattachement->email) {
            abort(400, 'Aucun rattachement BL trouvé pour ce dossier.');
        }

        return $rattachement;
    }

    // -----------------------------
    // Étape 3 : Gestion de l’upload
    // -----------------------------
    private function handleUpload(Request $request, array $fields)
    {
        $request->validate([
            'facture.*' => 'nullable|mimes:pdf|max:2048',
        ]);

        $saveData = [];

        foreach ($fields as $field) {
            $saveData[$field] = [];

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    $path = $file->store("documents/$field", 'b2');

                    if ($path) {
                        $saveData[$field][] = [
                            'original' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }
            }
        }

        return $saveData;
    }

    // -----------------------------
    // Étape 4 : Sauvegarder la facture
    // -----------------------------
    private function saveFacture(DossierFacturation $dossier, array $filesData)
    {
        $facture = new DossierFacturationFacture($filesData);
        $facture->dossier_facturation_id = $dossier->id;
        $facture->save();

        return $facture;
    }

    // -----------------------------
    // Étape 5 : Mettre à jour le dossier
    // -----------------------------
    private function updateDossier(DossierFacturation $dossier)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::FACTURE_VALIDE;

        $facture = DossierFacturationFacture::firstWhere('dossier_facturation_id', $dossier->id);


        if ($dossier->date_en_attente_facture) {
            $seconds =
                Carbon::parse($dossier->date_en_attente_facture)->diffInSeconds(now());

            $dossier->time_elapsed_facture = DossierFacturation::secondsToHms($seconds);
            $dossier->relance_facture = false;

            $facture->user = $dossier->user->name;
            $facture->bl = $dossier->rattachement_bl->bl;
            $facture->statut = $dossier->statut;
            $facture->time_elapsed = $dossier->time_elapsed_facture;
        }

        $dossier->save();
        $facture->save();
    }

    private function updateComplementDossier(DossierFacturation $dossier)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE;

        $facture = DossierFacturationFacture::firstWhere('dossier_facturation_id', $dossier->id);


        if ($dossier->date_en_attente_facture) {
            $seconds =
                Carbon::parse($dossier->date_en_attente_facture)->diffInSeconds(now());

            $dossier->time_elapsed_facture = DossierFacturation::secondsToHms($seconds);
            $dossier->relance_facture = false;

            $facture->user = $dossier->user->name;
            $facture->bl = $dossier->rattachement_bl->bl;
            $facture->statut = $dossier->statut;
            $facture->time_elapsed = $dossier->time_elapsed_facture;
        }


        $dossier->save();
        $facture->save();
    }

    // -----------------------------
    // Étape 6 : Envoyer le mail
    // -----------------------------
    private function sendMailToRattachement($rattachement, DossierFacturationFacture $facture, $documents)
    {
        $data = [
            'email'  => $rattachement->email, // ajouter cette ligne
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $facture->created_at->format('d/m/Y H:i'),
            'documents' => $documents,
        ];

        // Liste des destinataires
        $destinataires = [
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',
            //'noreplysitedt@gmail.com'
        ];

        Mail::to($rattachement->email)
            ->cc($destinataires)
            ->send(new FactureDocumentsMail($data));
    }

    // -----------------------------
    // Étape 7 : Effectuer le post
    // -----------------------------

    public function sendDocuments(Request $request, $id)
    {
        Log::info("Début de l'envoi des documents pour le dossier ID : $id");

        $dossier = $this->getDossier($id);
        Log::info("Dossier récupéré", ['dossier_id' => $dossier->id]);

        $rattachement = $this->getRattachement($dossier);
        Log::info("Rattachement récupéré", [
            'rattachement_id' => $rattachement->id ?? null,
            'email' => $rattachement->email
        ]);

        $filesData = $this->handleUpload($request, ['facture']);
        Log::info("Fichiers uploadés", ['files' => $filesData['facture'] ?? []]);

        $facture = $this->saveFacture($dossier, $filesData);
        Log::info("Facture créée", ['facture_id' => $facture->id]);

        if ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE) {

            $this->updateDossier($dossier, $facture);
            Log::info("Dossier mis à jour", [
                'user_id' => $dossier->user_id,
                'statut' => $dossier->statut,
                'time_elapsed' => $dossier->time_elapsed
            ]);
        } elseif (
            $dossier->statut === StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE ||
            $dossier->statut === StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE
        ) {

            $this->updateComplementDossier($dossier, $facture);
            Log::info("Dossier mis à jour", [
                'user_id' => $dossier->user_id,
                'statut' => $dossier->statut,
                'time_elapsed' => $dossier->time_elapsed
            ]);
        } else {
            return back()->with('infoFacture', 'La facture est déjà disponible');
        }

        $this->sendMailToRattachement($rattachement, $facture, $filesData['facture']);
        Log::info("Mail envoyé au rattachement", ['email' => $rattachement->email]);

        Log::info("Fin de l'envoi des documents pour le dossier ID : $id");

        return back()->with('successFacture', 'Documents envoyés et mail transmis avec succès !');
    }

    public function validate($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::FACTURE_VALIDE || $dossier->statut === StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE) {

            $dossier->statut = StatutDossier::EN_ATTENTE_BAD;
            $dossier->date_en_attente_bon = now();
            $dossier->save();

            // On récupère le rattachement BL
            $rattachement = $dossier->rattachement_bl;

            // On prépare les données à envoyer dans le mail
            $data = [
                'prenom'  => $rattachement->prenom,
                'nom'     => $rattachement->nom,
                'email'   => $rattachement->email,
                'bl'      => $rattachement->bl,
                'compte'  => $rattachement->compte,
            ];


            // Liste des destinataires
            $destinataires = [
                'sn004-proforma@dakar-terminal.com',
                'sn004-facturation@dakar-terminal.com',
                //'noreplysitedt@gmail.com'
            ];

            // Envoi du mail
            Mail::to($destinataires)->send(new FactureValidateMail($data));


            Log::info('Votre facture sera disponible dans 10 minutes');

            return redirect()->back()->with('success', "Votre BAD sera disponible dans 10 minutes ");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_BAD) {
            return redirect()->back()->with('info', "Votre BAD est en cours de traitement");
        } elseif ($dossier->statut === StatutDossier::BAD_VALIDE) {
            return redirect()->back()->with('info', "Votre BAD est déjà disponible");
        } else {
            return redirect()->back()->with('info', "Tout est ok");
        }
    }

    public function rejectDocuments($id, Request $request)
    {
        try {
            Log::info('Début du traitement de rejection du dossier', ['dossier_id' => $id]);

            $dossier = DossierFacturation::findOrFail($id);
            Log::info('Dossier trouvé', ['dossier_id' => $dossier->id, 'statut' => $dossier->statut]);

            $rattachement = $dossier->rattachement_bl;
            Log::info('Rattachement BL récupéré', [
                'prenom' => $rattachement->prenom ?? null,
                'nom' => $rattachement->nom ?? null,
                'email' => $rattachement->email ?? null,
                'bl' => $rattachement->bl ?? null
            ]);

            // Mise à jour du statut
            if ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE || $dossier->statut === StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE) {

                $dossier->statut = StatutDossier::EN_ATTENTE_BAD;
            }
            $dossier->save();
            Log::info('Statut du dossier mis à jour', ['dossier_id' => $dossier->id, 'nouveau_statut' => $dossier->statut]);

            $destinataires = [
                'sn004-proforma@dakar-terminal.com',
                'sn004-facturation@dakar-terminal.com',
                //'noreplysitedt@gmail.com'
            ];
            $motif = $request->motif;
            $autre_motif = $request->autre_motif;
            Log::info('Préparation de l’envoi du mail', ['motif' => $motif, 'destinataires_cc' => $destinataires]);

            Mail::to($rattachement->email)
                ->cc($destinataires)
                ->send(new FactureExistMail(
                    $rattachement->bl,
                    $rattachement->nom,
                    $rattachement->prenom,
                    $motif,
                    $autre_motif
                ));

            Log::info('Mail envoyé avec succès', ['to' => $rattachement->email]);

            return redirect()
                ->back()
                ->with('success', "Votre demande de facture définitive a été rejetée avec succès.");
        } catch (Throwable $e) {

            // Log détaillé de l'erreur
            Log::error('Erreur lors du rejet du dossier proforma', [
                'dossier_id' => $id,
                'email'      => $rattachement->email ?? null,
                'motif'      => $request->motif ?? null,
                'message'    => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', "Une erreur est survenue lors de l’envoi du mail. Veuillez réessayer.");
        }
    }

    public function relanceDocuments($id)
    {
        $dossier = DossierFacturation::findOrFail($id);

        // On récupère le rattachement BL
        $rattachement = $dossier->rattachement_bl;



        // On prépare les données à envoyer dans le mail
        $data = [
            'prenom'  => $rattachement->prenom,
            'nom'     => $rattachement->nom,
            'email'   => $rattachement->email,
            'bl'      => $rattachement->bl,
            'compte'  => $rattachement->compte,
        ];

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE || $dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {

            return redirect()->back()->with('info', "Merci de cliquer sur le bouton 'Valider' au niveau de la proforma avant de vouloir effectuer une relance");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE || $dossier->statut === StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE) {

            if ($dossier->relance_facture == false) {

                $dossier->relance_facture = true;
                $dossier->save();

                // Liste des destinataires
                $destinataires = [
                    'sn004-proforma@dakar-terminal.com',
                    'sn004-facturation@dakar-terminal.com',
                    //'noreplysitedt@gmail.com'
                ];

                // Envoi du mail
                Mail::to($destinataires)->send(new FactureRelanceMail($data));


                Log::info('Votre relance a été effectuée avec succès');


                return redirect()->back()->with('success', "Votre relance a été effectuée avec succès ");
            } else {
                return redirect()->back()->with('info', "Vous avez déjà effectué une relance, votre facture est en cours de traitement");
            }
        } elseif ($dossier->statut === StatutDossier::FACTURE_VALIDE || $dossier->statut === StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE) {
            return redirect()->back()->with('info', "Votre facture définitive est déjà disponible");
        }
    }
}
