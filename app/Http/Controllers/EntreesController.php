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
       
    }

    public function updatePage(Request $request)
    {
        $entrees = DB::table('entrees')->where('id',$request->route('id'))->get();

        $produits = DB::table('produits')->get();
        // echo $entrees;

        return view('entrees.update')
                ->with('entrees', $entrees)
                ->with('produits', $produits);
    }

    public function updateEntree(Request $request)
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
        $produitToUpdate = DB::table('produits')->where('id', $request->produit)->get();
        
        if(sizeof($produitToUpdate))
        {
            
            /*
                if the user try to update an entree where the old product stock is less than
                actual entree, it will throw an error else it will take back the quantite 
                in the old product stock and then update the new product selected
            */
            $entrees = Entree::with('produits')->where('id',$request->route('id'))->get();

            $returnBackStock = $entrees[0]->produits->stock - $entrees[0]->quantite;
            // echo $returnBackStock;

            if($returnBackStock<0){
                return back()->withErrors([
                    'error' => 'le stock de '.$entrees[0]->produits->libelle.' est inférieure à la quantité d\'entree '.$entrees[0]->quantite,
                ]);
            }
            
            $oldProduit= Produit::find($entrees[0]->produits->id);

            if($oldProduit->id == $request->produit)
            {
                $oldProduit->stock = $returnBackStock + $request->quantite;
                $oldProduit->save();

                $entreesToUpdate = Entree::find($request->route('id'));
                $entreesToUpdate->quantite = $request->quantite;
                $entreesToUpdate->prix = $request->prix;
                $entreesToUpdate->date = $request->date;
                $entreesToUpdate->produit_id = $request->produit;
                $entreesToUpdate->save();

                return redirect('/entrees');
            }
            
            $oldProduit->stock = $returnBackStock;
            $oldProduit->save();

            $entreesToUpdate = Entree::find($request->route('id'));
            $entreesToUpdate->quantite = $request->quantite;
            $entreesToUpdate->prix = $request->prix;
            $entreesToUpdate->date = $request->date;
            $entreesToUpdate->produit_id = $request->produit;
            $entreesToUpdate->save();

            $newStock = $produitToUpdate[0]->stock + $request->quantite;
            $produit= Produit::find($request->produit);
            $produit->stock = $newStock;
            $produit->save();

            
            return redirect('/entrees');

            
        }
        else{
            return back()->withErrors([
                'error' => 'le produit n\'existe pas dans la base',
            ]);
        }
        
        
    }

    public function deleteEntree(Request $request)
    {
        $entreeToDelete = Entree::with('produits')->where('id',$request->route('id'))->get();
        // echo $entreeToDelete;
        if(sizeof($entreeToDelete)>0)
        {
            $verifyStock = $entreeToDelete[0]->produits->stock - $entreeToDelete[0]->quantite;

            if($verifyStock<0)
            {
                return back()->withErrors([
                    'error' => 'le stock de '.$entreeToDelete[0]->produits->libelle.' est inférieure à la quantité d\'entree '.$entrees[0]->quantite,
                ]);
            }

            $produit = Produit::find($entreeToDelete[0]->produits->id);
            $produit->stock = $verifyStock;
            $produit->save();

            $entreeDeteled = Entree::find($entreeToDelete[0]->id);
            $entreeDeteled->delete();

            return redirect('/entrees');
        }
        return back()->withErrors([
            'error' => 'l\'entrée que vous essayez de supprimer n\'existe pas dans la base',
        ]);
    }
}
