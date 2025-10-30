<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un rôle admin et un utilisateur ayant ce rôle si les tables sont vides';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Vérifier si la table roles est vide
        if (Role::count() == 0) {
            $role_admin = Role::create(['name' => 'ADMIN']);
            $this->info('Rôles créés avec succès.');
        } else {
            $role = Role::where('name', 'ADMIN')->first();
        }

        // Vérifier si la table users est vide
        if (User::count() == 0) {
            User::create([
                'role_id' => $role_admin->id,
                'name' => 'BONGO-YEBA Marc',
                'email' => 'marc.bongoyeba@dakar-terminal.com',
                'email_verified_at' => now(),
                'password' => Hash::make('passer1234'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
            ]);
            
            $this->info('Utilisateur(s) créés avec succès.');
        } else {
            $this->info('La table users n\'est pas vide. Aucun utilisateur admin n\'a été créé.');
        }

        return 0;
    }
}
