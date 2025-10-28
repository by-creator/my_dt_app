<?php

namespace App\Imports;

use App\Models\TelephoneFixe;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TelephoneFixesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new TelephoneFixe([
            'annuaire' => $row['annuaire'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'type' => $row['type'],
            'entite' => $row['entite'],
            'role' => $row['role'],
        ]);
    }
}
