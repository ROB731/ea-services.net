<?php
/** Pied de page. Les coordonnées viennent de config/site.php, jamais recopiées. */
$c = (array)cfg('contact');
?>
<footer class="pied">
  <div class="contenant">
    <div class="pied__grille">

      <div>
        <h4>EA-SERVICES</h4>
        <p>Nous aidons les entreprises ivoiriennes à récupérer du temps, des
           clients et du chiffre d'affaires — avec des résultats mesurés, pas
           des promesses.</p>
        <p class="doux" style="font-size:.8125rem"><?= e(cfg('baseline')) ?></p>
      </div>

      <div>
        <h4>Le site</h4>
        <ul class="pied__liste">
          <?php foreach ((array)cfg('navigation', []) as $lien): ?>
            <li><a href="<?= e($lien['url']) ?>"><?= e($lien['libelle']) ?></a></li>
          <?php endforeach; ?>
          <li><a href="/pages/contact">Contact</a></li>
        </ul>
      </div>

      <div>
        <h4>Nous joindre</h4>
        <ul class="pied__liste">
          <li><a href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
            <?= icone('whatsapp') ?> WhatsApp — réponse sous 2 h</a></li>
          <li><a href="tel:<?= e($c['telephone_e164']) ?>">
            <?= icone('telephone') ?> <?= e($c['telephone']) ?></a></li>
          <li><a href="mailto:<?= e($c['email']) ?>">
            <?= icone('courriel') ?> <?= e($c['email']) ?></a></li>
          <li><?= icone('lieu') ?> <?= e($c['quartier']) ?>, <?= e($c['ville']) ?> — <?= e($c['pays']) ?></li>
        </ul>
      </div>

      <div>
        <h4><?= e(cfg('cta.titre')) ?></h4>
        <p>Trente minutes pour identifier vos deux plus grosses pertes et
           chiffrer ce que vous récupérez.</p>
        <a class="bouton bouton--or bouton--large" href="/pages/contact"><?= e(cfg('cta.libelle')) ?></a>
      </div>
    </div>

    <div class="pied__bas">
      <span>&copy; <?= date('Y') ?> EA-SERVICES — <?= e($c['ville']) ?>, <?= e($c['pays']) ?></span>
      <span>Site édité et hébergé par EA-SERVICES</span>
    </div>
  </div>
</footer>
