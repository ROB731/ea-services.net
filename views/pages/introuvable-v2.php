<?php
/**
 * 404 / 410 — direction v2.
 *
 * Une page d'erreur qui ne propose rien perd le visiteur. Celle-ci le
 * ramène vers les pages qui convertissent.
 *
 * @var array $articles
 * @var bool|null $disparue
 */
?>

<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index"><?= !empty($disparue) ? 'Page supprimée' : 'Page introuvable' ?></span>
      <span class="etiquette-section__texte">Elle a peut-être été déplacée lors de la refonte du site</span>
    </p>
    <h1 class="mesure">
      <?= !empty($disparue) ? "Cette adresse n'existe plus." : "Nous n'avons pas trouvé cette page." ?>
    </h1>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Voici par où continuer.
    </p>
    <div style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:.75rem">
      <a class="bouton bouton--safran" href="/">Retour à l'accueil</a>
      <a class="bouton bouton--contour-clair" href="/diagnostic">Réserver mon diagnostic</a>
    </div>
  </div>
</section>

<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Par où continuer</span>
      <span class="etiquette-section__texte">Les pages les plus consultées</span>
    </p>
    <h2 class="mesure">Trois points d'entrée.</h2>

    <div class="grille grille--3">
      <a class="carte" href="/pages/services" style="text-decoration:none;color:inherit">
        <h3><?= icone('cible', 'ico ico--lg') ?> Nos services</h3>
        <p class="doux">Les cinq pertes que nous traitons, avec le gain chiffré en face.</p>
      </a>
      <a class="carte" href="/pages/prestations" style="text-decoration:none;color:inherit">
        <h3><?= icone('croissance', 'ico ico--lg') ?> Nos prestations</h3>
        <p class="doux">Site web, automatisation, formation — ce qu'il y a concrètement dans la boîte à outils.</p>
      </a>
      <a class="carte" href="/pages/realisations" style="text-decoration:none;color:inherit">
        <h3><?= icone('document', 'ico ico--lg') ?> Nos réalisations</h3>
        <p class="doux">Trois cas réels avec les chiffres avant et après.</p>
      </a>
    </div>

    <?php if (!empty($articles)): ?>
      <p class="etiquette-section" style="margin-top:2.5rem">
        <span class="etiquette-section__index">À lire</span>
        <span class="etiquette-section__texte">Nos derniers articles</span>
      </p>
      <div class="grille grille--3">
        <?php foreach ($articles as $a): ?>
          <article class="carte">
            <?php if (!empty($a['image_url'])): ?>
              <img src="<?= e($a['image_url']) ?>" alt=""
                   style="border-radius:var(--arrondi-lg);margin-bottom:1rem;width:100%;aspect-ratio:16/9;object-fit:cover"
                   loading="lazy" decoding="async" width="600" height="338">
            <?php endif; ?>
            <span class="chapeau"><?= e($a['category_label'] ?? '') ?></span>
            <h3><a href="/article/<?= e($a['slug']) ?>" style="text-decoration:none"><?= e($a['title']) ?></a></h3>
            <p class="doux" style="font-size:.9375rem"><?= e($a['excerpt'] ?? '') ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
