<?php

namespace App\Exports;

use App\Models\Ecran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class EcranExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ecran::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Date réception',
            'Date déploiement',
            'Service Tag',
            'Étiquetage',
            'Service',
            'Utilisateur',
            'Créé à',
            'Mis à jour à',
        ];
    }
}
