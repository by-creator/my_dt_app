<?php

namespace App\Imports;

use App\Models\Ordinateur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class OrdinateurImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Ordinateur([
            'serie' => $row['serie'],
            'model' => $row['model'],
            'type' => $row['type'],
            'utilisateur' => $row['utilisateur'],
            'service' => $row['service'],
            'site' => $row['site'],
        ]);
    }
}
