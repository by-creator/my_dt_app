<?php

namespace App\Imports;

use App\Models\Casque;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class CasqueImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    
    public function model(array $row)
    {
        $excelDate = $row['deploiement']; 

        if (is_numeric($excelDate)) {
            $date = Date::excelToDateTimeObject($excelDate)->format('Y-m-d'); 
        } else {
            
            $date = \Carbon\Carbon::parse($excelDate)->format('Y-m-d');
        }
        
        return new Casque([
            'numero' => $row['numero'],
            'prenom' => $row['prenom'],
            'nom' => $row['nom'],
            'deploiement' => $date,
        ]);
    }

    
}
