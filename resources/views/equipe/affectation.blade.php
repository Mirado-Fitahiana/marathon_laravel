@extends('template.main')

@section('titre', 'Affectation coureur')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'bolt')
@section('grand_titre', 'Affectation coureur etape')

@section('contenu')

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4>Details: </h4>
                    <p>
                        participant maximum : {{ $etape->nombre_coureur }}
                    </p>
                </div>
                <h6>Choisissez vos coureurs pour courir à {{ $etape->nom_etape }}</h6>
                <div class="row">
                    <form action="{{ url('/course') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="etape" value="{{ $etape->id_etape }}">
                            <select class="js-example-basic-multiple select2-hidden-accessible" name="coureur[]"
                                multiple="" style="width:100%" tabindex="-1" aria-hidden="true">
                                @foreach ($coureur as $item)
                                    <option value="{{ $item->id_coureur }}">{{ $item->nom_coureur }},
                                        N°{{ $item->numero_dossard }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-outline-primary justify-content-end">Affecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
