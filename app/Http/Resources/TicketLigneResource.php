<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketLigneResource extends JsonResource
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
            'service_id' => $this->service_id,
            'service_libelle' => $this->service->libelle,
            'quantite' => $this->quantite,
            'prix_unitaire' => (float) $this->prix_unitaire,
            'sous_total' => (float) ($this->quantite * $this->prix_unitaire),
        ];
    }
}
