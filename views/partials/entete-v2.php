<?php
/** En-tête v2. La navigation reste celle de config/site.php : les pages
 *  Services et Solutions restent atteignables — la maquette React les avait
 *  fait disparaître au profit d'ancres, et l'offre n'était plus lisible.
 *  @var string $cheminActif */
$liens = (array)cfg('navigation', []);
?>
<header class="entete">
  <div class="page-large">
    <div class="entete__barre">

      <a class="marque" href="/" aria-label="EA-SERVICES, accueil">
        <img src="/assets/logo-ea-services.jpeg" width="36" height="36" alt="" fetchpriority="high">
        <span>
          <span class="marque__nom">EA-SERVICES</span>
          <span class="marque__ligne">Résultats mesurables</span>
        </span>
      </a>

      <nav class="nav__liens" aria-label="Navigation principale">
        <?php foreach ($liens as $lien): ?>
          <a href="<?= e($lien['url']) ?>"<?= $cheminActif === $lien['url'] ? ' aria-current="page"' : '' ?>><?= e($lien['libelle']) ?></a>
        <?php endforeach; ?>
      </nav>

      <button type="button" class="bouton-icone" data-action="theme" aria-label="Changer de thème">
        <?= icone('lune') ?>
      </button>

      <a class="bouton bouton--safran" href="/diagnostic"><?= e(cfg('cta.libelle')) ?></a>

      <button type="button" class="bouton-icone nav__bascule" data-action="menu"
              aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="menu-mobile">
        <?= icone('menu') ?>
      </button>
    </div>

    <nav id="menu-mobile" class="nav__panneau" data-ouvert="non" aria-label="Navigation mobile">
      <?php foreach ($liens as $lien): ?>
        <a href="<?= e($lien['url']) ?>"<?= $cheminActif === $lien['url'] ? ' aria-current="page"' : '' ?>><?= e($lien['libelle']) ?></a>
      <?php endforeach; ?>
      <a href="/diagnostic" class="bouton bouton--safran bouton--large"><?= e(cfg('cta.libelle')) ?></a>
    </nav>
  </div>
</header>
