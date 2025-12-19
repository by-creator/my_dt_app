<?php

namespace App\Http\Controllers;

use App\Enums\StatutDossier;
use App\Mail\ProformaDocumentsMail;
use App\Mail\ProformaExistMail;
use App\Mail\ProformaGenerateMail;
use App\Mail\ProformaRelanceMail;
use App\Mail\ProformaValidateMail;
use App\Models\DossierFacturation;
use App\Models\DossierFacturationProforma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;



class DossierFacturationProformaController extends Controller
{
    public function proforma()
    {
        $dossiers = DossierFacturation::whereIn(
            'statut',
            [
                StatutDossier::EN_ATTENTE_PROFORMA,
                StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE,
            ]
        )
            ->orderBy('id', 'desc')
            ->get();
        $users = User::all();
        return view('dossier_facturation.proforma', compact('dossiers', 'users'));
    }

    public function list()
    {
        // Charger les dossiers et leurs proformas associés
        $dossiers = DossierFacturation::with('proformas')->orderBy('id', 'desc')->get();

        // Passer la collection de dossiers à la vue
        return view('dossier_facturation.list_proforma', compact('dossiers'));
    }


    public function generate(Request $request, $id)
    {
        $request->validate([
            'documentDate' => 'required|date',
        ]);

        $dossier = DossierFacturation::findOrFail($id);

        if ($dossier->statut === StatutDossier::VALIDE) {
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


            Log::info('Demande de facture proforma envoyée');

            $dossier->date_proforma = $date;

            $dossier->statut = StatutDossier::EN_ATTENTE_PROFORMA;

            $dossier->date_en_attente_proforma = now();

            // Sauvegarde les changements
            $dossier->save();

            return redirect()->back()->with('success', "Votre facture proforma sera disponible dans 10 minutes ");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA) {
            return redirect()->back()->with('info', "Votre facture proforma est en cours de traitement");
        } elseif ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {
            return redirect()->back()->with('info', "Votre facture proforma est déjà disponible");
        } else {
            return redirect()->back()->with('info', "Tout est ok !");
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
            'proforma.*' => 'nullable|mimes:pdf|max:2048',
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
    // Étape 4 : Sauvegarder la proforma
    // -----------------------------
    private function saveProforma(DossierFacturation $dossier, array $filesData)
    {
        $proforma = new DossierFacturationProforma($filesData);
        $proforma->dossier_facturation_id = $dossier->id;
        $proforma->save();

        return $proforma;
    }

    // -----------------------------
    // Étape 5 : Mettre à jour le dossier
    // -----------------------------
    private function updateDossier(DossierFacturation $dossier, DossierFacturationProforma $proforma)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::PROFORMA_VALIDE;
        $proforma = DossierFacturationProforma::firstWhere('dossier_facturation_id', $dossier->id);


        if ($dossier->date_en_attente_proforma) {
            $seconds =
                Carbon::parse($dossier->date_en_attente_proforma)->diffInSeconds(now());

            $dossier->time_elapsed_proforma = DossierFacturation::secondsToHms($seconds);
            $dossier->relance_proforma = false;

            $proforma->user = $dossier->user->name;
            $proforma->bl = $dossier->rattachement_bl->bl;
            $proforma->statut = $dossier->statut;
            $proforma->time_elapsed = $dossier->time_elapsed_proforma;
        }
        $dossier->save();
        $proforma->save();
    }

    private function updateComplementDossier(DossierFacturation $dossier)
    {
        $dossier->user_id = Auth::id();
        $dossier->statut = StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE;
        $proforma = DossierFacturationProforma::firstWhere('dossier_facturation_id', $dossier->id);


        if ($dossier->date_en_attente_proforma) {
            $seconds =
                Carbon::parse($dossier->date_en_attente_proforma)->diffInSeconds(now());

            $dossier->time_elapsed_proforma = DossierFacturation::secondsToHms($seconds);
            $dossier->relance_proforma = false;

            $proforma->user = $dossier->user->name;
            $proforma->bl = $dossier->rattachement_bl->bl;
            $proforma->statut = $dossier->statut;
            $proforma->time_elapsed = $dossier->time_elapsed_proforma;
        }
        $dossier->save();
        $proforma->save();
    }

    // -----------------------------
    // Étape 6 : Envoyer le mail
    // -----------------------------
    private function sendMailToRattachement($rattachement, DossierFacturationProforma $proforma, $documents)
    {
        $data = [
            'email'  => $rattachement->email, // ajouter cette ligne
            'prenom' => $rattachement->prenom,
            'nom'    => $rattachement->nom,
            'bl'     => $rattachement->bl,
            'date'   => $proforma->created_at->format('d/m/Y H:i'),
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
            ->send(new ProformaDocumentsMail($data));
    }


    // -----------------------------
    // Étape 7 : Effectuer le post
    // -----------------------------

    public function sendDocuments(Request $request, $id)
    {
        Log::info("Début de l'envoi des documents pour le dossier ID : $id");

        $dossier = $this->getDossier($id);
        Log::info("Dossier récupéré", ['dossier_id' => $dossier->id]);

        if ($dossier->date_proforma != NULL) {
            $rattachement = $this->getRattachement($dossier);
            Log::info("Rattachement récupéré", [
                'rattachement_id' => $rattachement->id ?? null,
                'email' => $rattachement->email
            ]);

            $filesData = $this->handleUpload($request, ['proforma']);
            Log::info("Fichiers uploadés", ['files' => $filesData['proforma'] ?? []]);

            $proforma = $this->saveProforma($dossier, $filesData);
            Log::info("Proforma créée", ['proforma_id' => $proforma->id]);

            if ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA) {
                $this->updateDossier($dossier, $proforma);
                Log::info("Dossier mis à jour", [
                    'user_id' => $dossier->user_id,
                    'statut' => $dossier->statut,
                    'time_elapsed' => $dossier->time_elapsed
                ]);
            } elseif (
                $dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE ||
                $dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE
            ) {
                $this->updateComplementDossier($dossier, $proforma);
                Log::info("Dossier mis à jour", [
                    'user_id' => $dossier->user_id,
                    'statut' => $dossier->statut,
                    'time_elapsed' => $dossier->time_elapsed
                ]);
            }


            $this->sendMailToRattachement($rattachement, $proforma, $filesData['proforma']);
            Log::info("Mail envoyé au rattachement", ['email' => $rattachement->email]);

            Log::info("Fin de l'envoi des documents pour le dossier ID : $id");

            return back()->with('successProforma', 'Documents envoyés et mail transmis avec succès !');
        } else {
            return back()->with('infoProforma', 'Le client doit soit au préalable saisir une date ou soit la proforma est déjà disponible');
        }
    }

    public function validate($id)
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

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {

            $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE;
            $dossier->date_en_attente_facture = now();
            $dossier->save();
        } elseif (
            $dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE ||
            $dossier->statut === StatutDossier::PROFORMA_VALIDE
        ) {

            $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE;
            $dossier->date_en_attente_facture = now();
            $dossier->save();
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE) {
            return redirect()->back()->with('info', "Votre facture définitive est en cours de traitement");
        } elseif ($dossier->statut === StatutDossier::FACTURE_VALIDE) {
            return redirect()->back()->with('info', "Votre facture définitive est déjà disponible");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE) {
            return redirect()->back()->with('info', "Votre facture complémentaire est en cours de traitement");
        } elseif ($dossier->statut === StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE) {
            return redirect()->back()->with('info', "Votre facture complémentaire est déjà disponible");
        } else {
            return redirect()->back()->with('info', "Tout est ok !");
        }

        // Liste des destinataires
        $destinataires = [
            'sn004-proforma@dakar-terminal.com',
            'sn004-facturation@dakar-terminal.com',
            //'noreplysitedt@gmail.com'
        ];

        // Envoi du mail
        Mail::to($destinataires)->send(new ProformaValidateMail($data));


        Log::info('Votre facture sera disponible dans 10 minutes');


        return redirect()->back()->with('success', "Votre facture définitive sera disponible dans 10 minutes ");
    }

