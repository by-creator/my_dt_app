<?php

namespace App\Imports;

use App\Models\Imprimante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImprimanteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Imprimante([
            'name' => $row['name'],
            'location' => $row['location'],
            'model' => $row['model'],
            'type' => $row['type'],
            'btl_vlan' => $row['btl_vlan'],
            'ajow_vlan' => $row['ajow_vlan'],
            'gateway' => $row['gateway'],
        ]);
    }
}
