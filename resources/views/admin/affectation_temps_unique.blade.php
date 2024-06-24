@extends('template.main')

@section('titre', 'Affectation temps')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'clock-o')
@section('grand_titre', 'Affectation temps')


@section('contenu')
   
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if (isset($vue[0]) && $vue[0]->debut != null)
                        <h4> Le début du marathon commence à: {{ $vue[0]->debut }} </h4>
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
                    <form action="/store_affectation_temps" method="post">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> N° Dossard </th>
                                <th> Nom equipe </th>
                                <th> Nom coureur </th>
                                <th> Arrivée </th>
                               
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($vue as $item)
                                    <tr>
                                        @if (!isset($item->fin) && $item->fin == null)
                                        <td> {{ $item->numero_dossard }} </td>
                                        <td> {{ $item->nom }} </td>
                                        <td> {{ $item->nom_coureur }}</td>
                                        <td>
                                            <div>
                                                <input type="datetime-local" name="fin[]" class="form-control" name="arriver" step="1">
                                            </div>
                                           
                                        @endif
                                    </tr>
                                    <input type="hidden" name="fk_coureur[]" value="{{$item->id_coureur}}">
                                @endforeach

                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 mt-3 d-flex justify-content-end">
                                @if (isset($item->id_etape))
                                    
                                <button type="submit" name="id_etape" value="{{ $item->id_etape }}"
                                    class="btn btn-outline-success">
                                    Enregistrer
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
