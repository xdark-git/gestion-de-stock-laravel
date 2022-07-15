@extends('layouts.app')
 
@section('title', 'Produit')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Liste des produits</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>libelle</th>
                            <th>Quantite en stock</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($produits as $produit)
                            <tr>
                                <td>{{$produit->libelle}}</td>
                                <td>{{$produit->stock}}</td>
                                <td> 
                                    <a href="/modifierProduit/{{$produit->id}}">Modifier</a>
                                </td>
                                <td> 
                                    <a style="color: red" href="/supprimerProduit/{{$produit->id}}">Supprimer</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Formulaire de gestion des produits</div>
                <div class="card-body">
                <form action="{{route('ajouterProduit')}}" method="post" >
                    @csrf
                    @if($errors->any())
						<div class="alert alert-danger">
                        <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
						</div>
					@endif
                    <input type="text" name="libelle" placeholder="Libelle" class="form-control form-group">
                    <input type="text" name="stock" placeholder="Quantité stock" class="form-control form-group">
                    <select class="form-control form-group" aria-label=".form-select-lg example"  name ="categorie_id">
                        <option selected>Selectionner la catégorie du produit</option>
                        @foreach($categories as $categorie)
                            <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection