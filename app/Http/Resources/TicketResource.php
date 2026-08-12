<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'statut' => $this->statut,
            'client' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'lignes' => TicketLigneResource::collection($this->whenLoaded('lignes')),
            'montant_total' => (float) $this->lignes->sum(function ($ligne) {
                return $ligne->quantite * $ligne->prix_unitaire;
            }),
            'paye' => $this->paiement()->exists(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
