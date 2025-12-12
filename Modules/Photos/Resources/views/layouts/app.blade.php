<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Albums Photo')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #fce7f3 100%);
        }
        
        .navbar { background: white !important; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        
        .card { border: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
        
        .btn-primary { background: #0ea5e9; border: 0; font-weight: 600; }
        .btn-primary:hover { background: #0284c7; }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            aspect-ratio: 1;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img { transform: scale(1.1); }
        
        .fade-in { animation: fadeIn 0.6s ease-in; }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    
    @yield('styles')
</head>
<body class="fade-in">
    @include('photos::partials.header')
    
    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    @include('photos::partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
