@extends('template.main')

@section('titre', 'Acceuil')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'home')
@section('grand_titre', 'Classement')


@section('contenu')
    <div class="row">
        <div class="card">
            <div class="card-body">

                <h2>Classement general</h2>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th> Rang </th>
                                    <th> Nom equipe </th>
                                    <th> Points </th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classement as $items)
                                    <tr>
                                        <td>{{ $items->rang }}</td>
                                        <td>{{ $items->nom_equipe }}</td>
                                        <td>{{ $items->points }}</td>
                                        <td>
                                            <a
                                            name=""
                                            id=""
                                            class="btn btn-primary"
                                            href="{{ route('detail_score', ['id' => $items->id_utilisateur]) }}"
                                            role="button"
                                            >detail</a
                                        >
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <a
                            name=""
                            id=""
                            class="btn btn-outline-primary"
                            href="{{url('/generate_pdf')}}"
                            role="button"
                            >Télécharger le certificat</a
                        >
                        
                        
                    </div>

                    <div class="col-md-8">
                        <canvas style="max-height:300px " id="chartPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h2>Classement par categorie</h2>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label">choisissez une categorie</label>
                            <div class="col-sm-6 mt-1">
                                <select name="id_categorie" class="form-select" id="categorie">
                                    @foreach ($categorie as $item)
                                        <option value="{{ $item->id_categorie }}">{{ $item->nom_categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <table class="table table-bordered" id="categorie-table">
                            <thead>
                                <tr>
                                    <th> Rang </th>
                                    <th> Nom equipe </th>
                                    <th> Points </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8" id="chart">
                        <canvas style="max-height:300px" id="chartPie2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Calcul de la somme totale des points
        var labels = [];
        var datasets = [];

        @foreach ($classement as $item)
            labels.push('{{ $item->nom_equipe }}');
            datasets.push({
                y: {{ $item->points }},
                label: '{{ $item->nom_equipe }}'
            });
        @endforeach

        var ctx = document.getElementById('chartPie').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                // title:'Akory',
                labels: labels,
                datasets: [{
                    data: datasets.map(dataset => dataset.y),

                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Classement général'
                    }
                },
            },

        });
    </script>

    <script>
        $(document).ready(function() {
            let temp = null;
            $('#categorie').on('change', function() {
                // Récupérer la valeur sélectionnée
                var selectedValue = $(this).val();

                // Envoyer la requête AJAX
                $.ajax({
                    url: '{{ route('show_classement_general') }}', // Remplacez "your_route_name" par le nom de votre route
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}', // Laravel exige un token CSRF pour les requêtes POST
                        selectedValue: selectedValue
                    },
                    success: function(response) {
                        // Créez une chaîne pour stocker le HTML des lignes du tableau
                        var html = "";
                        var labels = [];
                        var datasets = [];

                        // Parcourez les données de la réponse et construisez les lignes du tableau
                        var rangCounts = {};
                            response.forEach(function(classement) {
                                if (rangCounts[classement.rang]) {
                                    rangCounts[classement.rang]++;
                                } else {
                                    rangCounts[classement.rang] = 1;
                                }
                            });

                            // Ensuite, générer le HTML en appliquant le style de couleur si nécessaire
                            response.forEach(function(classement) {
                                var rangStyle = rangCounts[classement.rang] > 1 ? "background-color: aqua;" : "";
                                html += "<tr>";
                                html += "<td style='" + rangStyle + "'>" + classement.rang + "</td>";
                                html += "<td style='" + rangStyle + "'>"  + classement.nom_equipe + "</td>";
                                html += "<td style='" + rangStyle + "'>"  + classement.total_points + "</td>";
                                html += "</tr>";
                                labels.push(classement.nom_equipe);
                                datasets.push({
                                    y: classement.total_points,
                                    label: classement.nom_equipe
                                });
                            });

                        
                        // Remplacez le contenu du corps du tableau avec le HTML généré
                        $('#categorie-table tbody').html(html);
                        var ctx = document.getElementById('chartPie2').getContext('2d');
                        if (temp !== null) {
                            temp.destroy();
                        }
                        temp = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: datasets.map(dataset => dataset.y),
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    }
                                }
                            }
                        });


                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

@section('footer')
