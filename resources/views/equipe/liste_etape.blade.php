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
                <h3>Cliquez pour inserez vos coureurs</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Rang course</th>
                            <th>Nom Etape</th>
                            <th style="text-align: center">Nombre coureur</th>
                            <th style="text-align: center">Distance</th>
                            <th style="text-align: center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etape as $item)
                        <tr>
                            <td>{{$item->rang_etape}}</td>
                            <td>{{$item->nom_etape}}</td>
                            <td class="text-danger" style="text-align: right;">{{$item->nombre_coureur}}</td>
                            <td>{{$item->longueur}} km</td>
                            <td style="text-align: center">
                                {{-- <a
                                class="btn btn-outline-success"
                                href="{{ route('affectation', ['id' => $item->id_etape]) }}"
                                role="button"
                                >Participer</a
                            > --}}
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
