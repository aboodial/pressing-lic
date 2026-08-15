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
            ['name' => 'Mamadou Diop', 'email' => 'mamadou.diop@gmail.com'],
            ['name' => 'Khaly Diouf', 'email' => 'khaly.diouf@gmail.com'],
            ['name' => 'Jaj', 'email' => 'jean.alioune@gmail.com'],
            ['name' => 'Fatou Gaye', 'email' => 'fatou.gaye@gmail.com'],
            ['name' => 'Mouhamed Diop', 'email' => 'mouhamed.diop@gmail.com'],
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
