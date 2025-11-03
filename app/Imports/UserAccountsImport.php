<?php

namespace App\Imports;

use App\Models\UserAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class UserAccountsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            UserAccount::updateOrCreate(
                ['email' => $row['email']],
                [
                    'department' => $row['department'] ?? null,
                    'display_name' => $row['display_name'] ?? null,
                    'email' => $row['email'] ?? null,
                    'job_title' => $row['job_title'] ?? null,
                    'created_time' => !empty($row['created_time']) ? Carbon::createFromFormat('d/m/Y H:i', $row['created_time']) : null,
                    'employee_end_date' => !empty($row['employee_end_date']) ? Carbon::createFromFormat('d/m/Y H:i', $row['employee_end_date']) : null,
                ]
            );
        }
    }
}
