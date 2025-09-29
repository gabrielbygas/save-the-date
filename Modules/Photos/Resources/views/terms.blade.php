<!-- resources/views/terms.blade.php -->

@extends('photos::layouts.app')

@section('title', 'Conditions Générales d\'Utilisation')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-xl mt-8 px-6">
        <div id="cgu">
            <h1 class="text-2xl font-bold mb-4">Conditions Générales d'Utilisation</h1>

            <p class="mb-4 text-gray-600">Dernière mise à jour : Septembre 2025</p>

            <h2 class="text-xl font-semibold mt-6 mb-2">1. Objet</h2>
            <p class="mb-4">
                L'application permet à tout utilisateur de commander la réalisation d'affiches et/ou de vidéos
                personnalisées pour annoncer un mariage. Les présentes conditions encadrent cette commande et
                s'appliquent à tous les utilisateurs en République Démocratique du Congo et en Afrique.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">2. Délais et livraison</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Chaque commande est traitée dans un délai de <strong>24 à 72 heures ouvrables</strong>.</li>
                <li>Les heures ouvrables sont : lundi-vendredi 08h-18h ; samedi 09h-12h ; dimanche non ouvré.</li>
                <li>Le décompte se fait en heures ouvrables effectives (max 72h).</li>
                <li>La livraison se fait par email et par WhatsApp.</li>
                <li>En cas d'événements imprévisibles (coupures internet, troubles civils, etc.), les délais peuvent être
                    revus
                    sans compensation.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">3. Suivi & paiement</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Le suivi s'effectue exclusivement via WhatsApp.</li>
                <li>Un numéro de commande unique est envoyé par mail et/ou WhatsApp.</li>
                <li>Le paiement est à effectuer sous <strong>3 jours ouvrables</strong> suivant la commande, faute de quoi
                    elle
                    sera annulée.</li>
                <li>Le paiement peut se faire par mobile money ou en espèces.</li>
                <li>Le client doit fournir une preuve de paiement (screenshot, reçu).</li>
                <li>Le paiement est validé uniquement après réception et vérification de la preuve.</li>
                <li>Aucun paiement en ligne n’est disponible à ce stade.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">4. Statut de la commande</h2>
            <ul class="list-disc pl-6 mb-4">
                <li><code>pending</code> → commande en attente.</li>
                <li><code>processing</code> → après paiement.</li>
                <li><code>completed</code> → après livraison.</li>
                <li><code>cancelled</code> → en cas de non-paiement ou annulation.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">5. Données et confidentialité</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Suppression automatique des médias <strong>7 jours après la date du mariage</strong>.</li>
                <li>Certaines données peuvent être conservées jusqu'à <strong>1 an</strong> à des fins d'analyse, marketing
                    ou
                    test.</li>
                <li>Aucune donnée n'est partagée avec des tiers.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">6. Contenu et responsabilité</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Le client est responsable des informations et médias fournis.</li>
                <li>Des frais peuvent s'appliquer en cas d'erreurs ou de modifications importantes.</li>
                <li>Aucune responsabilité n’est engagée en cas de données erronées fournies par le client.</li>
                <li>Le client garantit que ses médias sont libres de droits et ne violent pas la loi ni les droits d’auteur.
                </li>
                <li>Tout contenu illégal, inapproprié ou contraire aux bonnes mœurs entraîne une annulation immédiate de la
                    commande, sans remboursement.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">7. Annulation et remboursement</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Commande annulée automatiquement si non payée sous 3 jours ouvrables.</li>
                <li>Aucun remboursement après paiement, sauf si nous ne livrons pas sous 72h ouvrables.</li>
                <li>Un remboursement partiel (max. 75%) peut être accordé au cas par cas.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">8. Propriété intellectuelle</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Toutes les créations sont réalisées par des designers humains (employés ou freelances).</li>
                <li>Nous détenons les droits exclusifs sur toutes les créations fournies.</li>
                <li>Le client dispose uniquement d’un droit d’usage personnel et non commercial.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">9. Acceptation</h2>
            <p class="mb-4">
                En soumettant le formulaire de commande, vous acceptez automatiquement les présentes conditions générales
                d'utilisation.
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">10. Litiges et juridiction</h2>
            <p class="mb-4">
                Tout litige relève exclusivement de la compétence des tribunaux de la République Démocratique du Congo.
            </p>
        </div>

        <hr>

        <div id="privacy">
            <h1 class="text-2xl font-bold mb-4 mt-6">Politique de Confidentialité</h1>
            <p class="mb-4">Cette Politique de Confidentialité explique comment nous collectons, utilisons et protégeons
                vos données
                personnelles lorsque vous utilisez notre service.</p>

            <h2 class="text-xl font-semibold mt-6 mb-2">1. Données collectées</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Nom, email et téléphone (des mariés et des invités).</li>
                <li>Adresse IP, agent utilisateur et logs de connexion.</li>
                <li>Fichiers photos et métadonnées (exif, date, taille).</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">2. Finalité</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Permettre l’upload et la gestion de photos.</li>
                <li>Sécuriser les accès et prévenir les abus.</li>
                <li>Assurer le suivi technique et statistique.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">3. Conservation</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Les photos sont supprimées au plus tard 7 jours après la date du mariage.</li>
                <li>Les données techniques (logs, IP) sont conservées au maximum 12 mois.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">4. Partage des données</h2>
            <ul class="list-disc pl-6 mb-4">
                <li>Nous ne partageons aucune donnée avec des tiers commerciaux.</li>
                <li>Les données peuvent être communiquées uniquement aux autorités judiciaires compétentes en RDC, en cas
                    d’obligation légale.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-6 mb-2">5. Sécurité</h2>
            <p class="mb-4">Nous mettons en place des mesures de sécurité pour protéger vos données (hébergement sécurisé,
                accès
                restreint, suppression automatique).</p>

            <h2 class="text-xl font-semibold mt-6 mb-2">6. Vos droits</h2>
            <p class="mb-4">Conformément au droit congolais, vous pouvez demander l’accès, la rectification ou la
                suppression de vos
                données via l’adresse de contact fournie par les mariés.</p>
        </div>
    </div>
@endsection
