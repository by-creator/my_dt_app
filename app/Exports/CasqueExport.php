<?php

namespace App\Exports;

use App\Models\Casque;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CasqueExport implements FromCollection,  WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Casque::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Numero',
            'Prénom',
            'Nom',
            'Déploiement',
            'Créé à',
            'Mis à jour à',
        ];
    }
}
