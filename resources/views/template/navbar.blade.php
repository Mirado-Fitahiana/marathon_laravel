<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="index.html"><img src=" {{ asset('assets/images/sary.png') }} "
                alt="logo" style="
                width: auto;
                height: 52px;
            "/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('assets/images/logo-mini.svg')}}"
                alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0"
                        placeholder="recherche">
                </div>
            </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    
                    @if (session()->has('admin'))
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ session('admin')-> nom}}</p>
                    </div>
                    @elseif (session()->has('utilisateur'))  
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ session('utilisateur')-> nom}}</p>
                    </div>
                    @else
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black"> se connecter</p>
                    </div>
                    
                    @endif
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{url('/disconnect')}}">
                        <i class="mdi mdi-logout me-2 text-primary"></i> Se deconnecter</a>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>