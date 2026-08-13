<?php
/**
 * Gabarit public.
 *
 * @var string $contenu Corps de la page déjà rendu.
 * Les métadonnées viennent de EA\Core\Vue::meta() posé par le contrôleur.
 */

use EA\Core\Vue;
use EA\Core\Config;

$titre       = (string)Vue::lireMeta('titre', 'EA-SERVICES');
$description = (string)Vue::lireMeta('description', '');
$canonique   = Config::url((string)Vue::lireMeta('canonical', '/'));
/**
 * Aperçu de partage (WhatsApp, Facebook…) : une vraie photo plutôt que le
 * logo seul — un badge carré étiré en aperçu 1200×630 rendait mal, et
 * WhatsApp est le canal de partage n°1 sur ce marché (cf. skill ea-seo).
 * Chaque page/article peut fournir la sienne via meta('image', …).
 */
$image = Config::url((string)Vue::lireMeta('image', '/assets/hero-jour-1920.jpg'));
$robots      = (string)Vue::lireMeta('robots', 'index, follow, max-image-preview:large, max-snippet:-1');
$typeOg      = (string)Vue::lireMeta('og_type', 'website');
$jsonLd      = Vue::lireMeta('json_ld', []);
$cheminActif = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php /* Avant tout rendu : sans cela la page clignote en clair puis bascule. */ ?>
<script>try{if(localStorage.getItem('ea_theme')==='sombre')document.documentElement.setAttribute('data-theme','sombre')}catch(e){}</script>

<title><?= e($titre) ?></title>
<meta name="description" content="<?= e($description) ?>">
<link rel="canonical" href="<?= e($canonique) ?>">
<meta name="robots" content="<?= e($robots) ?>">
<meta name="author" content="EA-SERVICES">
<meta name="theme-color" content="#14274e">

<?php /* Le partage WhatsApp est un canal réel ici : ces balises ne sont pas optionnelles. */ ?>
<meta property="og:site_name" content="EA-SERVICES">
<meta property="og:locale" content="fr_CI">
<meta property="og:type" content="<?= e($typeOg) ?>">
<meta property="og:title" content="<?= e($titre) ?>">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:url" content="<?= e($canonique) ?>">
<meta property="og:image" content="<?= e($image) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($titre) ?>">
<meta name="twitter:description" content="<?= e($description) ?>">
<meta name="twitter:image" content="<?= e($image) ?>">

<link rel="icon" href="/assets/logo-ea-services.jpeg" type="image/jpeg">
<link rel="apple-touch-icon" href="/assets/logo-ea-services.jpeg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap">
<link rel="stylesheet" href="/css/ea.css?v=<?= @filemtime(dirname(__DIR__, 2) . '/public/css/ea.css') ?: 1 ?>">

<?php foreach ((array)$jsonLd as $bloc): ?>
<script type="application/ld+json"><?= json_encode($bloc, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endforeach; ?>
</head>
<body>
<a class="saut-contenu" href="#contenu">Aller au contenu</a>

<?php require dirname(__DIR__) . '/partials/entete.php'; ?>

<main id="contenu"><?= $contenu ?></main>

<?php
require dirname(__DIR__) . '/partials/pied.php';
require dirname(__DIR__) . '/partials/cookies.php';
?>

<a class="flottant" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener"
   aria-label="Discuter sur WhatsApp">
  <?= icone('whatsapp', 'ico ico--lg') ?><span>WhatsApp</span>
</a>

<script src="/js/ea.js" defer></script>
</body>
</html>
