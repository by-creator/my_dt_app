<?php

namespace App\Imports;

use App\Models\Ecran;
use Maatwebsite\Excel\Concerns\ToModel;

class EcranImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Ecran([
            //
        ]);
    }
}
