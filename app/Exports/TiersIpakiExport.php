<?php

namespace App\Exports;

use App\Models\TiersIpaki;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TiersIpakiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return TiersIpaki::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'code',
            'label',
            'active',
            'billable',
            'accounting_id',
            'Créé à',
            'Mis à jour à',
        ];
    }
}
