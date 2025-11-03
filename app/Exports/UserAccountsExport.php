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
                'created_time' => $user->created_time ? $user->created_time->format('d/m/Y H:i') : null,
                'employee_end_date' => $user->employee_end_date ? $user->employee_end_date->format('d/m/Y H:i') : null,
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
        ];
    }
}
