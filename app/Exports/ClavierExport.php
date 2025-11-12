<?php

namespace App\Exports;

use App\Models\Clavier;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClavierExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Clavier::all();
    }
}
