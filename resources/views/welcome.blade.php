<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save The Date - Affiches & Albums Photo de Mariage</title>
    <meta name="description" content="Créez vos affiches, vidéos et albums photo de mariage personnalisés">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%);
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
        }
        
        nav a:hover {
            opacity: 0.7;
        }
        
        .hero {
            max-width: 900px;
            margin: 60px auto 40px;
            padding: 0 20px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 18px;
            color: #666;
            margin-bottom: 32px;
            line-height: 1.5;
        }
        
        .hero-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #0a84ff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0070d2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(10, 132, 255, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: #0a84ff;
            border: 1px solid #e0e0e0;
        }
        
        .btn-secondary:hover {
            background: #fafafa;
            border-color: #0a84ff;
        }
        
        .features {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        
        .feature-card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }
        
        .feature-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .feature-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .section {
            max-width: 1200px;
            margin: 100px auto;
            padding: 0 20px;
        }
        
        .section-title {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 48px;
            text-align: center;
        }
        
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .section h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 24px;
            line-height: 1.3;
        }
        
        .section p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .benefits {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 32px 0;
        }
        
        .benefit {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        
        .benefit-check {
            color: #34c759;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .benefit-text {
            color: #666;
            font-size: 15px;
        }
        
        .mockup {
            background: #f5f7fa;
            border-radius: 16px;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        
        footer {
            background: white;
            border-top: 1px solid #f0f0f0;
            padding: 40px 20px;
            text-align: center;
            margin-top: 100px;
            color: #666;
            font-size: 14px;
        }
        
        footer a {
            color: #0a84ff;
            text-decoration: none;
        }
        
        footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 16px; }
            .hero-buttons { flex-direction: column; }
            .two-col { grid-template-columns: 1fr; gap: 40px; }
            .section-title { font-size: 28px; }
            .section h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-content">
            <a href="{{ route('home') }}" class="logo">💍 Save The Date</a>
            <a href="{{ route('order.create') }}">Créer une commande</a>
        </div>
    </nav>
    
    <!-- Hero -->
    <div class="hero">
        <h1>Créez vos affiches & vidéos de mariage</h1>
        <p>Designs uniques avec livraison en 72h max</p>
        <div class="hero-buttons">
            <a href="{{ route('order.create') }}" class="btn btn-primary">Commander</a>
            <a href="#albums" class="btn btn-secondary">En savoir plus</a>
        </div>
    </div>
    
    <!-- Features -->
    <div class="features">
        <div class="feature-card">
            <div class="feature-icon">✏️</div>
            <h3>Remplissez le formulaire</h3>
            <p>Choisissez un pack, un thème et envoyez vos informations</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💳</div>
            <h3>Paiement sécurisé</h3>
            <p>Processus rapide et simple par WhatsApp</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🚀</div>
            <h3>Livraison rapide</h3>
            <p>Vos fichiers vous seront livrés dans les délais impartis</p>
        </div>
    </div>
    
    <!-- Albums Section -->
    <div class="section" id="albums">
        <h2 class="section-title">Collectez vos souvenirs</h2>
        <div class="two-col">
            <div>
                <h2>Album photo avec QR code</h2>
                <p>Créez un album privé pour vos invités. Partagez via QR code et collectez tous vos souvenirs en un seul endroit.</p>
                
                <div class="benefits">
                    <div class="benefit">
                        <div class="benefit-check">✓</div>
                        <div class="benefit-text">QR code privé et sécurisé</div>
                    </div>
                    <div class="benefit">
                        <div class="benefit-check">✓</div>
                        <div class="benefit-text">Aucune inscription requise pour vos invités</div>
                    </div>
                    <div class="benefit">
                        <div class="benefit-check">✓</div>
                        <div class="benefit-text">Photos en haute qualité</div>
                    </div>
                    <div class="benefit">
                        <div class="benefit-check">✓</div>
                        <div class="benefit-text">Jusqu'à 300 invités</div>
                    </div>
                </div>
                
                <a href="{{ route('photos.home') }}" class="btn btn-primary" style="display: inline-block; margin-top: 24px;">Créer mon album</a>
            </div>
            
            <div class="mockup">
                <span>📱 Exemple QR Code</span>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <p><strong>💍 Save The Date</strong> • Créez vos souvenirs de mariage</p>
        <p style="margin-top: 12px; font-size: 13px;">
            <a href="{{ route('terms') }}">Conditions</a> • 
            <a href="mailto:contact@savethedate.com">Contact</a>
        </p>
        <p style="margin-top: 16px; border-top: 1px solid #f0f0f0; padding-top: 16px;">
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés.
        </p>
    </footer>
</body>
</html>
