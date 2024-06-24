@extends('template.main')

@section('titre', 'Acceuil')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'building-o')
@section('grand_titre', 'Classement général')


@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Total de tout les points cumulé</h4>
                <p class="card-description">
                </p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Equipe </th>
                            <th> Numero Dossard </th>
                            <th> Nom coureur </th>
                            <th> points cumulé </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classement as $item)
                        <tr>
                            <td>{{$item->nom_equipe}}</td>                        
                            <td>{{$item->numero_dossard}}</td>                        
                            <td>{{$item->nom_coureur}}</td>                        
                            <td>{{$item->points}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
