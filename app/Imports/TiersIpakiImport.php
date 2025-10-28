<?php

namespace App\Imports;

use App\Models\TiersIpaki;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class TiersIpakiImport implements ToModel, WithHeadingRow

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new TiersIpaki([
            'code' => $row['code'],
            'label' => $row['label'],
            'active' => $row['active'],
            'billable' => $row['billable'],
            'accounting_id' => $row['accounting_id'],
        ]);
    }
}
