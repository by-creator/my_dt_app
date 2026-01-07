<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OperationsImport implements OnEachRow, WithStartRow
{
    public $stats = [];
    
    public function startRow(): int
    {
        return 5; // commence à la 5e ligne 

    }
    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $statut = $row[3] ?? null;
        $typeTc = $row[12] ?? null;
        $sens = $row[13] ?? null;
        if ($statut && $typeTc && $sens) {
            $key = $typeTc . '|' . $sens . '|' . $statut;
            $this->stats[$key] = ($this->stats[$key] ?? 0) + 1;
        }
    }
}
