<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function add()
    {
        return view('produit.add');
    }
    public function getAll()
    {
       // $liste_produits = Produit::paginate(2);
       $liste_produits = Produit::all();
        return view('produit.list',['liste_produits' => $liste_produits]);
    }
    public function edit($id)
    {
        return view('produit.edit');
    }
    public function update()
    {
        return $this->getAll();
    }
    public function delete($id)
    {
       return $this->getAll();
    }
    public function persist(Request $request)
    {
        $produits = new Produit();
        $produits->libelle = $request->libelle;
        $produits->stock = $request->stock;

       $result =  $produits->save();
       return view('produit.add',['confirmation' => $result]);
        //return view('produit.add');
    }
}
