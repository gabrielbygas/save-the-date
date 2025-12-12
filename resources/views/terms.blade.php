@extends('layouts.app')

@section('title', 'Conditions d\'utilisation')

@section('content')
<style>
    .terms-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    }
    
    h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 32px;
    }
    
    h2 {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 32px 0 16px;
    }
    
    p, li {
        color: #666;
        line-height: 1.6;
        margin-bottom: 12px;
        font-size: 15px;
    }
    
    ul {
        margin-left: 20px;
        margin-bottom: 16px;
    }
    
    @media (max-width: 768px) {
        .terms-container { padding: 24px; }
        h1 { font-size: 24px; }
    }
</style>

<div class="terms-container">
    <h1>Conditions d'utilisation</h1>
    
    <h2>1. Généralités</h2>
    <p>Save The Date est une plateforme de création d'affiches et d'albums photo de mariage personnalisés. En utilisant notre service, vous acceptez ces conditions d'utilisation.</p>
    
    <h2>2. Commandes</h2>
    <p>Toute commande est définitive après paiement. Les délais de livraison sont indicatifs et peuvent varier selon la complexité du projet.</p>
    
    <h2>3. Propriété intellectuelle</h2>
    <p>Les designs créés par Save The Date restent la propriété de la plateforme. Vous disposez d'une licence d'utilisation personnelle et non commerciale.</p>
    
    <h2>4. Responsabilité</h2>
    <p>Save The Date ne peut être tenu responsable des erreurs dans les informations fournies par le client (noms, dates, etc.).</p>
    
    <h2>5. Confidentialité</h2>
    <p>Vos données personnelles sont protégées et ne seront jamais vendues à des tiers.</p>
    
    <h2>6. Modification des conditions</h2>
    <p>Ces conditions peuvent être modifiées à tout moment. Les changements seront communiqués via la plateforme.</p>
    
    <h2>7. Droit applicable</h2>
    <p>Ces conditions sont régies par la loi française.</p>
</div>
@endsection
