<?php
/**
 * Fond photo pour un bandeau .hero — variante à une seule image, sans
 * fondu (le fondu enchaîné à trois images reste réservé à l'accueil, la
 * première page vue). À inclure juste après l'ouverture de <section
 * class="hero hero--photos">, avant le .contenant.
 *
 * @var string $heroPhoto 'nuit' | 'jour' | 'plateau'
 */
$nom = in_array($heroPhoto ?? '', ['nuit', 'jour', 'plateau'], true) ? $heroPhoto : 'jour';
?>
<div class="hero__fond" aria-hidden="true">
  <img src="/assets/hero-<?= $nom ?>-900.jpg"
       srcset="/assets/hero-<?= $nom ?>-900.jpg 900w, /assets/hero-<?= $nom ?>-1920.jpg 1920w"
       sizes="100vw" alt="" width="1920" height="864" fetchpriority="high">
</div>
<div class="hero__scrim" aria-hidden="true"></div>
