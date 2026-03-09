<?php

namespace App\Imports;

use App\Models\Machine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MachinesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Machine::updateOrCreate(
                ['numero_serie' => $row['numero_serie']],
                [
                    'numero_serie' => $row['numero_serie'] ?? null,
                    'modele'       => $row['modele'] ?? null,
                    'type'         => $row['type'] ?? null,
                    'utilisateur'  => $row['utilisateur'] ?? null,
                    'service'      => $row['service'] ?? null,
                    'site'         => $row['site'] ?? null,
                ]
            );
        }
    }
}
