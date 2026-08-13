<?php
/** Vignette d'article, réutilisée sur l'accueil et la page Résultats.
 *  @var array $a Article (title, slug, excerpt, category_label, image_url, read_time, created_at) */
?>
<article class="carte vignette">
  <?php if (!empty($a['image_url'])): ?>
    <img src="<?= e($a['image_url']) ?>" alt="" loading="lazy" decoding="async" width="600" height="338">
  <?php endif; ?>
  <div class="vignette__corps">
    <span class="etiquette"><?= e($a['category_label'] ?? '') ?></span>
    <h3><a href="/article/<?= e($a['slug']) ?>"><?= e($a['title']) ?></a></h3>
    <p class="doux" style="font-size:.9375rem"><?= e($a['excerpt'] ?? '') ?></p>
    <p class="vignette__meta">
      <?= e(dateFr($a['created_at'] ?? null)) ?>
      <?php if (!empty($a['read_time'])): ?> · <?= e($a['read_time']) ?> de lecture<?php endif; ?>
    </p>
  </div>
</article>
