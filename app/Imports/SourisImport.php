<?php

namespace App\Imports;

use App\Models\Souris;
use Maatwebsite\Excel\Concerns\ToModel;

class SourisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Souris([
            //
        ]);
    }
}
