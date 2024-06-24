@extends('template.main')

@section('titre', 'Liste étapes')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'road')
@section('grand_titre', 'Les etapes')


@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h3>Cliquez pour affecter le temps des joueurs</h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: right">Rang course</th>
                            <th style="text-align: right">Nom Etape</th>
                            <th style="text-align: center">Nombre coureur</th>
                            <th style="text-align: right">Distance</th>
                            <th>debut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etape as $item)
                        <tr>
                            <td style="text-align: right">{{$item->rang_etape}}</td>
                            <td style="text-align: right">{{$item->nom_etape}}</td>
                            <td class="text-danger" style="text-align: center;">{{$item->nombre_coureur}}</td>
                            <td style="text-align: right;">{{$item->longueur}} km</td>
                            <td>{{$item->debut}}</td>
                            <td><a
                                class="btn btn-outline-success"
                                href="{{ route('affectation_temps', ['id' => $item->id_etape]) }}"
                                role="button"
                                >Temps</a>
                                <a
                                name=""
                                id=""
                                class="btn btn-outline-warning"
                                href="{{ route('result_etape', ['id_etape' => $item->id_etape]) }}"
                                role="button"
                                >Resultat</a
                            >
                            </td>
                            
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection

@section('footer')
