<?php

namespace App\Exports;

use App\Models\TelephoneFixe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelephoneFixesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return TelephoneFixe::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Annuaire',
            'Nom',
            'Prénom',
            'Type',
            'Entité',
            'Rôle',
            'Créé à',
            'Mis à jour à',
        ];
    }
}