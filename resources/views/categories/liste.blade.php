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
                            <th>nom</th>
                            <th></th>
                            <th></th>
                            <!-- <th></th> -->
                        </tr>
                        @foreach($categories as $categorie)
                        <tr>
                            <td> {{$categorie->nom}} </td>
                            <td> 
                                <a href="/modifierCategorie/{{$categorie->id}}">Modifier</a>
                            </td>
                            <td> 
                            <a style="color: red" href="/modifierCategorie/{{$categorie->id}}">Supprimer</a>
                            </td>
                            <!-- <td>
                                <form action="" method="get">
                                <input type="hidden" name="categorieId" value="">
                                 <input type="submit" value="Ajouter" class="btn btn-success form-group">
                                </form> 
                            </td> -->
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="text" name="nom" placeholder="Nom" class="form-control form-group">
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection