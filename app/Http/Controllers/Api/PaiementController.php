<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Enregistrer le paiement d'un ticket.
     */
    public function store(Request $request, Ticket $ticket): JsonResponse
    {
        // Un ticket ne peut être payé qu'une seule fois
        if ($ticket->paiement()->exists()) {
            return response()->json([
                'status' => 'error',
                'code' => 409,
                'message' => 'Ce ticket a déjà été payé',
            ], 409);
        }

        $request->validate([
            'montant' => 'required|numeric|min:0',
        ]);

        $paiement = $ticket->paiement()->create([
            'montant' => $request->input('montant'),
            'date_paiement' => now(),
            'mode' => 'especes',
        ]);

        return response()->json([
            'id' => $paiement->id,
            'ticket_id' => $paiement->ticket_id,
            'montant' => (float) $paiement->montant,
            'date_paiement' => $paiement->date_paiement,
            'mode' => $paiement->mode,
        ], 201);
    }
}
