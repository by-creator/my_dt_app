<?php

namespace App\Exports;

use App\Models\Souris;
use Maatwebsite\Excel\Concerns\FromCollection;

class SourisExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Souris::all();
    }
}
