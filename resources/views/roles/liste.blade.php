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
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if(sizeof($user->roles) == 0)
                                    -
                                    @endif
                                    @if(sizeof($user->roles) == 1)
                                    {{$user->roles[0]->name}}
                                    @endif
                                    @if(sizeof($user->roles) > 1)
                                    <a href="/listeRoles/{{$user->id}}">liste des roles</a>
                                    @endif

                                </td>
                                <td> 
                                    <a href="/modifierUtilisateur/{{$user->id}}">Modifier</a>
                                </td>
                                <td> 
                                    <a style="color: red" href="/supprimerUtilisateur/{{$user->id}}">Supprimer</a>
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
                <form action="#" method="post" >
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
                        <option selected>Selectionner le role de l'utilisateur </option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection