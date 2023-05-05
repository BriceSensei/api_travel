<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'utilisateur_id',
        'destination_id',
        'date_de_départ',
        'date_de_retour',
        'nombre_de_voyageurs',
        'option_de_paiement',
        'tarif_total',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}