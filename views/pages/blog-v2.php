<?php
/**
 * Blog — direction v2.
 *
 * Séparée de /pages/realisations (cas clients chiffrés) : ici, seulement les
 * articles. Même gabarit de carte que celles utilisées sur l'accueil pour
 * les trois derniers articles, pour que cette page ait l'air de faire partie
 * du même site plutôt que d'un gabarit différent.
 *
 * @var array $articles
 */
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Blog</span>
      <span class="etiquette-section__texte">Ce que les entreprises ivoiriennes cherchent vraiment</span>
    </p>
    <h1 class="mesure titre-machine">Des analyses,<em>pas des promesses.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Automatisation, IA &amp; développement web — le blog d'EA-SERVICES</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Écrits à partir de vraies recherches Google, pas de ce qui nous arrange.
      Pour nos résultats chiffrés plutôt que nos articles, direction
      <a href="/pages/realisations" style="color:inherit">nos réalisations</a>.
    </p>
  </div>
</section>

<?php /* --------------------------------------------------------- Articles */ ?>
<section class="section section--claire">
  <div class="page-large">
    <?php if ($articles): ?>
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
            <p class="doux" style="font-size:.8125rem;margin-top:1rem">
              <?= e(dateFr($a['created_at'] ?? null)) ?>
              <?php if (!empty($a['read_time'])): ?> · <?= e($a['read_time']) ?> de lecture<?php endif; ?>
            </p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="doux">Le premier article arrive bientôt.</p>
    <?php endif; ?>
  </div>
</section>

<?php /* ------------------------------------------------------ Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Cet article décrit<span class="suite">un problème que vous vivez peut-être.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes suffisent pour savoir ce qu'il vous coûte réellement, et
        par quoi commencer. Gratuit, sans engagement.
      </p>
    </div>
    <div class="diagnostic__actions">
      <a class="bouton bouton--safran" href="/diagnostic">
        <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
        <?= icone('whatsapp') ?> Écrire sur WhatsApp
      </a>
      <span class="diagnostic__note"><?= e(cfg('cta.promesse')) ?></span>
    </div>
  </div>
</section>
