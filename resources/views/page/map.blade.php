@extends('template.main')

@section('titre', 'map')
@section('navbar')
@section('sidebar')
@section('grand_icon', 'map-marker')
@section('grand_titre', 'Map')


@section('contenu')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id = "map" style = "width: 100%; height: 580px"></div>
                    <script>
                        // Creating map options
                        var mapOptions = {
                            center: [-18.935657, 47.526630],
                            zoom: 50
                        }

                        // Creating a map object
                        var map = new L.map('map', mapOptions);

                        // Creating a Layer object
                        var layer = new L.TileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/ {y}.png');

                        // Adding layer to the map
                        map.addLayer(layer);
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
