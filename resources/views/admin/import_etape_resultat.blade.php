@extends('template.main')

@section('titre','Import equipes resultat')
@section('navbar')
@section('sidebar')
@section('grand_icon','file-archive-o')
@section('grand_titre','Import equipes resultat')


@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <form action="{{ url('/import_etape_resulat') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="file_etape">Etape</label>
                        <div class="input-group col-xs-12">
                            <input type="file" name="file_etape" class="form-control file-upload-info"
                                placeholder="Upload">
                        </div>
                        <br>
                        <label for="file_resultat">Resutat</label>
                        <div class="input-group col-xs-12">
                            <input type="file" name="file_resultat" class="form-control file-upload-info"
                                placeholder="Upload">
                        </div>
                        <br>
                        <div class="input-group justify-content-end ">
                            <button type="submit" class="btn btn-primary">
                                Enregister
                            </button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
