@extends('template.main')

@section('titre', 'Classement par étape')
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
                    <h1>{{$classement[0]->nom_etape}}</h1>
                    <thead>
                        <tr>
                            <th>@sortableLink('rang','rang ')</th>
                            <th>@sortableLink('nom_equipe','Equipe')  </th>
                            <th>@sortableLink('numero_dossard','Numero Dossard') </th>
                            <th>@sortableLink('nom_coureur','Nom coureur')  </th>
                            <th>@sortableLink('genre','Genre') </th>
                            <th>@sortableLink('duree','duree') </th>
                            <th>@sortableLink('penalite','pénalité ') </th>
                            <th>@sortableLink('duree_total','total') </th>
                            <th>@sortableLink('points','points cumulé ') </th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classement as $item)
                        <tr>
                            <td>{{$item->rang}}</td>
                            <td>{{$item->nom_equipe}}</td>                        
                            <td>{{$item->numero_dossard}}</td>                        
                            <td>{{$item->nom_coureur}}</td> 
                            <td>{{$item->genre}}</td> 
                            <td>{{$item->duree}}</td>    
                            <td>{{$item->penalite}}</td>                       
                            <td>{{$item->duree_total}}</td>                       
                            <td>{{$item->points}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                    {{-- <div class="row">
                        {{$classement->links()}}
                    </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('footer')
