<?php

namespace App\Services\Proforma;

use App\Models\DossierFacturation;
use App\Models\DossierFacturationProforma;
use App\Enums\StatutDossier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProformaDossierService
{
    public function getDossier(int $id): DossierFacturation
    {
        return DossierFacturation::findOrFail($id);
    }

    public function getRattachement(DossierFacturation $dossier)
    {
        $rattachement = $dossier->rattachement_bl;

        if (!$rattachement || !$rattachement->email) {
            abort(400, 'Aucun rattachement BL trouvé pour ce dossier.');
        }

        return $rattachement;
    }

    public function validate(DossierFacturation $dossier): ?string
    {
        if ($dossier->statut === StatutDossier::PROFORMA_VALIDE) {
            $dossier->update([
                'statut' => StatutDossier::EN_ATTENTE_FACTURE,
                'date_en_attente_facture' => now(),
            ]);

            return null;
        }

        if ($dossier->statut === StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE) {
            $dossier->update([
                'statut' => StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE,
                'date_en_attente_facture' => now(),
            ]);

            return null;
        }

        return match ($dossier->statut) {
            StatutDossier::EN_ATTENTE_FACTURE =>
            "Votre facture définitive est en cours de traitement",

            StatutDossier::FACTURE_VALIDE =>
            "Votre facture définitive est déjà disponible",

            StatutDossier::EN_ATTENTE_FACTURE_COMPLEMENTAIRE =>
            "Votre facture complémentaire est en cours de traitement",

            StatutDossier::FACTURE_COMPLEMENTAIRE_VALIDE =>
            "Votre facture complémentaire est déjà disponible",

            default =>
            "Tout est ok !",
        };
    }


    public function updateDossier(
        DossierFacturation $dossier,
        DossierFacturationProforma $proforma
    ): void {
        $dossier->user_id = Auth::id();

        if ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA) {
            $dossier->statut = StatutDossier::PROFORMA_VALIDE;
        } elseif ($dossier->statut === StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE) {
            $dossier->statut = StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE;
        }

        // Assurer que date_en_attente_proforma est définie
        if (!$dossier->date_en_attente_proforma) {
            $dossier->date_en_attente_proforma = now();
        }

        // Calcul du temps écoulé
        $seconds = Carbon::parse($dossier->date_en_attente_proforma)->diffInSeconds(now());
        $dossier->time_elapsed_proforma = DossierFacturation::secondsToHms($seconds);
        $dossier->relance_proforma = false;

        // ✅ Mise à jour de la proforma
        $proforma->user = Auth::user()->name; // Utiliser directement l'utilisateur connecté
        $proforma->bl = $dossier->rattachement_bl?->bl ?? 'N/A'; // fallback si null
        $proforma->statut = $dossier->statut;
        $proforma->time_elapsed = $dossier->time_elapsed_proforma;

        $dossier->save();
        $proforma->save();

        Log::info('[UPDATE_DOSSIER]', [
            'proforma_id' => $proforma->id,
            'dossier_id' => $dossier->id,
            'user' => $proforma->user,
            'bl' => $proforma->bl,
            'statut' => $proforma->statut,
            'time_elapsed' => $proforma->time_elapsed,
        ]);
    }


    public function reject(DossierFacturation $dossier, $motif, $autreMotif = null): void
    {
        // Assurer que le dossier peut être rejeté
        $dossier->statut = StatutDossier::VALIDE;

        // Ne pas enregistrer le motif dans la base de données
        // Si un autre motif est fourni, on peut l'utiliser pour l'email mais ne pas l'enregistrer
        if ($autreMotif) {
            $motif = $autreMotif;  // On utilise l'autre motif si nécessaire
        }

        // Sauvegarder les modifications du dossier (sans modifier le motif dans la base)
        $dossier->save();
    }

    public function relanceProforma(DossierFacturation $dossier): ?string
    {
        // Cas 1 : aucune proforma générée
        if ($dossier->statut === StatutDossier::VALIDE) {
            return "Merci de cliquer sur le bouton 'Générer votre facture proforma' avant de vouloir effectuer une relance";
        }

        // Cas 2 : en attente de proforma
        if (in_array($dossier->statut, [
            StatutDossier::EN_ATTENTE_PROFORMA,
            StatutDossier::EN_ATTENTE_PROFORMA_COMPLEMENTAIRE
        ])) {
            if ($dossier->relance_proforma) {
                return "Vous avez déjà effectué une relance, votre facture est en cours de traitement";
            }

            // ✅ Relance autorisée
            $dossier->relance_proforma = true;
            $dossier->save();

            return null;
        }

        // Cas 3 : proforma déjà disponible
        if (in_array($dossier->statut, [
            StatutDossier::PROFORMA_VALIDE,
            StatutDossier::PROFORMA_COMPLEMENTAIRE_VALIDE
        ])) {
            return "Votre facture proforma est déjà disponible";
        }

        return "Votre facture proforma est déjà disponible";
    }
}
