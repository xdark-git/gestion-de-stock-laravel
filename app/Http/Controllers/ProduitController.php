<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function liste()
    {
        return view('produit.liste');
    }

    public function ajouter(Request $request)
    {
        
    }
}
