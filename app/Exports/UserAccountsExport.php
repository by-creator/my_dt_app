<?php

namespace App\Exports;

use App\Models\UserAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserAccountsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return UserAccount::all()->map(function ($user) {
            return [
                'department' => $user->department,
                'display_name' => $user->display_name,
                'email' => $user->email,
                'job_title' => $user->job_title,
                'manager' => $user->manager,
                'office_phone' => $user->office_phone,
                'license_options' => $user->license_options,
                'site' => $user->site,
                'status' => $user->status,
                'user_type' => $user->user_type,
                'user_principal_name' => $user->user_principal_name,
                'agency' => $user->agency,
                'agency_code' => $user->agency_code,
                'local_job_title' => $user->local_job_title,
                'local_department' => $user->local_department,
                'user_license_type' => $user->user_license_type,
                'contractor_company' => $user->contractor_company,
                'contractor_company_email' => $user->contractor_company_email,
                'created_time' => $user->created_time ? $user->created_time->format('d/m/Y H:i') : null,
                'employee_end_date' => $user->employee_end_date ? $user->employee_end_date->format('d/m/Y H:i') : null,
                'last_activity_date' => $user->last_activity_date ? $user->last_activity_date->format('d/m/Y H:i') : null,
                'final_deprovisioned_date' => $user->final_deprovisioned_date ? $user->final_deprovisioned_date->format('d/m/Y H:i') : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'created_time',
            'department',
            'display_name',
            'email',
            'employee_end_date',
            'job_title',
            'manager',
            'office_phone',
            'license_options',
            'site',
            'status',
            'user_type',
            'user_principal_name',
            'agency',
            'agency_code',
            'last_activity_date',
            'local_job_title',
            'local_department',
            'user_license_type',
            'final_deprovisioned_date',
            'contractor_company',
            'contractor_company_email',
        ];
    }
}
