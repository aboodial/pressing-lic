<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statut',
    ];

    // Le client qui a déposé ce ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Les lignes de commande (services + quantités) de ce ticket
    public function lignes()
    {
        return $this->hasMany(TicketLigne::class);
    }

    // Le paiement lié à ce ticket (un seul, comme prévu dans le cahier des charges)
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
