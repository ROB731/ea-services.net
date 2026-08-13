<?php
declare(strict_types=1);

/**
 * Correction du contenu des six articles hérités (2026-08-06).
 *
 * Ce que contenaient les articles, publié en production :
 *   · deux faux numéros de téléphone (+225 01 01 01 01 01 et
 *     +225 01 53 53 53 53) — un prospect qui les composait tombait dans le vide
 *   · un mauvais domaine, `ea-services.ci`, alors que le site est `.net`
 *   · un code promotionnel « EAREDU2026 » promettant 20 % de réduction, dans
 *     les six articles : un engagement commercial qui n'existe pas
 *   · le sigle « SFB », désigné tantôt « Smart Finder for Business », tantôt
 *     « Smart Finder B2B » — incohérent, et incompréhensible pour un lecteur
 *
 * Chaque dernier bloc promotionnel est remplacé par une clôture propre :
 * un bénéfice, puis l'appel à l'action unique du site. Aucun numéro n'est
 * réécrit dans le texte — les coordonnées vivent dans config/site.php et
 * s'affichent sous l'article, elles ne se recopient pas dans le contenu.
 *
 * Rejouable : le script ne remplace un bloc que s'il contient encore un des
 * motifs fautifs.
 *
 *   /opt/lampp/bin/php src/correction-articles.php
 */

require __DIR__ . '/bootstrap.php';

use EA\Core\Database;

/** Clôture de remplacement, par slug. Chaque texte se rattache à un des cinq gains. */
$clotures = [
    'agence-web-cote-d-ivoire-comment-choisir-la-bonne-agence-pour-votre-pme-a-abidja' =>
        "Le vrai critère pour choisir une agence n'est pas son tarif ni son portfolio : c'est sa "
      . "capacité à vous dire, chiffres à l'appui, ce que le projet va vous rapporter. Si personne "
      . "ne vous parle de résultat mesurable, méfiez-vous.\n\n"
      . "Chez EA-SERVICES, nous commençons toujours par un diagnostic gratuit de 30 minutes : nous "
      . "regardons combien de demandes vous perdez faute d'être visible, et nous chiffrons ce que "
      . "vous récupéreriez. Sans engagement, et sans rien vous vendre pendant l'échange.",

    'creation-de-site-web-ia-ce-que-ca-change-vraiment-pour-une-pme-ivoirienne' =>
        "Un site n'est pas une dépense de communication, c'est un investissement : il doit vous "
      . "amener des demandes que vous n'auriez pas eues autrement. S'il ne le fait pas, le problème "
      . "n'est pas la technologie employée.\n\n"
      . "Réservez un diagnostic gratuit de 30 minutes : nous estimons ensemble le nombre de clients "
      . "que votre absence de visibilité vous coûte chaque mois, et ce qu'un site bien conçu vous "
      . "ferait gagner.",

    'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider' =>
        "Retenez le principe plutôt que la technique : l'intérêt n'est pas d'avoir un outil "
      . "intelligent, c'est qu'aucune demande client ne reste sans réponse, même la nuit et le "
      . "dimanche. Un prospect qui attend plus de cinq minutes appelle votre concurrent.\n\n"
      . "Réservez un diagnostic gratuit de 30 minutes : nous comptons ensemble les demandes que "
      . "vous laissez passer aujourd'hui, et ce que représenterait une réponse en moins de deux "
      . "minutes.",

    'chatbot-whatsapp-business-comment-ca-marche-et-pourquoi-l-adopter-pour-votre-pme' =>
        "L'enjeu n'est pas d'installer un outil de plus : c'est que chaque client qui vous écrit "
      . "obtienne une réponse tout de suite, et que vous ne receviez que les demandes qui méritent "
      . "votre temps.\n\n"
      . "Réservez un diagnostic gratuit de 30 minutes : nous regardons vos échanges d'une semaine "
      . "type, nous repérons ce qui peut être répondu automatiquement, et nous chiffrons le temps "
      . "que vous récupérez.",

    'envoi-colis-abidjan-les-solutions-rapides-et-fiables-pour-livrer-en-ville' =>
        "Si vous expédiez plusieurs colis par semaine, le coût réel n'est pas le prix de la course : "
      . "c'est le temps passé à choisir un coursier, à suivre l'envoi et à rassurer le client qui "
      . "attend.\n\n"
      . "Réservez un diagnostic gratuit de 30 minutes : nous calculons ensemble les heures que vos "
      . "envois vous prennent chaque mois, et ce que vous récupéreriez en organisant le suivi.",

    'comment-trouver-un-emploi-a-abidjan-conseils-pratiques-et-outils-pour-2026' =>
        "Une dernière chose, valable pour toute recherche : la régularité bat l'intensité. Mieux "
      . "vaut cinq candidatures ciblées par semaine, suivies et relancées, que cinquante envoyées "
      . "en un jour puis oubliées.\n\n"
      . "Si vous recrutez de votre côté, EA-SERVICES accompagne les entreprises et les cabinets qui "
      . "veulent traiter plus de postes sans y passer leurs soirées. Diagnostic gratuit de "
      . "30 minutes, sans engagement.",
];

