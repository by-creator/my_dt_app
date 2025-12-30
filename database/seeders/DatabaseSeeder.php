<?php

namespace Database\Seeders;

use App\Models\Guichet;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        Service::insert([
            ['nom' => 'Validation'],
            ['nom' => 'Facturation'],
            ['nom' => 'Caisse'],
            ['nom' => 'Bad'],
        ]);

        Guichet::insert([
            ['nom' => '1', 'service_id' => 2],
            ['nom' => '2', 'service_id' => 4],
            ['nom' => '3', 'service_id' => 2],
            ['nom' => '4', 'service_id' => 2],
            ['nom' => '5', 'service_id' => 2],
            ['nom' => '6', 'service_id' => 2],
            ['nom' => '7', 'service_id' => 1],
            ['nom' => '8', 'service_id' => 1],
            ['nom' => '9', 'service_id' => 1],
            ['nom' => '10', 'service_id' => 4],
            ['nom' => '11', 'service_id' => 3],
            ['nom' => '12', 'service_id' => 3],
            ['nom' => '13', 'service_id' => 3],
        ]);
    }
}
