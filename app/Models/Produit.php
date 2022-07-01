<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produits';

    public function entrees()
    {
        return $this->hasMany(Entree::class);
    }

    public function sorite()
    {
        return $this->hasMany(Sortie::class);
    }
}
