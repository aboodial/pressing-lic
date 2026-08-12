<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketLigne extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'service_id',
        'quantite',
        'prix_unitaire',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
    ];

    // Le ticket auquel appartient cette ligne
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Le service commandé dans cette ligne
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
