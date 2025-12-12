<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Save The Date')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body { height: 100%; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%);
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
            color: #0a84ff;
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
            color: #0a84ff;
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
            <a href="{{ route('home') }}" class="logo">💍 Save The Date</a>
            <div>
                <a href="{{ route('order.create') }}">Commander</a>
                <a href="{{ route('photos.home') }}">Albums</a>
            </div>
        </div>
    </nav>
    
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <footer>
        <p><strong>💍 Save The Date</strong> • Créez vos souvenirs de mariage</p>
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
