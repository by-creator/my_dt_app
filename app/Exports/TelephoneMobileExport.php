<?php

namespace App\Exports;

use App\Models\TelephoneMobile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelephoneMobileExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TelephoneMobile::select([
            'matricule',
            'nom',
            'prenom',
            'service',
            'destination',
            'modele_telephone',
            'reference_telephone',
            'montant_ancien_forfait_ttc',
            'numero_sim',
            'formule_premium',
            'montant_forfait_ttc',
            'code_puk',
            'acquisition_date',
            'statut',
            'cause_changement',
            'imsi',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Nom',
            'Prénom',
            'Service',
            'Destination',
            'Modèle téléphone',
            'Référence téléphone',
            'Ancien forfait TTC',
            'Numéro SIM',
            'Formule premium',
            'Forfait TTC',
            'Code PUK',
            'Date acquisition',
            'Statut',
            'Cause changement',
            'IMSI',
        ];
    }
}
