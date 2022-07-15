@extends('layouts.app')
 
@section('title', 'Categorie')

@section('content')
<div class="row">
        <div class="container col-md-6">
            <div class="card ">
                <div class="card-header">Formulaire de gestion des categories</div>
                <div class="card-body">
                @foreach ($categorie as $c)
                <form action="/modifierCategorie/{{$c->id}}" method="post" >
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
                    
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" value="{{$c->nom}}"class="form-control form-group">
                    @endforeach
                    <input type="submit" value="Modifier" class="btn btn-success form-group">

                </form>
                </div>
            </div>
        </div>
    </div>
@endsection