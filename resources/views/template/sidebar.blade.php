<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        
        @if (session('utilisateur'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/acceuil') }}">
                <span class="menu-title">Resultat par Equipe</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/liste_etape') }}">
                    <span class="menu-title">Liste des Etapes</span>
                    <i class="mdi mdi-road menu-icon"></i>
                </a>
            </li>
        @elseif (session('admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/resultat_equipe') }}">
                <span class="menu-title">Resultat par Equipe</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/liste_etape_admin') }}">
                    <span class="menu-title">Liste des étapes</span>
                    <i class="mdi mdi-road menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/categorie') }}">
                    <span class="menu-title">Liste des categorie</span>
                    <i class="mdi mdi-leaf menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/penalite') }}">
                  <span class="menu-title">Pénalité</span>
                  <i class="mdi mdi-clock menu-icon"></i>
              </a>
          </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="true"
                    aria-controls="ui-basic">
                    <span class="menu-title">import</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-file menu-icon"></i>
                </a>
                <div class="collapse show" id="ui-basic" style="">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/import_etape_resultat') }}">Import etapes et resultat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/import_points') }}">Import points</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/reinitialiser') }}">
                    <span class="menu-title" style="color: red">REINITIALISER</span>
                    <i class="mdi mdi-close menu-icon"></i>
                </a>
            </li>
        @endif


    </ul>
</nav>
