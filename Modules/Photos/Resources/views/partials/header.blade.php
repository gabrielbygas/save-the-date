<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-info" href="{{ route('photos.home') }}">📸 Albums</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('albums.login') }}">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('albums.create') }}">Créer album</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
