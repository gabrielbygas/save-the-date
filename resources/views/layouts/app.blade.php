<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Save The Date')</title>
    <meta name="description" content="Save The Date - Créez vos affiches & albums photo de mariage">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #ec4899;
            --primary-dark: #be185d;
            --secondary: #64748b;
            --light: #f8f9fa;
            --border: #e2e8f0;
        }
        
        * { font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #fce7f3 0%, #fef3c7 100%);
            min-height: 100vh;
        }
        
        .btn-primary { background: var(--primary); border: 0; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
        
        .card {
            border: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        
        .fade-in { animation: fadeIn 0.6s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .slide-in { animation: slideIn 0.5s ease-out; }
        @keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
    
    @yield('styles')
</head>
<body class="fade-in">
    <!-- Navigation -->
    @include('partials.header')
    
    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Flash Messages -->
    @include('partials.flash-messages')
    
    @yield('scripts')
</body>
</html>
