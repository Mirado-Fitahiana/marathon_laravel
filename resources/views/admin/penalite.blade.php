@extends('template.main')

@section('titre', 'pénalité')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'clock-o')
@section('grand_titre', 'Pénalité')


@section('contenu')
    
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary" id="addPenaltyBtn">Ajouter pénalité</button>
                    </div>
                    <form id="penaltyForm" action="/store_pen" method="POST" style="display: none;">
                        @csrf
                        <div class="row mt-2">
                            <h3>Ajout pénalité</h3>
                            <hr>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Etape</label>
                                    <select class="form-select" name="id_etape">
                                        @foreach ($etape as $item)
                                            <option value="{{ $item->id_etape }}">{{ $item->nom_etape }}
                                                n°{{ $item->rang_etape }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Etape</label>

                                    <select class="form-select" name="id_equipe">
                                        @foreach ($equipe as $item2)
                                            <option value="{{ $item2->id_utilisateur }}"> {{ $item2->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pénalité</label>
                                    <input type="time" name="penalite" id="" step="1"
                                        class="form-control"style="height: 38px;">
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <button type="submit" class="btn btn-outline-danger">
                                    Enregistrer pénalité
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <h2> Liste pénalité par étape </h2>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> Etape </th>
                            <th> Equipe </th>
                            <th> Temps pénalite </th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penalite as $item)
                            <tr>
                                <td>{{ $item->nom_etape }}</td>
                                <td>{{ $item->nom }}</td>
                                <td>{{ $item->penalite }}</td>
                                <td>
                                    <button type="button" class="btn btn-gradient-danger btn-icon-text open-modal"
                                        data-toggle="modal" data-target="#validationModal{{ $item->id_penalite }}">
                                        <i class="mdi mdi-close btn-icon-prepend"></i> Effacer
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="validationModal{{ $item->id_penalite }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Validation</h5>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir effacer?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Annuler</button>
                                            <form action="/del_penalite" method="post">
                                                @csrf
                                                <button type="submit" name="id_penalite" value="{{ $item->id_penalite }}"
                                                    class="btn btn-danger">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Gestionnaire d'événements pour ouvrir la modal spécifique
        $('.open-modal').on('click', function() {
            var targetModalId = $(this).data(
                'target'); // Récupère l'ID de la modal cible depuis l'attribut data-target
            $(targetModalId).modal('show'); // Ouvre la modal cible
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var addButton = document.getElementById('addPenaltyBtn');
            var penaltyForm = document.getElementById('penaltyForm');

            function showPenaltyForm() {
                penaltyForm.style.display = "block";
            }
            addButton.addEventListener('click', showPenaltyForm);
        });
    </script>
@endsection

@section('footer')
