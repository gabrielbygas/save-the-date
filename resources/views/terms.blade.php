<!-- resources/views/terms.blade.php -->

@extends('layouts.app')

@section('title', 'Conditions d\'utilisation')

@section('content')
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-xl mt-8 px-6">
        <h1 class="text-2xl font-bold mb-4">Conditions Générales d'Utilisation</h1>

        <p class="mb-4">Dernière mise à jour : Juillet 2025</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">1. Objet</h2>
        <p class="mb-4">L'application permet à tout utilisateur de commander la réalisation d'affiches et/ou de vidéos
            personnalisées pour annoncer un mariage. Les présentes conditions encadrent cette commande.</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">2. Délais et livraison</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Chaque commande est traitée dans un délai de 24 à 72 heures ouvrables.</li>
            <li>Les heures ouvrables sont : lundi-vendredi 08h-18h ; samedi 09h-12h ; dimanche non ouvré.</li>
            <li>Le décompte se fait en heures ouvrables effectives (max 72h).</li>
            <li>La livraison se fait par email et par WhatsApp.</li>
            <li>En cas d'événements imprévisibles (coupures internet, troubles civils...), les délais peuvent être revus
                sans compensation.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">3. Suivi & paiement</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Le suivi s'effectue exclusivement via WhatsApp.</li>
            <li>Un numéro de commande unique est envoyé par mail et/ou WhatsApp.</li>
            <li>Le paiement est à effectuer sous 3 jours ouvrables suivant la commande, faute de quoi elle sera annulée.</li>
            <li>Le paiement peut se faire par mobile money ou en espèces.</li>
            <li>Le client doit fournir une preuve de paiement (screenshot, reçu).</li>
            <li>Le paiement est considéré comme effectué lorsque la preuve est reçue et validée.</li>
            <li>Aucun paiement en ligne n’est disponible à ce stade.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">4. Statut de la commande</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>"pending" → commande en attente.</li>
            <li>"processing" → après paiement.</li>
            <li>"completed" → après livraison.</li>
            <li>"cancelled" → en cas de non-paiement ou annulation.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">5. Données et confidentialité</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Suppression automatique des médias 7 jours après la date du mariage.</li>
            <li>Certaines données peuvent être conservées jusqu'à 1 an à des fins d'analyse, marketing ou test.</li>
            <li>Aucune donnée n'est partagée avec des tiers.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">6. Contenu et responsabilité</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Le client est responsable des informations fournies.</li>
            <li>Des frais peuvent s'appliquer en cas d'erreurs ou de demandes de modifications importantes.</li>
            <li>Nous déclinons toute responsabilité en cas d'informations erronées fournies.</li>
            <li>Le client garantit que les médias fournis sont libres de droits et ne violent pas les droits d'auteur.</li>
            <li>Le client doit s'assurer que les médias fournis ne contiennent pas de contenu illégal ou inapproprié.</li>
            <li>Nous nous réservons le droit de refuser toute commande jugée inappropriée ou illégale.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">7. Droit d'annulation et remboursement</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Commande annulée automatiquement si non payée sous 3 jours ouvrables.</li>
            <li>Aucun remboursement après paiement, sauf si nous ne livrons pas sous 72h ouvrables.</li>
            <li>Remboursement partiel possible (max. 75%) au cas par cas.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">8. Propriété</h2>
        <ul class="list-disc pl-6 mb-4">
            <li>Toutes les créations sont réalisées par des designers humains (employés ou freelance).</li>
            <li>Nous détenons les droits exclusifs sur toutes les créations fournies.</li>
            <li>Le client obtient un droit d'usage personnel et non commercial.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">9. Acceptation</h2>
        <p class="mb-4">En soumettant le formulaire, vous acceptez automatiquement les présentes conditions d'utilisation.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">10. Litige et juridiction</h2>
        <p class="mb-4">Tout litige relève exclusivement de la compétence des tribunaux de la République Démocratique du
            Congo.</p>
    </div>
@endsection
