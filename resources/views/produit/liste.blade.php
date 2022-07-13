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
                            <th>Identifiant</th>
                            <th>libelle</th>
                            <th>Quantite en stock</th>
                        </tr>
                        
                        <!-- {% for p in produits%} -->
                        <tr>
                            <td> p.id </td>
                            <td>p.libelle </td>
                            <td>p.qtStock </td>
                        </tr>
                        <!-- {% endfor %} -->
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
                    <input type="text" name="libelle" placeholder="Libelle" class="form-control form-group">
                    <input type="text" name="stock" placeholder="Quantité stock" class="form-control form-group">
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection