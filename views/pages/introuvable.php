<?php
/**
 * 404 / 410.
 *
 * Une page d'erreur qui ne propose rien perd le visiteur. Celle-ci le
 * ramène vers les trois pages qui convertissent.
 *
 * @var array $articles
 * @var bool|null $disparue
 */
?>
<section class="hero">
  <div class="contenant">
    <p class="sur-titre"><?= !empty($disparue) ? 'Page supprimée' : 'Page introuvable' ?></p>
    <h1 class="mesure">
      <?= !empty($disparue) ? "Cette adresse n'existe plus" : "Nous n'avons pas trouvé cette page" ?>
    </h1>
    <p class="chapo mesure">
      Elle a peut-être été déplacée lors de la refonte du site. Voici par où
      continuer.
    </p>
    <div class="rangee" style="margin-top:1.5rem">
      <a class="bouton bouton--or" href="/">Retour à l'accueil</a>
      <a class="bouton bouton--contour" href="/pages/contact"
         style="color:#fff;border-color:rgba(255,255,255,.3)">Nous écrire</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <h2>Les pages les plus consultées</h2>
    <div class="grille" style="margin-top:1.5rem">
      <a class="carte" href="/pages/services" style="text-decoration:none;color:inherit">
        <h3><?= icone('cible', 'ico ico--lg') ?> Nos services</h3>
        <p class="doux">Les cinq pertes que nous traitons, avec le gain chiffré en face.</p>
      </a>
      <a class="carte" href="/pages/produits" style="text-decoration:none;color:inherit">
        <h3><?= icone('croissance', 'ico ico--lg') ?> Nos solutions</h3>
        <p class="doux">Visibilité, prospection, recrutement — et pourquoi les combiner.</p>
      </a>
      <a class="carte" href="/pages/blog" style="text-decoration:none;color:inherit">
        <h3><?= icone('document', 'ico ico--lg') ?> Résultats clients</h3>
        <p class="doux">Trois cas réels avec les chiffres avant et après.</p>
      </a>
    </div>

    <?php if (!empty($articles)): ?>
      <h2 style="margin-top:2.5rem">Derniers articles</h2>
      <div class="grille" style="margin-top:1.5rem">
        <?php foreach ($articles as $a): ?>
          <?php require dirname(__DIR__) . '/blog/vignette.php'; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
