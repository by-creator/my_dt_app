<?php

namespace App\Exports;

use App\Models\Ecran;
use Maatwebsite\Excel\Concerns\FromCollection;

class EcranExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ecran::all();
    }
}
