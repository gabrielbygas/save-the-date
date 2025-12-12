<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Save The Date')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        
        .card h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 32px;
        }
        
        .card a {
            display: inline-block;
            margin-top: 8px;
            color: #0a84ff;
            text-decoration: none;
            font-size: 14px;
        }
        
        .card a:hover {
            text-decoration: underline;
        }
        
        footer {
            position: absolute;
            bottom: 20px;
            font-size: 13px;
            color: #999;
            text-align: center;
        }
        
        footer a {
            color: #0a84ff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>💍 Save The Date</h1>
        @yield('content')
    </div>
    
    <footer>
        <a href="{{ route('home') }}">← Accueil</a>
    </footer>
</body>
</html>
