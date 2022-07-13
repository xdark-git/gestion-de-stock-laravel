<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;


class CategoriesController extends Controller
{
    /**
     * Show a list of all of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function liste()
    {
        $categories = DB::table('categories')->get();

        return view('categories.liste',  ['categories' => $categories]);
    }

     /**
     * Store a new categorie in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajouter(Request $request)
    {
        $categorie = new Categorie;

        $categorie->nom = $request->nom;

        $categorie->save();

        return redirect('/categories');
    }
}
