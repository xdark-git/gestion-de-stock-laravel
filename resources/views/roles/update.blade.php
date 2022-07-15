@extends('layouts.app')
 
@section('title', 'Categorie')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Formulaire de gestion des categories</div>
                <div class="card-body">
                @foreach ($produits as $p)
                <form action="/modifierProduit/{{$p->id}}" method="post" >
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <label for="nom">Libelle</label>
                    <input type="text" name="libelle" value="{{$p->libelle}}" class="form-control form-group">
                    <label for="stock">Quantité en stock</label>
                    <input type="text" name="stock" value="{{$p->stock}}" class="form-control form-group">
                    <label for="stock">Catégorie</label>
                    <select class="form-control form-group" aria-label=".form-select-lg example"  name ="categorie_id">
                        <option selected>Selectionner la catégorie du produit</option>
                        @foreach($categories as $categorie)
                            <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Modifier" class="btn btn-success form-group">
                    @endforeach
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection