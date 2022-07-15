@extends('layouts.app')
 
@section('title', 'Produit')

@section('content')
<div class="row">
<div class="container col-md-6">
        <div class="card ">
                <div class="card-header">Liste des sorties
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Libelle</th>
                            <th>Quantite</th>
                            <th>prix</th>
                            <th>Date</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($sorties as $sortie)
                            <tr>
                                <td>{{$sortie->produits->libelle}}</td>
                                <td>{{$sortie->quantite}}</td>
                                <td>{{$sortie->prix}}</td>
                                <td>{{$sortie->date}}</td>
                                <td> 
                                    <a href="/modifierSortie/{{$sortie->id}}">Modifier</a>
                                </td>
                                <td> 
                                    <a style="color: red" href="/supprimerSortie/{{$sortie->id}}">Supprimer</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Formulaire de gestion des sorties</div>
                <div class="card-body">
                <form action="{{route('ajouterSortie')}}" method="post" >
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
                    <select class="form-control form-group" aria-label=".form-select-lg example"  name ="produit_id">
                        <option selected>Selectionner le produit</option>
                        @foreach($produits as $produit)
                            <option value="{{$produit->id}}">{{$produit->libelle}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="quantite" placeholder="Quantite" class="form-control form-group">
                    <input type="text" name="prix" placeholder="prix" class="form-control form-group">
                    <input type="date" name="date" class="form-control form-group">
                    
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection