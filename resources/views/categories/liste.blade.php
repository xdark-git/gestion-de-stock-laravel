@extends('layouts.app')
 
@section('title', 'Produit')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Liste des catégories</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Identifiant</th>
                            <th>nom</th>
                        </tr>
                        @foreach($categories as $categorie)
                        <tr>
                            <td> {{$categorie->id}} </td>
                            <td> {{$categorie->nom}} </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Formulaire de gestion des categories</div>
                <div class="card-body">
                <form action="{{route('ajouterCategories')}}" method="post" >
                    @csrf
                    <input type="text" name="nom" placeholder="Nom" class="form-control form-group">
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection