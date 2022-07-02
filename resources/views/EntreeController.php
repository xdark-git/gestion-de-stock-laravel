<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use Illuminate\Http\Request;

class EntreeController extends Controller
{
    public function add()
    {
        return view('entree.add');
    }
    public function getAll()
    {
        return view('entree.list');
    }
    public function edit($id)
    {
        return view('entree.edit');
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
        $entrees = new Entree();
        $entrees->quantite = $request->quantite;
        $entrees->prix = $request->prix;
        $entrees->date = $request->date;
       $result =  $entrees->save();
       return view('entree.add',['confirmation' => $result]);
    }
}
