<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    use HasFactory;
   
    public function produits()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }
}
