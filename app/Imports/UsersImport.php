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
            'name' => $row['name'],
            'email' => $row['email'],
            'telephone' => $row['telephone'],
            'password' => bcrypt('defaultpassword'), // Vous pouvez définir un mot de passe par défaut ou gérer cela autrement
        ]);
    }

    /**
     * Taille des lots d'insertion en base
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Taille des morceaux lus en mémoire
     */
    public function chunkSize(): int
    {
        return 100;
    }
}
