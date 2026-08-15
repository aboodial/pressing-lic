<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    /**
     * Statistiques du jour (tableau de bord).
     */
    public function resume(): JsonResponse
    {
        $aujourdhui = now()->toDateString();

        $ticketsAujourdhui = Ticket::whereDate('created_at', $aujourdhui)->count();

        $ticketsRecuperesAujourdhui = Ticket::where('statut', 'recupere')
            ->whereDate('updated_at', $aujourdhui)
            ->count();

        $recetteAujourdhui = Paiement::whereDate('date_paiement', $aujourdhui)->sum('montant');

        return response()->json([
            'tickets_aujourdhui' => $ticketsAujourdhui,
            'tickets_recuperes_aujourdhui' => $ticketsRecuperesAujourdhui,
            'recette_aujourdhui' => (float) $recetteAujourdhui,
        ]);
    }

    /**
     * Nombre de tickets par mois (12 derniers mois).
     */
    public function ticketsParMois(): JsonResponse
    {
        $resultats = Ticket::select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as mois"),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        return response()->json($resultats);
    }

    /**
     * Chiffre d'affaires par service, par mois.
     */
    public function caParService(): JsonResponse
    {
        $resultats = DB::table('ticket_lignes')
            ->join('services', 'services.id', '=', 'ticket_lignes.service_id')
            ->join('tickets', 'tickets.id', '=', 'ticket_lignes.ticket_id')
            ->select(
                'services.libelle',
                DB::raw("TO_CHAR(tickets.created_at, 'YYYY-MM') as mois"),
                DB::raw('SUM(ticket_lignes.quantite * ticket_lignes.prix_unitaire) as chiffre_affaires')
            )
            ->where('tickets.created_at', '>=', now()->subMonths(12))
            ->groupBy('services.libelle', 'mois')
            ->orderBy('mois')
            ->get();

        return response()->json($resultats);
    }
}
