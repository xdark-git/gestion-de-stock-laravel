@extends('layouts.app')
 
@section('title', 'Produit')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Liste des utilisateurs</div>
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
                <div class="card-header">Formulaire d'enregistrement de nouvels utilisateurs</div>
                <div class="card-body">
                <form action="{{route('nouvelUtilisateur')}}" method="post" >
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
                    <input type="text" name="name" placeholder="nom" class="form-control form-group">
                    <input type="text" name="email" placeholder="email" class="form-control form-group">
                    @foreach($roles as $role)
                        <div class="d-inline">
                            <input type="checkbox" value="{{$role->id}}" name="{{$role->id}}"> {{$role->name}}
                        </div>
                    @endforeach
                    </br></br>
                    <input type="submit" value="Ajouter" class="btn btn-success form-group">
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection