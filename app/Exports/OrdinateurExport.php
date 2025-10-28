<?php

namespace App\Exports;

use App\Models\Ordinateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OrdinateurExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ordinateur::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Numéro de série',
            'Modèle',
            'Type',
            'Utilisateur',
            'Service',
            'Site',
            'Créé à',
            'Mis à jour à',
        ];
    }
}
