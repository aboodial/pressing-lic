<?php

namespace Database\Seeders;

use App\Models\Paiement;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::where('role', 'client')->get();
        $services = Service::all();

        if ($clients->isEmpty() || $services->isEmpty()) {
            $this->command->warn('Aucun client ou service trouvé. Lance UserSeeder et ServiceSeeder avant.');
            return;
        }

        // On génère des tickets sur les 6 derniers mois
        for ($moisAvant = 5; $moisAvant >= 0; $moisAvant--) {
            $nombreTicketsCeMois = rand(3, 8);

            for ($i = 0; $i < $nombreTicketsCeMois; $i++) {
                $client = $clients->random();
                $dateCreation = Carbon::now()->subMonths($moisAvant)->subDays(rand(0, 27));

                // Statut aléatoire, plus de "récupéré" pour les mois anciens (logique)
                $statut = $moisAvant > 0
                    ? collect(['recupere', 'recupere', 'recupere', 'pret'])->random()
                    : collect(['recu', 'en_traitement', 'pret', 'recupere'])->random();

                $ticket = new Ticket([
                    'user_id' => $client->id,
                    'statut' => $statut,
                ]);
                $ticket->timestamps = false;
                $ticket->created_at = $dateCreation;
                $ticket->updated_at = $dateCreation->copy()->addHours(rand(1, 48));
                $ticket->save();

                // 1 à 3 lignes de services par ticket
                $nombreLignes = rand(1, 3);
                $servicesChoisis = $services->random(min($nombreLignes, $services->count()));
                if (!$servicesChoisis instanceof \Illuminate\Support\Collection) {
                    $servicesChoisis = collect([$servicesChoisis]);
                }

                $montantTotal = 0;
                foreach ($servicesChoisis as $service) {
                    $quantite = rand(1, 4);
                    $ticket->lignes()->create([
                        'service_id' => $service->id,
                        'quantite' => $quantite,
                        'prix_unitaire' => $service->prix_unitaire,
                    ]);
                    $montantTotal += $quantite * $service->prix_unitaire;
                }

                // Paiement si le ticket est "pret" ou "recupere"
                if (in_array($statut, ['pret', 'recupere'])) {
                    $paiement = new Paiement([
                        'ticket_id' => $ticket->id,
                        'montant' => $montantTotal,
                        'date_paiement' => $ticket->updated_at,
                        'mode' => 'especes',
                    ]);
                    $paiement->timestamps = false;
                    $paiement->created_at = $ticket->updated_at;
                    $paiement->updated_at = $ticket->updated_at;
                    $paiement->save();
                }
            }
        }

        $this->command->info('Tickets de test créés avec succès.');
    }
}