/** Corrections ponctuelles dans le corps, hors bloc de clôture. */
$remplacements = [
    // Terme technique inutile : le lecteur n'a pas besoin de savoir que c'est
    // une « API ». Le titre et le slug de l'article, eux, ne changent PAS —
    // ils sont indexés.
    "L’outil utilise l’API WhatsApp Business, qui est la version professionnelle de l’application, plus stable et plus riche en fonctionnalités que le simple WhatsApp personnel."
      => "Il s'appuie sur la version professionnelle de WhatsApp, plus stable et plus complète que l'application personnelle.",
    "L'outil utilise l'API WhatsApp Business, qui est la version professionnelle de l'application, plus stable et plus riche en fonctionnalités que le simple WhatsApp personnel."
      => "Il s'appuie sur la version professionnelle de WhatsApp, plus stable et plus complète que l'application personnelle.",
];

const FAUTIFS = '/SFB|EAREDU|réduction de 20|20 ?% de réduction|ea-services\.ci|01 01 01 01 01|01 53 53 53 53/u';

$pdo = Database::pdo();
$pdo->beginTransaction();
$journal = [];

foreach (Database::tous('SELECT id, slug, content, image_url FROM articles ORDER BY id') as $a) {
    $contenu = str_replace("\r\n", "\n", (string)$a['content']);
    $avant   = $contenu;

    foreach ($remplacements as $cherche => $remplace) {
        $contenu = str_replace($cherche, $remplace, $contenu);
    }

    $blocs = preg_split("/\n{2,}/", trim($contenu)) ?: [];
    $cloture = $clotures[$a['slug']] ?? null;

    if ($cloture !== null) {
        // Remplace les blocs fautifs de fin ; s'il n'y en a plus, on n'ajoute rien.
        $restants = [];
        $retires  = 0;
        foreach ($blocs as $bloc) {
            if (preg_match(FAUTIFS, $bloc)) { $retires++; continue; }
            $restants[] = $bloc;
        }
        if ($retires > 0) {
            $restants[] = $cloture;
            $blocs = $restants;
            $journal[] = "#{$a['id']} {$a['slug']} : $retires bloc(s) promotionnel(s) remplacé(s)";
        }
    }

    $contenu = implode("\n\n", $blocs);

    // Les illustrations sont retirées : c'étaient des photos de banque d'images
    // sans rapport (une baie de serveurs pour un article sur la livraison de
    // colis, des billets de dollars pour un article sur le marché ivoirien),
    // en 600 px affichées sur 1200. Mieux vaut aucune image qu'une image qui
    // raconte le contraire du texte. Emplacement réservé aux vraies photos.
    $image = null;

    if ($contenu !== $avant || $a['image_url'] !== null) {
        Database::executer(
            'UPDATE articles SET content = ?, image_url = ?, read_time = ? WHERE id = ?',
            [$contenu, $image, \EA\Core\Texte::dureeLecture($contenu), (int)$a['id']]
        );
    }
}

$pdo->commit();

echo "Correction des articles terminée.\n";
foreach ($journal as $l) echo "  · $l\n";

echo "\nContrôle après correction :\n";
$reste = 0;
foreach (Database::tous('SELECT id, slug, content, image_url FROM articles') as $a) {
    if (preg_match_all(FAUTIFS, (string)$a['content'], $m)) {
        $reste++;
        echo "  RESTE #{$a['id']} : " . implode(', ', array_unique($m[0])) . "\n";
    }
    if ($a['image_url'] !== null) echo "  IMAGE #{$a['id']} : {$a['image_url']}\n";
}
if ($reste === 0) echo "  aucun faux numéro, aucun mauvais domaine, aucun code promotionnel, aucun sigle.\n";
