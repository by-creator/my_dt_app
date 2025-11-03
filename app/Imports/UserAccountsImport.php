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
                    'manager' => $row['manager'] ?? null,
                    'office_phone' => $row['office_phone'] ?? null,
                    'license_options' => $row['license_options'] ?? null,
                    'site' => $row['site'] ?? 'Dakar Terminal S.A. - DAKAR',
                    'status' => $row['status'] ?? null,
                    'user_type' => $row['user_type'] ?? null,
                    'user_principal_name' => $row['user_principal_name'] ?? null,
                    'agency' => $row['agency'] ?? 'Dakar Terminal S.A.',
                    'agency_code' => $row['agency_code'] ?? 'SN004',
                    'local_job_title' => $row['local_job_title'] ?? null,
                    'local_department' => $row['local_department'] ?? null,
                    'user_license_type' => $row['user_license_type'] ?? null,
                    'contractor_company' => $row['contractor_company'] ?? null,
                    'contractor_company_email' => $row['contractor_company_email'] ?? null,
                    'created_time' => !empty($row['created_time']) ? Carbon::createFromFormat('d/m/Y H:i', $row['created_time']) : null,
                    'employee_end_date' => !empty($row['employee_end_date']) ? Carbon::createFromFormat('d/m/Y H:i', $row['employee_end_date']) : null,
                    'last_activity_date' => !empty($row['last_activity_date']) ? Carbon::createFromFormat('d/m/Y H:i', $row['last_activity_date']) : null,
                    'final_deprovisioned_date' => !empty($row['final_deprovisioned_date']) ? Carbon::createFromFormat('d/m/Y H:i', $row['final_deprovisioned_date']) : null,
                ]
            );
        }
    }
}
