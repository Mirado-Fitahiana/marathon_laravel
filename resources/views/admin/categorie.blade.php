@extends('template.main')

@section('titre','Categorie')
@section('navbar')
@section('sidebar')
@section('grand_icon','leaf')
@section('grand_titre','Affectation categorie')

@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Joueur </th>
                            <th> Categorie</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorie as $item)
                        <tr>
                            <td>{{$item->nom_coureur}}</td>                        
                            <td>{{$item->nom_categorie}}</td>                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <a
                            name=""
                            id=""
                            class="btn btn-primary"
                            href="{{url('/setCategorie')}}"
                            role="button"
                            >Mettre a jour la categorie de chaque joueur</a
                        >          
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