    public function delete($id)
    {
        $dossier = DossierFacturation::findOrFail($id);
        $proforma = DossierFacturationProforma::firstWhere('dossier_facturation_id', $dossier->id);

        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {

            $proforma->delete();
            $dossier->statut = StatutDossier::VALIDE;
            $dossier->date_proforma = NULL;
        } elseif ($dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {

            $proforma->delete();
            $dossier->statut = StatutDossier::FACTURE_VALIDE;
        } else {
            return redirect()->back()->with('info', "Votre facture proforma est soit en cours de traitement ou soit déjà disponible");
        }

        $dossier->save();

        Log::info('Facture proforma supprimée');


        return redirect()->back()->with('success', "Votre facture a bien été supprimée ");
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
            if ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA) {
                $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE;
            } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE) {
                $dossier->statut = StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE;
            }
            $dossier->save();
            Log::info('Statut du dossier mis à jour', ['dossier_id' => $dossier->id, 'nouveau_statut' => $dossier->statut]);

            $destinataires = [
                'sn004-proforma@dakar-terminal.com',
                'sn004-facturation@dakar-terminal.com',
                //'noreplysitedt@gmail.com'
            ];
            $motif = $request->motif;
            Log::info('Préparation de l’envoi du mail', ['motif' => $motif, 'destinataires_cc' => $destinataires]);

            Mail::to($rattachement->email)
                ->cc($destinataires)
                ->send(new ProformaExistMail(
                    $rattachement->bl,
                    $rattachement->nom,
                    $rattachement->prenom,
                    $motif
                ));

            Log::info('Mail envoyé avec succès', ['to' => $rattachement->email]);

            return redirect()
                ->back()
                ->with('success', "Votre demande de facture proforma a été rejetée avec succès.");
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

        if ($dossier->statut === StatutDossier::VALIDE) {

            return redirect()->back()->with('info', "Merci de cliquer sur le bouton 'Générer votre facture proforma' avant de vouloir effectuer une relance");
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA || $dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE) {

            if ($dossier->relance_proforma == false) {

                $dossier->relance_proforma = true;
                $dossier->save();

                // Liste des destinataires
                $destinataires = [
                    'sn004-proforma@dakar-terminal.com',
                    'sn004-facturation@dakar-terminal.com',
                    //'noreplysitedt@gmail.com'
                ];

                // Envoi du mail
                Mail::to($destinataires)->send(new ProformaRelanceMail($data));


                Log::info('Votre relance a été effectuée avec succès');


                return redirect()->back()->with('success', "Votre relance a été effectuée avec succès ");
            } else {
                return redirect()->back()->with('info', "Vous avez déjà effectué une relance, votre facture est en cours de traitement");
            }
        } elseif ($dossier->statut === StatutDossier::PROFORMA_VALIDE || $dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {
            return redirect()->back()->with('info', "Votre facture proforma est déjà disponible");
        } else {
            return redirect()->back()->with('info', "Votre facture proforma est déjà disponible");
        }
    }
}
