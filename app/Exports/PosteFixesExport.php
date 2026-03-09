<?php

namespace App\Exports;

use App\Models\PosteFixe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosteFixesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PosteFixe::all()->map(function ($poste) {
            return [
                'annuaire' => $poste->annuaire,
                'nom'      => $poste->nom,
                'prenom'   => $poste->prenom,
                'type'     => $poste->type,
                'entite'   => $poste->entite,
                'role'     => $poste->role,
            ];
        });
    }

    public function headings(): array
    {
        return ['annuaire', 'nom', 'prenom', 'type', 'entite', 'role'];
    }
}
