<?php
/** Pied de page v2. Coordonnées issues de config/site.php, jamais recopiées. */
$c = (array)cfg('contact');
?>
<footer class="pied">
  <div class="page-large">
    <div class="pied__grille">

      <div>
        <h4>EA-SERVICES</h4>
        <p>Nous aidons les entreprises ivoiriennes à récupérer du temps, des
           clients et du chiffre d'affaires — avec des résultats mesurés, pas
           des promesses.</p>
        <p style="font-size:.8125rem;opacity:.6"><?= e(cfg('baseline')) ?></p>
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
          <li><?= icone('lieu') ?> <?= e($c['quartier']) ?>, <?= e($c['ville']) ?></li>
          <?php foreach ((array)cfg('reseaux', []) as $reseau => $lien): ?>
            <li><a href="<?= e($lien) ?>" target="_blank" rel="noopener">
              <?= icone($reseau) ?> <?= e(ucfirst($reseau)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h4>Le prochain chiffre</h4>
        <p>Trente minutes pour identifier vos deux plus grosses pertes et
           chiffrer ce que vous récupérez.</p>
        <a class="bouton bouton--safran bouton--large" href="/diagnostic"><?= e(cfg('cta.libelle')) ?></a>
      </div>
    </div>

    <?php /* Une ligne de liens vers chaque expertise : c'est ce qui permet à
             Google (et au visiteur) de les atteindre depuis n'importe quelle page. */ ?>
    <nav class="pied__expertises" aria-label="Nos expertises">
      <h4>Nos expertises à Abidjan</h4>
      <ul>
        <?php foreach (\EA\Core\Config::expertises() as $slugX => $xp): ?>
          <li><a href="/pages/<?= e($slugX) ?>"><?= e($xp['libelle']) ?></a></li>
        <?php endforeach; ?>
        <li><a href="/pages/sonnera">Sonnera, application d'équipe</a></li>
      </ul>
    </nav>

    <div class="pied__bas">
      <span>&copy; <?= date('Y') ?> EA-SERVICES — <?= e($c['ville']) ?>, <?= e($c['pays']) ?></span>
      <span>Site édité et hébergé par EA-SERVICES · <a href="/admin/connexion" style="opacity:.6">Administration</a></span>
    </div>
  </div>
</footer>
