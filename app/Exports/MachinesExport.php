<?php

namespace App\Exports;

use App\Models\Machine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MachinesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Machine::all()->map(function ($machine) {
            return [
                'numero_serie' => $machine->numero_serie,
                'modele'       => $machine->modele,
                'type'         => $machine->type,
                'utilisateur'  => $machine->utilisateur,
                'service'      => $machine->service,
                'site'         => $machine->site,
            ];
        });
    }

    public function headings(): array
    {
        return ['numero_serie', 'modele', 'type', 'utilisateur', 'service', 'site'];
    }
}
