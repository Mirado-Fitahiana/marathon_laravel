@extends('template.main')

@section('titre','Acceuil')
@section('navbar')
@section('sidebar')
@section('grand_icon','sort-numeric-asc')
@section('grand_titre','Point rapporter par coureur')


@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h2>Equipe: {{$liste[0]->nom_equipe}}</h2>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> Rang </th>
                            <th> Nom coureur </th>
                            <th> Numero dossard </th>
                            <th> points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($liste as $item)
                            @php
                                $count = $count + $item->points;
                            @endphp
                            <tr>
                                <td>{{$item->rang}}</td>
                                <td>{{$item->nom_coureur}}</td>
                                <td>{{$item->numero_dossard}}</td>
                                <td>{{$item->points}}</td>
                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td>{{$count}}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
