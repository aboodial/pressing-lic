<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'prix_unitaire',
        'description',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'prix_unitaire' => 'decimal:2',
    ];
}
