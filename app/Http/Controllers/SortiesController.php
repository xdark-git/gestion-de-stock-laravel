<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Sortie;
use Illuminate\Support\Facades\DB;

class SortiesController extends Controller
{
    public function liste()
    {
        $produits = DB::table('produits')->get();
        $sorties = Sortie::with('produits')->get();
        
        return view('sorties.liste')
                ->with('produits', $produits)
                ->with('sorties', $sorties);
    }

    public function ajouter(Request $request)
    {
        $validated = $request->validate([
            'quantite' => 'required',
            'prix' => 'required',
            'date' => 'required',
            'produit_id' => 'required',
        ]);
        
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

        /*
            checking if the product selected exist
        */
        $produit = DB::table('produits')->where('id', $request->produit_id)->get();
        if(sizeof($produit)>0)
        {
            $checkStock = $produit[0]->stock - $request->quantite;
            
            if($checkStock < 0)
            {
                return back()->withErrors([
                    'error' => 'le stock de '.$produit[0]->libelle.' est inférieur à '.$request->quantite,
                ]);
            }
            $updateProduit = Produit::find($produit[0]->id);
            $updateProduit->stock = $checkStock;
            $updateProduit->save();

            $newSortie = new Sortie;

            $newSortie->quantite = $request->quantite;
            $newSortie->prix = $request->prix;
            $newSortie->date = $request->date;
            $newSortie->produit_id = $request->produit_id;
            $newSortie->user_id = auth()->user()->id;
            $newSortie->save();
            
            return redirect('/sorties');
        }
        else{
            return back()->withErrors([
                'error' => 'le produit selectioné n\'existe pas dans la base',
            ]);
        }
    }

    public function updatePage(Request $request)
    {
        $sorties = DB::table('sorties')->where('id',$request->route('id'))->get();

        $produits = DB::table('produits')->get();
        // echo $entrees;

        return view('sorties.update')
                ->with('sorties', $sorties)
                ->with('produits', $produits);
    }

    public function updateSortie(Request $request)
    {
        $validated = $request->validate([
            'quantite' => 'required',
            'prix' => 'required',
            'date' => 'required',
            'produit' => 'required',
        ]);

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
        // checking if the new product selected exist before updating 
        $produitToUpdate = Produit::find($request->produit);
        // echo "okay";
        if($produitToUpdate != null)
        {
            
            
            $sorties = Sortie::with('produits')->where('id', $request->route('id'))->get();
            /* 
                if the user doesn't change the sortie product 
                we will first return the old stock and verify if before we update it
            */
            if($request->produit == $sorties[0]->produits->id)
            {
                $newStock = $produitToUpdate->stock + $sorties[0]->quantite;
                $checkStock = $newStock - $request->quantite;
                if($checkStock < 0)
                {
                    return back()->withErrors([
                        'error' => 'le stock de '.$produitToUpdate->libelle.' est inférieur à '.$request->quantite,
                    ]); 
                }
                $updateSortie = Sortie::find($sorties[0]->id);
                $updateSortie->quantite = $request->quantite;
                $updateSortie->prix = $request->prix;
                $updateSortie->date = $request->date;
                $updateSortie->user_id = auth()->user()->id;
                $updateSortie->save();

                $produitToUpdate->stock = $checkStock;
                $produitToUpdate->save();

                return redirect('/sorties');

            }
            /*
                we are going to check if the new product has enough stock
                if it does we will get the old product and return the quantite
                and then update the new Product
            */

            $checkStock = $produitToUpdate->stock - $request->quantite;

            if($checkStock<0)
            {
                return back()->withErrors([
                    'error' => 'le stock de '.$produitToUpdate->libelle.' est inférieur à '.$request->quantite,
                ]);
            }
            $oldProduct = Produit::find($sorties[0]->produits->id);
            $oldProduct->stock = $oldProduct->stock + $sorties[0]->quantite;
            $oldProduct->save();

            $updateSortie = Sortie::find($sorties[0]->id);
            $updateSortie->quantite = $request->quantite;
            $updateSortie->prix = $request->prix;
            $updateSortie->date = $request->date;
            $updateSortie->produit_id = $request->produit;
            $updateSortie->user_id = auth()->user()->id;
            $updateSortie->save();

            $produitToUpdate->stock = $checkStock;
            $produitToUpdate->save();

            return redirect('/sorties');
            
        }
        else{
            return back()->withErrors([
                'error' => 'le produit n\'existe pas dans la base',
            ]);
        }   
    }

    public function deleteSortie(Request $request)
    {

    }
}
