<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'role' => $row['role'],
            'name' => $row['name'],
            'email' => $row['email'],
            'username' => $row['username'],
            'password' => bcrypt('defaultpassword'), // Vous pouvez définir un mot de passe par défaut ou gérer cela autrement
        ]);
    }
}