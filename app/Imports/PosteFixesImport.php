<?php

namespace App\Imports;

use App\Models\PosteFixe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PosteFixesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            PosteFixe::updateOrCreate(
                ['annuaire' => $row['annuaire']],
                [
                    'annuaire' => $row['annuaire'] ?? null,
                    'nom'      => $row['nom'] ?? null,
                    'prenom'   => $row['prenom'] ?? null,
                    'type'     => $row['type'] ?? null,
                    'entite'   => $row['entite'] ?? null,
                    'role'     => $row['role'] ?? null,
                ]
            );
        }
    }
}
