@extends('template.main')

@section('titre', 'Affectation temps')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'clock-o')
@section('grand_titre', 'Affectation temps')


@section('contenu')
    @if (session('error'))
        <div class="row">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if (session('succes'))
        <div class="row">
            <div class="alert alert-succes">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($vue[0]) && $vue[0]->debut_course != null)
                        <h4> Le début du marathon commence à: {{ $vue[0]->debut_course }} </h4>
                    @else
                        <form action="/debut" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mt-3  ">
                                    <h4 class="card-title"> Annoncer le début : </h4>
                                </div>
                                <div class="col-md-4">
                                    <input type="datetime-local" class="form-control" name="debut" id="">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="id_etape" value="{{ $id }}"
                                        class="btn btn-outline-danger">
                                        Depart
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <p class="card-description mt-2"> Affecter ici le temps des coureurs
                    </p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> N° Dossard </th>
                                <th> Nom equipe </th>
                                <th> Nom coureur </th>
                                <th> Arriver </th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vue as $item)
                                <tr>
                                    <td> {{ $item->numero_dossard }} </td>
                                    <td> {{ $item->nom }} </td>
                                    <td> {{ $item->nom_coureur }}</td>
                                    @if (isset($item->fin) && $item->fin != null)
                                    <td>{{$item->fin}}</td>
                                    <td>{{$item->duree}}</td>
                                    @else
                                    <form action="/store_affectation_temps" method="post">
                                        @csrf
                                        <td>
                                            <div>
                                                <input type="time" name="fin" class="form-control" name="arriver"
                                                    step="1">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" name="id_coureur" value="{{ $item->id_coureur }}"
                                                class="btn btn-outline-success">
                                                Enregistrer
                                            </button>
                                        </td>
                                    </form>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
