@extends('photos::layouts.app')

@section('title', 'Conditions - Albums Photo')

@section('content')
<style>
    .terms-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .terms-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .terms-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }
    
    .terms-header p {
        color: #666;
        font-size: 15px;
    }
    
    .terms-content h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin-top: 32px;
        margin-bottom: 16px;
    }
    
    .terms-content h2:first-of-type {
        margin-top: 0;
    }
    
    .terms-content h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-top: 24px;
        margin-bottom: 12px;
    }
    
    .terms-content p {
        color: #666;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 16px;
    }
    
    .terms-content ul {
        color: #666;
        font-size: 15px;
        line-height: 1.7;
        margin-left: 24px;
        margin-bottom: 16px;
    }
    
    .terms-content li {
        margin-bottom: 8px;
    }
    
    .terms-content strong {
        color: #1a1a1a;
        font-weight: 600;
    }
    
    .highlight-box {
        background: #f0ebff;
        border-left: 4px solid #ec407a;
        border-radius: 8px;
        padding: 20px;
        margin: 24px 0;
        font-size: 14px;
        color: #1a1a1a;
        line-height: 1.6;
    }
    
    .btn-back {
        display: inline-block;
        margin-top: 32px;
        padding: 12px 24px;
        background: #ec407a;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-back:hover {
        background: #d81b60;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    @media (max-width: 768px) {
        .terms-container { padding: 30px 20px; }
        .terms-header h1 { font-size: 24px; }
        .terms-content h2 { font-size: 18px; }
    }
</style>

<div class="terms-container">
    <div class="terms-header">
        <h1>📋 Conditions d'utilisation</h1>
        <p>Albums Photo - Save The Date</p>
    </div>
    
    <div class="terms-content">
        <h2>1. Objet du service</h2>
        <p>Albums Photo est une plateforme permettant aux couples de créer des albums numériques pour partager et collecter des photos de leurs événements (mariages, fiançailles, etc.).</p>
        
        <h2>2. Utilisation du service</h2>
        <p>En utilisant ce service, vous acceptez de respecter les lois et réglementations applicables. Vous êtes responsable de l'utilisation de votre compte et du contenu que vous téléchargez.</p>
        
        <h3>Vous acceptez de ne pas :</h3>
        <ul>
            <li>Télécharger du contenu illégal, offensant ou contraire aux droits d'autrui</li>
            <li>Partager le lien d'invitation avec des tiers non autorisés</li>
            <li>Utiliser le service à des fins commerciales sans autorisation</li>
            <li>Tenter de contourner les mesures de sécurité</li>
        </ul>
        
        <h2>3. Propriété intellectuelle</h2>
        <p>Vous conservez tous les droits sur les photos que vous téléchargez. En les partageant via Albums Photo, vous accordez à la plateforme le droit d'héberger et d'afficher ces contenus.</p>
        
        <h2>4. Sécurité et confidentialité</h2>
        <p>Vos données personnelles sont protégées conformément à notre politique de confidentialité. Nous utilisons le chiffrement et les meilleures pratiques de sécurité pour protéger vos informations.</p>
        
        <div class="highlight-box">
            <strong>⚠️ Important :</strong> Les albums sont conservés selon la durée définie lors de la création. Passé ce délai, les photos peuvent être supprimées définitivement.
        </div>
        
        <h2>5. Limite de responsabilité</h2>
        <p>Albums Photo fournit le service « tel quel ». Nous ne sommes pas responsables des pertes de données, interruptions de service ou dommages indirects.</p>
        
        <h2>6. Suppression de compte</h2>
        <p>Vous pouvez demander la suppression de votre compte à tout moment. Les données seront supprimées conformément à la loi applicable.</p>
        
        <h2>7. Modifications des conditions</h2>
        <p>Nous nous réservons le droit de modifier ces conditions à tout moment. Les modifications seront communiquées via l'email enregistré.</p>
        
        <h2>8. Contact</h2>
        <p>Pour toute question concernant ces conditions, veuillez nous contacter à <strong>contact@savethedate.com</strong></p>
        
        <a href="{{ route('photos.home') }}" class="btn-back">← Retour</a>
    </div>
</div>
@endsection
