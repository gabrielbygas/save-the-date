<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Albums Photo')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body { height: 100%; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #fff5f8 0%, #ffebf0 100%);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        nav {
            background: white;
            box-shadow: 0 1px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        nav .logo {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
        }
        
        nav a {
            color: #ec407a;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: opacity 0.2s ease;
            margin-left: 24px;
        }
        
        nav a:hover {
            opacity: 0.7;
        }
        
        main {
            padding: 40px 20px;
            flex: 1;
        }
        
        main .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        footer {
            background: white;
            border-top: 1px solid #f0f0f0;
            padding: 40px 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        footer p {
            margin-bottom: 12px;
        }
        
        footer a {
            color: #ec407a;
            text-decoration: none;
        }
        
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="{{ route('photos.home') }}" class="logo">📸 Albums Photo</a>
            <div>
                <a href="{{ route('albums.login') }}">Se connecter</a>
                <a href="{{ route('albums.create') }}">Créer album</a>
            </div>
        </div>
    </nav>
    
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <footer>
        <p><strong>📸 Albums Photo</strong> • Partagez vos souvenirs de mariage</p>
        <p style="font-size: 13px;">
            <a href="{{ route('terms') }}">Conditions</a> • 
            <a href="mailto:contact@savethedate.com">Contact</a>
        </p>
        <p style="margin-top: 16px; border-top: 1px solid #f0f0f0; padding-top: 16px;">
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés.
        </p>
    </footer>
</body>
</html>
