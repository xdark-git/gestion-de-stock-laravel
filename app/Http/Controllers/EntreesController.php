<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Entree;
use Illuminate\Support\Facades\DB;

class EntreesController extends Controller
{
    public function liste()
    {
        $produits = DB::table('produits')->get();
        $entrees = Entree::with('produits')->get();
        
        return view('entrees.liste')
                ->with('produits', $produits)
                ->with('entrees', $entrees);
    }

    /**
     * Store a new Entree in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajouter(Request $request)
    {
        
        if(intval($request->quantite) < 0)
        {
            return back()->withErrors([
                'error' => 'la quantité ne peut pas etre une valeur négative',
            ]);
        }

        if(intval($request->prix) < 0)
        {
            return back()->withErrors([
                'error' => 'le prix ne peut pas etre une valeur négative',
            ]);
        }

        // check if the product already exist before storing it
        $produits = DB::table('produits')->where('id', $request->produit_id)->get();
        foreach($produits as $produit)
        {
            if($produit->id == $request->produit_id)
            {
                // update product stock
                $newStock = $produit->stock + $request->quantite;
                // $produits->stock = $newStock;
                $updateProduit = Produit::find($produit->id);
                $updateProduit->stock = $newStock;
                $updateProduit->save();
                // store the new entree
                $newEntrees = new Entree;

                $newEntrees->quantite = $request->quantite;
                $newEntrees->prix = $request->prix;
                $newEntrees->date = $request->date;
                $newEntrees->produit_id = $request->produit_id;
                $newEntrees->user_id = auth()->user()->id;

                $newEntrees->save();

                return redirect('/entrees');
                
            }
            else{
                return back()->withErrors([
                    'error' => 'le produit n\'existe pas dans la base',
                ]);
            }
        }
       

        // $newProduit = new Produit;

        // $newProduit->libelle = $request->libelle;
        // $newProduit->stock = $request->stock;
        // $newProduit->user_id = auth()->user()->id;
        
        // $newProduit->categorie_id = $request->categorie_id;
        // $newProduit->save();

        // return redirect('/produit');

        
    }
}
