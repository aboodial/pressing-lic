<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'montant',
        'date_paiement',
        'mode',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    // Le ticket concerné par ce paiement
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
