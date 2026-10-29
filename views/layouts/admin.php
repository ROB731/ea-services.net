<?php
/** Gabarit de l'administration.
 *  @var string $contenu
 *  @var string $onglet */

use EA\Core\Auth;

// Sans cette version dans l'URL, un navigateur qui a déjà mis admin.js en
// cache ne voit jamais une mise à jour du script tant que le cache n'expire
// pas — un bouton ajouté récemment peut alors paraître « ne pas fonctionner »
// alors que c'est l'ancien fichier qui tourne encore. ea.css suit déjà cette
// règle depuis le début ; ea.js et admin.js l'avaient oubliée.
$versionEaJs    = @filemtime(dirname(__DIR__, 2) . '/public/js/ea.js') ?: 1;
$versionAdminJs = @filemtime(dirname(__DIR__, 2) . '/public/js/admin.js') ?: 1;

$onglets = [
    'tableau'      => ['/admin', 'Tableau de bord'],
    'demandes'     => ['/admin/demandes', 'Demandes'],
    'articles'     => ['/admin/articles', 'Articles'],
    'commentaires' => ['/admin/commentaires', 'Commentaires'],
    'temoignages'  => ['/admin/temoignages', 'Témoignages'],
    'audience'     => ['/admin/audience', 'Audience'],
];
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<script>try{if(localStorage.getItem('ea_theme')==='sombre')document.documentElement.setAttribute('data-theme','sombre')}catch(e){}</script>
<title>Administration — EA-SERVICES</title>
<link rel="icon" href="/assets/logo-ea-services.jpeg" type="image/jpeg">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="/css/ea.css?v=<?= @filemtime(dirname(__DIR__, 2) . '/public/css/ea.css') ?: 1 ?>">
</head>
<body>
<div class="contenant">

  <div class="admin__entete">
    <div class="rangee">
      <img src="/assets/logo-ea-services.jpeg" width="36" height="36" alt="" style="border-radius:50%">
      <strong>Administration EA-SERVICES</strong>
    </div>
    <div class="rangee">
      <button type="button" class="icone-bouton" data-action="theme" aria-label="Changer de thème">
        <?= icone('lune') ?>
      </button>
      <a class="bouton bouton--contour" href="/" target="_blank" rel="noopener">Voir le site</a>
      <a class="bouton bouton--contour" href="/admin/deconnexion"><?= icone('deconnexion') ?> Quitter</a>
    </div>
  </div>

  <nav class="admin__onglets" style="margin-block:1rem" aria-label="Sections">
    <?php foreach ($onglets as $cle => [$url, $libelle]): ?>
      <a href="<?= e($url) ?>"<?= ($onglet ?? '') === $cle ? ' aria-current="page"' : '' ?>><?= e($libelle) ?></a>
    <?php endforeach; ?>
  </nav>

  <main class="admin" style="padding-bottom:4rem"><?= $contenu ?></main>
</div>
<script src="/js/ea.js?v=<?= $versionEaJs ?>" defer></script>
<script src="/js/admin.js?v=<?= $versionAdminJs ?>" defer></script>
</body>
</html>
