<?php

namespace App\Exports;

use App\Models\EmployeeTemporaireDemande;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeTemporaireDemandeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EmployeeTemporaireDemande::join('societe_employee_temporaires', 'demande_employee_temporaires.societe_id', '=', 'societe_employee_temporaires.id')
                    ->join('service_employee_temporaires', 'demande_employee_temporaires.service_id', '=', 'service_employee_temporaires.id')
                    ->select(
                        'demande_employee_temporaires.numero_demande',
                        'societe_employee_temporaires.nom as societe',
                        'service_employee_temporaires.nom as service',
                        'demande_employee_temporaires.fonction',
                        'demande_employee_temporaires.taches',
                        'demande_employee_temporaires.quantite',
                        'demande_employee_temporaires.date_debut',
                        'demande_employee_temporaires.date_fin',
                        'demande_employee_temporaires.statut'
                    )
                    ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Numéro de Demande',
            'Société',
            'Service',
            'Fonction',
            'Tâches',
            'Quantité',
            'Date de Début',
            'Date de Fin',
            'Statut',
        ];
    }
}