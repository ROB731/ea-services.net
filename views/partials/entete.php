<?php
/** En-tête : marque, navigation, bascule de thème, appel à l'action.
 *  @var string $cheminActif */
$liens = (array)cfg('navigation', []);
?>
<header class="entete">
  <div class="contenant">
    <div class="entete__barre">

      <a class="marque" href="/" aria-label="EA-SERVICES, accueil">
        <img src="/assets/logo-ea-services.jpeg" width="40" height="40"
             alt="Logo EA-SERVICES" fetchpriority="high">
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

      <button type="button" class="icone-bouton" data-action="theme" aria-label="Changer de thème">
        <?= icone('lune') ?>
      </button>

      <a class="bouton bouton--or" href="/pages/contact"><?= e(cfg('cta.libelle')) ?></a>

      <button type="button" class="icone-bouton nav__bascule" data-action="menu"
              aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="menu-mobile">
        <?= icone('menu') ?>
      </button>
    </div>

    <nav id="menu-mobile" class="nav__panneau" data-ouvert="non" aria-label="Navigation mobile">
      <?php foreach ($liens as $lien): ?>
        <a href="<?= e($lien['url']) ?>"<?= $cheminActif === $lien['url'] ? ' aria-current="page"' : '' ?>><?= e($lien['libelle']) ?></a>
      <?php endforeach; ?>
      <a href="/pages/contact" class="bouton bouton--or bouton--large"><?= e(cfg('cta.libelle')) ?></a>
    </nav>
  </div>
</header>
