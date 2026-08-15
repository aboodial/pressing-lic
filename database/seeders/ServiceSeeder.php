<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'libelle' => 'Lavage',
                'prix_unitaire' => 2000,
                'description' => 'Lavage standard des vêtements',
                'disponible' => true,
            ],
            [
                'libelle' => 'Repassage',
                'prix_unitaire' => 1000,
                'description' => 'Repassage soigné à la pièce',
                'disponible' => true,
            ],
            [
                'libelle' => 'Nettoyage à sec',
                'prix_unitaire' => 3500,
                'description' => 'Pour tissus délicats (costumes, robes...)',
                'disponible' => true,
            ],
            [
                'libelle' => 'Lavage + Repassage',
                'prix_unitaire' => 2800,
                'description' => 'Formule complète lavage et repassage',
                'disponible' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['libelle' => $service['libelle']],
                $service
            );
        }
    }
}
