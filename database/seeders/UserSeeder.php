<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gestionnaires
        User::create([
            'name' => 'Serigne Diallo',
            'email' => 'serignediallo@groupeisi.com',
            'password' => Hash::make('Ser2012?'),
            'role' => 'gestionnaire',
        ]);

        User::create([
            'name' => 'Gestionnaire LIC',
            'email' => 'gestionnaire@lic.sn',
            'password' => Hash::make('gestion123'),
            'role' => 'gestionnaire',
        ]);

        // Clients
        $clients = [
            ['name' => 'Ngone Ka', 'email' => 'ngone.ka@test.com'],
            ['name' => 'Alioune Dia', 'email' => 'alioune.dia@test.com'],
            ['name' => 'Kine Yama Diop', 'email' => 'kine.diop@test.com'],
            ['name' => 'Khady Ndao', 'email' => 'khady.ndao@test.com'],
            ['name' => 'Moussa Fall', 'email' => 'moussa.fall@test.com'],
        ];

        foreach ($clients as $client) {
            User::create([
                'name' => $client['name'],
                'email' => $client['email'],
                'password' => Hash::make('client123'),
                'role' => 'client',
            ]);
        }
    }
}
