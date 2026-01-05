<?php

namespace App\Services\Dossier;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementService
{
    public function update(User $user, array $data): void
    {
        $user->role_id = $data['role_id'];
        $user->name = $data['name'];
        $user->telephone = $data['telephone'] ?? null;
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
