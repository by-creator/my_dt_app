<?php

namespace App\Exports;

use App\Models\Role;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::join('roles', 'users.role_id', '=', 'roles.id')
                    ->select('roles.name as role', 'users.name', 'users.email')
                    ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Role',
            'Name',
            'Email',
        ];
    }
}