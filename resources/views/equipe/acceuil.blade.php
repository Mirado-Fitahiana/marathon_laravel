@extends('template.main')

@section('titre', 'Acceuil')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'home')
@section('grand_titre', session('utilisateur')->nom)


@section('contenu')

    @for ($i = 0; $i < count($data); $i++)
        @php
            $nombre_coureur = $data[$i][0]->nombre_coureur;
            $nombre = count($data[$i]);
        @endphp
        <div class="row">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">{{$data[$i][0]->nom_etape}}({{$data[$i][0]->longueur}} km)  - {{$data[$i][0]->nombre_coureur}} coureur</h4>  

                    </p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> Nom </th>
                                <th> Temps chrono</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data[$i] as $item)
                                <tr>
                                    <td> {{$item->nom_coureur}} </td>
                                    <td> {{$item->duree}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <a
                        
                        class="btn btn-outline-primary"
                        href="{{ route('affectation', ['id' => $item->id_etape]) }}"
                        role="button"
                        onclick="return verifie_max({{$nombre_coureur}},{{$nombre}},this.href)"
                        >Ajouter coureur</a
                    >   
                    
                </div>
            </div>
            <div>
                <br>
    @endfor

    
    

@endsection
<div class="modal fade" id="verifie_maxs" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Oupss!!</h5>
            </div>
            <div class="modal-body">
                Vous avez atteint vos limites
            </div>
        </div>
    </div>
</div>
<script>
    function verifie_max(nombre_coureur,nombreActuel,href){
        if (nombreActuel >= nombre_coureur) {
            $('#verifie_maxs').modal('show');
            return false;
        }
        window.location.href = href;
        return false;
    }
    document.addEventListener('DOMContentLoaded',function(){
        $('#verifie_maxs').modal({show:false})
    });
</script>
@section('footer')
