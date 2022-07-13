<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
     /**
     * Show a list of all of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function liste()
    {
        $categories = DB::table('categories')->get();

        $produits = DB::table('produits')->get();

        return view('produit.liste')
                ->with('categories', $categories)
                ->with('produits', $produits);

    }

    /**
     * Store a new produit in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajouter(Request $request)
    {
        
        if(intval($request->stock) < 0)
        {
            return back()->withErrors([
                'error' => 'la quantité de stock ne peut pas etre négative',
            ]);
        }
        // check if the product already exist before storing it
        $produits = DB::table('produits')->where('libelle', $request->libelle)->get();
        foreach($produits as $produit)
        {
            if($produit->libelle && $produit->categorie_id == $request->categorie_id)
            {
                return back()->withErrors([
                    'error' => 'il existe déjà un produit du meme nom et de la meme catégorie',
                ]);
            }
        }
       

        $newProduit = new Produit;

        $newProduit->libelle = $request->libelle;
        $newProduit->stock = $request->stock;
        $newProduit->user_id = auth()->user()->id;
        
        $newProduit->categorie_id = $request->categorie_id;
        $newProduit->save();

        return redirect('/produit');

        
    }
}
