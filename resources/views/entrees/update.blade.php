@extends('layouts.app')
 
@section('title', 'Categorie')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Modification Entrée</div>
                <div class="card-body">
                 
                <form action="/modifierEntree/{{$entrees[0]->id}}" method="post" >
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
                    <label for="quantite">Quantité</label>
                    <input type="text" name="quantite" value="{{$entrees[0]->quantite}}" class="form-control form-group">
                    <label for="prix">Prix</label>
                    <input type="text" name="prix" value="{{$entrees[0]->prix}}" class="form-control form-group">
                    <label for="prix">date</label>
                    <input type="date" name="date" value="{{$entrees[0]->date}}" class="form-control form-group">
                    <label for="produit">Produit</label>
                    <select class="form-control form-group" aria-label=".form-select-lg example"  name ="produit">
                        <option selected>Selectionner le produit</option>
                        @foreach($produits as $produit)
                            <option value="{{$produit->id}}">{{$produit->libelle}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Modifier" class="btn btn-success form-group">
                    
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection