<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">TTKoding</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="/tasks">Feladatok</a>
            <a class="nav-item nav-link" href="/leaderboard">Ranglista</a>
        </div>
    </div>
    <form id="mindegy" class="form-inline">
        @guest
        <a class="nav-item nav-link" href="/login">Bejelentkezés</a>
        <a class="nav-item nav-link" href="/register">Regisztráció</a>
        @else
        <li class="nav-item dropdown" style="list-style: none;">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/user/{{ Auth::user()->name }}">Profil</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Kijelentkezés
                </a>
            </div>
        </li>
        @endguest
    </form>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> <!-- 2 form miatt külön kell venni -->
        @csrf
    </form>
</nav>