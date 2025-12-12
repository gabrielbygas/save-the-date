<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save The Date - Affiches & Albums Photo de Mariage</title>
    <meta name="description" content="Créez vos affiches, vidéos et albums photo de mariage personnalisés">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fef3c7 100%);
            overflow-x: hidden;
        }
        
        .hero-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            margin: 40px 0;
            animation: fadeIn 0.8s ease-in;
        }
        
        .feature-card {
            border: 0;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.2);
            background: white;
        }
        
        .btn-primary {
            background: #ec4899;
            border: 0;
            padding: 12px 30px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: #be185d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.3);
        }
        
        .section-album {
            background: white;
            padding: 60px 0;
            margin: 40px 0;
            border-radius: 20px;
        }
        
        .icon-check {
            color: #10b981;
            margin-right: 10px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .slide-up { animation: slideUp 0.6s ease-out; }
    </style>
</head>
<body>
    <!-- Navigation -->
    @include('partials.header')
    
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="text-center slide-up">
                    <h1 class="display-4 fw-bold mb-4">Créez vos affiches & vidéos de mariage 💍</h1>
                    <p class="lead mb-5 text-muted">Designs uniques avec livraison en <strong>72h max</strong></p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5 class="fw-bold mb-3">1️⃣ Formulaire</h5>
                                <p class="small text-muted">Choisissez pack & thème</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5 class="fw-bold mb-3">2️⃣ Paiement</h5>
                                <p class="small text-muted">Sécurisé & simple</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5 class="fw-bold mb-3">3️⃣ Livraison</h5>
                                <p class="small text-muted">Par mail & WhatsApp</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('order.create') }}" class="btn btn-primary btn-lg">Commencer</a>
                </div>
            </div>
        </section>
        
        <!-- Album Section -->
        <section class="section-album">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 slide-up" style="animation-delay: 0.2s;">
                        <h2 class="display-6 fw-bold mb-4">Collectez vos souvenirs 📸</h2>
                        <p class="lead mb-4">Album photo avec QR code privé pour vos invités</p>
                        
                        <ul class="list-unstyled">
                            <li class="mb-3"><span class="icon-check">✓</span> QR code privé & sécurisé</li>
                            <li class="mb-3"><span class="icon-check">✓</span> Aucune inscription requise</span></li>
                            <li class="mb-3"><span class="icon-check">✓</span> Photos en haute qualité</li>
                            <li class="mb-3"><span class="icon-check">✓</span> Jusqu'à 300 invités</li>
                        </ul>
                        
                        <a href="{{ route('photos.home') }}" class="btn btn-primary mt-4">Créer album</a>
                    </div>
                    <div class="col-lg-6 slide-up" style="animation-delay: 0.4s;">
                        <div class="bg-light p-5 rounded-lg text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center;">
                            <p class="text-muted">📱 Exemple QR Code</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
