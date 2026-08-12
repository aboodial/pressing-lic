<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Mail\TicketConfirmationMail;
use App\Mail\TicketPretMail;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ticket::with('lignes.service', 'user');

        if ($request->user()->role === 'client') {
            $query->where('user_id', $request->user()->id);
        }

        $tickets = $query->latest()->get();

        return response()->json(TicketResource::collection($tickets));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): JsonResponse
    {
        $ticket = DB::transaction(function () use ($request) {
            $ticket = Ticket::create([
                'user_id' => $request->user()->id,
                'statut' => 'recu',
            ]);

            foreach ($request->validated('services') as $item) {
                $service = Service::findOrFail($item['service_id']);

                $ticket->lignes()->create([
                    'service_id' => $service->id,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $service->prix_unitaire,
                ]);
            }

            return $ticket;
        });

        $ticket->load('lignes.service', 'user');

        Mail::to($ticket->user->email)->send(new TicketConfirmationMail($ticket));

        return response()->json(new TicketResource($ticket), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load('lignes.service', 'user');

        return response()->json(new TicketResource($ticket));
    }

    /**
     * Faire évoluer le statut d'un ticket (gestionnaire uniquement).
     */
    public function changerStatut(Request $request, Ticket $ticket): JsonResponse
    {
        $request->validate([
            'statut' => 'required|in:en_traitement,pret,recupere',
        ]);

        $nouveauStatut = $request->input('statut');

        if ($nouveauStatut === 'recupere' && !$ticket->paiement()->exists()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Le ticket doit être payé avant d\'être marqué comme récupéré',
            ], 422);
        }

        $ticket->update(['statut' => $nouveauStatut]);

        $ticket->load('lignes.service', 'user');

        if ($nouveauStatut === 'pret') {
            Mail::to($ticket->user->email)->send(new TicketPretMail($ticket));
        }

        return response()->json(new TicketResource($ticket));
    }

    /**
     * Remove the specified resource from storage (annulation avant "prêt").
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        if ($ticket->statut === 'pret' || $ticket->statut === 'recupere') {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Impossible d\'annuler un ticket déjà prêt ou récupéré',
            ], 422);
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket annulé avec succès',
        ]);
    }
}
