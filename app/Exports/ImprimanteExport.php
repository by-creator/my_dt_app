<?php

namespace App\Exports;

use App\Models\Imprimante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImprimanteExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Imprimante::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Location',
            'Model',
            'Type',
            'Btl Vlan',
            'Ajow Vlan',
            'Gateway',
            'Créé à',
            'Mis à jour à',
        ];
    }
}
