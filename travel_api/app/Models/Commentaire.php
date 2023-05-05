<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaires';
    
    protected $fillable = [
        'utilisateur_id',
        'destination_id',
        'note',
        'commentaire',
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
