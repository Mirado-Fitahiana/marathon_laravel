<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('titre')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src=" {{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{asset('assets/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/popper.min.js')}}"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="/assets/leaflet /leaflet.css" /> --}}
    {{-- <script src="/assets/leaflet/leaflet.js"></script> --}}

</head>

<body>
    <div class="container-scroller">
        @section('navbar')
            @include('template.navbar')
       

        <div class="container-fluid page-body-wrapper">
            @section('sidebar')
                @include('template.sidebar')


                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white me-2">
                                    <i class="fa fa-@yield('grand_icon')"></i>
                                </span> @yield('grand_titre')
                            </h3>
                        </div>
                        @if (session('error'))
                            <div class="row">
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="row">
                                <div class="alert alert-succes">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        @yield('contenu')
                        
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    @section('footer')
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"> RAZAFINDRATANDRA Miradomahefa Fitahiana</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">ETU 001905
                                <i class="mdi mdi-user text-danger"></i></span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src=" {{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src=" {{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src=" {{ asset('assets/js/off-canvas.js') }}"></script>
        <script src=" {{ asset('assets/js/misc.js') }}"></script>
        <script src=" {{ asset('assets/js/settings.js') }}"></script>
        <script src=" {{ asset('assets/js/todolist.js') }}"></script>
        <script src=" {{ asset('assets/js/jquery.cookie.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src=" {{ asset('assets/js/dashboard.js') }}"></script>
        <!-- End custom js for this page -->

        <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.js') }}"></script>

    </body>

    </html>
