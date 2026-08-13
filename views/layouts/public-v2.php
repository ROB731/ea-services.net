<?php
/**
 * Gabarit public — v2 (prototype de la nouvelle direction artistique).
 *
 * Identique au gabarit en production sur le fond (métadonnées, données
 * structurées, canonical exact), différent sur la forme :
 *   · polices auto-hébergées, préchargées — plus aucun appel à Google
 *   · feuille ea-v2.css
 *
 * @var string $contenu
 */

use EA\Core\Vue;
use EA\Core\Config;

$titre       = (string)Vue::lireMeta('titre', 'EA-SERVICES');
$description = (string)Vue::lireMeta('description', '');
$canonique   = Config::url((string)Vue::lireMeta('canonical', '/'));
$image       = Config::url((string)Vue::lireMeta('image', '/assets/hero-jour-1920.jpg'));
$robots      = (string)Vue::lireMeta('robots', 'index, follow, max-image-preview:large, max-snippet:-1');
$typeOg      = (string)Vue::lireMeta('og_type', 'website');
$jsonLd      = Vue::lireMeta('json_ld', []);
$cheminActif = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$version     = @filemtime(dirname(__DIR__, 2) . '/public/css/ea-v2.css') ?: 1;
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<?php /* Pas de maximum-scale : bloquer le zoom est un défaut d'accessibilité
         réel, et c'est l'un des points relevés sur la maquette React. */ ?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script>try{if(localStorage.getItem('ea_theme')==='sombre')document.documentElement.setAttribute('data-theme','sombre')}catch(e){}</script>

<title><?= e($titre) ?></title>
<meta name="description" content="<?= e($description) ?>">
<link rel="canonical" href="<?= e($canonique) ?>">
<meta name="robots" content="<?= e($robots) ?>">
<meta name="author" content="EA-SERVICES">
<meta name="theme-color" content="#112849">

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

<?php /* Préchargées : la police des titres est le premier pixel qui compte. */ ?>
<link rel="preload" href="/fonts/space-grotesk.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/fonts/dm-sans.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="/css/ea-v2.css?v=<?= $version ?>">

<?php foreach ((array)$jsonLd as $bloc): ?>
<script type="application/ld+json"><?= json_encode($bloc, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endforeach; ?>
</head>
<body>
<a class="saut-contenu" href="#contenu">Aller au contenu</a>

<?php require dirname(__DIR__) . '/partials/entete-v2.php'; ?>

<main id="contenu"><?= $contenu ?></main>

<?php
require dirname(__DIR__) . '/partials/pied-v2.php';
require dirname(__DIR__) . '/partials/cookies.php';
?>

<a class="flottant" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener"
   aria-label="Discuter sur WhatsApp">
  <?= icone('whatsapp', 'ico ico--lg') ?><span>WhatsApp</span>
</a>

<script src="/js/ea-v2.js" defer></script>
</body>
</html>
