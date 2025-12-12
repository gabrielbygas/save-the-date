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
    
    h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 24px 0 12px;
    }
    
    p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 12px;
        font-size: 15px;
    }
    
    ul {
        margin-left: 20px;
        margin-bottom: 16px;
    }
    
    li {
        color: #666;
        line-height: 1.6;
        margin-bottom: 8px;
        font-size: 15px;
    }
    
    strong {
        color: #1a1a1a;
        font-weight: 600;
    }
    
    code {
        background: #f5f7fa;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: monospace;
        color: #0a84ff;
    }
    
    hr {
        border: none;
        height: 1px;
        background: #f0f0f0;
        margin: 40px 0;
    }
    
    .nav-links {
        margin-bottom: 24px;
    }
    
    .nav-links a {
        color: #0a84ff;
        text-decoration: none;
        margin-right: 20px;
        font-weight: 500;
    }
    
    .nav-links a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .terms-container { padding: 24px; }
        h1 { font-size: 24px; }
    }
</style>

<div class="terms-container">
    <div class="nav-links">
        <a href="#cgu">Conditions d'utilisation</a>
        <a href="#privacy">Politique de confidentialité</a>
    </div>
    
    <div id="cgu">
        <h1>Conditions d'utilisation</h1>
        
        <p><strong>Dernière mise à jour : Septembre 2025</strong></p>
        
        <h2>1. Objet</h2>
        <p>Save The Date RDC est une application conçue pour permettre aux Mariés congolais de commander la réalisation d'affiches et/ou de vidéos, partager les photos de leur mariage avec leurs Invités de manière simple et sécurisée. Les Invités reçoivent un lien unique pour uploader ou consulter les photos, sans besoin de créer un compte. Les présentes conditions encadrent cette commande et s'appliquent à tous les utilisateurs en République Démocratique du Congo et en Afrique.</p>
        <ul>
            <li><strong>"Marié(s)"</strong> : propriétaires de l'album.</li>
            <li><strong>"Invité(s)"</strong> : ceux qui uploadent.</li>
            <li><strong>"Client(s)"</strong> : ceux qui commandent affiche/vidéo.</li>
        </ul>
        
        <h2>2. Délais et livraison</h2>
        <ul>
            <li>Chaque commande est traitée dans un délai de <strong>24 à 72 heures ouvrables</strong>.</li>
            <li>Les heures ouvrables sont : lundi-vendredi 08h-18h ; samedi 09h-12h ; dimanche non ouvré.</li>
            <li>Le décompte se fait en heures ouvrables effectives (max 72h).</li>
            <li>La livraison se fait par email et par WhatsApp.</li>
            <li>En cas d'événements imprévisibles (coupures internet, troubles civils, etc.), les délais peuvent être revus sans compensation.</li>
        </ul>
        
        <h3>2.1 Pour les Propriétaires d'Album</h3>
        <ul>
            <li>Vous êtes responsable de la création et de la gestion de votre album.</li>
            <li>Vous pouvez générer des liens d'upload pour vos Invités.</li>
            <li>Vous garantissez que les photos partagées respectent les lois en vigueur en RDC.</li>
        </ul>
        
        <h3>2.2 Pour les Invités</h3>
        <ul>
            <li>Vous recevez un lien unique par email ou SMS pour uploader ou consulter les photos.</li>
            <li>Vous pouvez uploader jusqu'à <strong>5 photos maximum</strong> par lien.</li>
            <li>Vous ne devez uploader que des photos liées à l'événement (mariage).</li>
        </ul>
        
        <h2>3. Suivi & paiement</h2>
        <ul>
            <li>Le suivi s'effectue exclusivement via WhatsApp.</li>
            <li>Un numéro de commande unique est envoyé par mail et/ou WhatsApp.</li>
            <li>Le paiement est à effectuer sous <strong>3 jours ouvrables</strong> suivant la commande, faute de quoi elle sera annulée.</li>
            <li>Le paiement peut se faire par mobile money ou en espèces.</li>
            <li>Le Client ou Marié doit fournir une preuve de paiement (screenshot, reçu).</li>
            <li>Le paiement est validé uniquement après réception et vérification de la preuve.</li>
            <li>Aucun paiement en ligne n'est disponible à ce stade.</li>
        </ul>
        
        <h2>4. Statut de la commande</h2>
        <ul>
            <li><code>pending</code> → commande en attente.</li>
            <li><code>processing</code> → après paiement.</li>
            <li><code>completed</code> → après livraison.</li>
            <li><code>cancelled</code> → en cas de non-paiement ou annulation.</li>
        </ul>
        
        <h2>5. Données et confidentialité</h2>
        <ul>
            <li>Suppression automatique des médias <strong>7 jours après la date du mariage</strong>.</li>
            <li>Certaines données peuvent être conservées jusqu'à <strong>1 an</strong> à des fins d'analyse, marketing ou test.</li>
            <li>Aucune donnée n'est partagée avec des tiers.</li>
        </ul>
        
        <h2>6. Contenu et responsabilité</h2>
        <ul>
            <li>Le Client (ici Marié ou Invité) est responsable des informations et médias fournis.</li>
            <li>Des frais peuvent s'appliquer en cas d'erreurs ou de modifications importantes.</li>
            <li>Aucune responsabilité n'est engagée en cas de données erronées fournies par le Client (ici Marié ou Invité).</li>
            <li>Le Client (ici Marié ou Invité) garantit que ses médias sont libres de droits et ne violent pas la loi ni les droits d'auteur.</li>
            <li>Tout contenu illégal, inapproprié ou contraire aux bonnes mœurs entraîne une annulation immédiate de la commande, sans remboursement.</li>
            <li>Nous déclinons toutes responsabilités en cas des pertes de données dues à des circonstances indépendantes de notre volonté (ex : panne de serveur).</li>
            <li>Nous déclinons toutes responsabilités en cas d'utilisation(s) frauduleuse(s) des liens d'upload par des tiers.</li>
            <li>Nous déclinons toutes responsabilités en cas du contenu des photos uploadées par les utilisateurs.</li>
        </ul>
        
        <h2>7. Annulation et remboursement</h2>
        <ul>
            <li>Commande annulée automatiquement si non payée sous <strong>3 jours ouvrables.</strong></li>
            <li>Aucun remboursement après paiement, sauf si nous ne livrons pas sous 72h ouvrables.</li>
            <li>Un remboursement partiel (max. 75%) peut être accordé au cas par cas.</li>
        </ul>
        
        <h2>8. Propriété intellectuelle</h2>
        <ul>
            <li>Toutes les créations sont réalisées par des designers humains (employés ou freelances).</li>
            <li>Nous détenons les droits exclusifs sur toutes les créations fournies.</li>
            <li>Le Client (ici Marié ou Invité) dispose uniquement d'un droit d'usage personnel et non commercial.</li>
        </ul>
        
        <h2>9. Modifications des CGU</h2>
        <p>Nous nous réservons le droit de modifier ces CGU à tout moment. Les utilisateurs seront informés des changements majeurs via l'application ou par email.</p>
        
        <h2>10. Acceptation</h2>
        <p>En soumettant le formulaire de commande, vous acceptez automatiquement les présentes conditions générales d'utilisation.</p>
        
        <h2>11. Litiges et juridiction</h2>
        <p>Tout litige relève exclusivement de la compétence des tribunaux de la République Démocratique du Congo.</p>
    </div>
    
    <hr>
    
    <div id="privacy">
        <h1>Politique de Confidentialité</h1>
        <p>Cette Politique de Confidentialité explique comment nous collectons, utilisons et protégeons vos données personnelles lorsque vous utilisez notre service.</p>
        
        <h2>1. Données collectées</h2>
        <ul>
            <li>Nom, email et téléphone (des mariés et des Invités).</li>
            <li>Adresse IP, agent utilisateur et logs de connexion.</li>
            <li>Fichiers photos et métadonnées (exif, date, taille).</li>
        </ul>
        
        <h2>2. Finalité</h2>
        <ul>
            <li>Permettre l'upload et la gestion de photos.</li>
            <li>Sécuriser les accès et prévenir les abus.</li>
            <li>Assurer le suivi technique et statistique.</li>
        </ul>
        
        <h2>3. Conservation</h2>
        <ul>
            <li>Les photos sont supprimées au plus tard 7 jours après la date du mariage.</li>
            <li>Les données techniques (logs, IP) sont conservées au maximum 12 mois.</li>
        </ul>
        
        <h2>4. Partage des données</h2>
        <ul>
            <li>Nous ne partageons aucune donnée avec des tiers commerciaux.</li>
            <li>Les données peuvent être communiquées uniquement aux autorités judiciaires compétentes en RDC, en cas d'obligation légale.</li>
        </ul>
        
        <h2>5. Sécurité</h2>
        <p>Nous mettons en place des mesures de sécurité pour protéger vos données (hébergement sécurisé, accès restreint, suppression automatique).</p>
        
        <h2>6. Vos droits</h2>
        <p>Conformément au droit congolais, vous pouvez demander l'accès, la rectification ou la suppression de vos données via l'adresse de contact fournie par les mariés.</p>
    </div>
</div>
@endsection
