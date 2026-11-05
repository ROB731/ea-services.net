<?php
/**
 * Diagnostic automatique — le résultat.
 *
 * Structure imposée par la doctrine : la perte subie d'abord (avec son
 * chiffre), le gain en face ensuite, le diagnostic humain à la fin.
 *
 * Chaque perte affiche SA MÉTHODE de calcul. C'est la contrepartie de la règle
 * d'intégrité : on ne demande pas de croire un chiffre, on montre d'où il
 * sort. Un visiteur qui refait le calcul et tombe juste nous fait confiance
 * pour le reste.
 *
 * @var array $pertes   Déjà triées, la plus lourde en premier.
 * @var array $reponses Ce que la personne a déclaré.
 */
$deux = array_slice($pertes, 0, 2);
$reste = array_slice($pertes, 2);
?>

<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Votre diagnostic</span>
      <span class="etiquette-section__texte">Établi à partir de vos réponses</span>
    </p>

    <?php if ($deux === []): ?>
      <h1 class="mesure titre-machine">Rien d'alarmant<em>dans ce que vous décrivez.</em></h1>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        D'après vos réponses, vous répondez vite, vos données sont sauvegardées
        et vos clients vous trouvent. Nous n'allons pas vous inventer un
        problème pour vous vendre quelque chose. Si vous voulez malgré tout
        creuser un point précis, le diagnostic de trente minutes reste ouvert.
      </p>
    <?php else: ?>
      <h1 class="mesure titre-machine">Voici où votre croissance<em>fuit aujourd'hui.</em></h1>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        <?= count($deux) > 1 ? 'Deux pertes' : 'Une perte' ?> ressorte<?= count($deux) > 1 ? 'nt' : '' ?>
        de vos réponses. Chaque chiffre vient de ce que vous avez déclaré — la
        méthode est indiquée dessous, vous pouvez la vérifier.
      </p>
    <?php endif; ?>
  </div>
</section>

<?php foreach ($deux as $i => $p): ?>
<section class="section <?= $i % 2 ? 'section--sable' : 'section--papier' ?>">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index"><?= sprintf('%02d', $i + 1) ?></span>
      <span class="etiquette-section__texte">Priorité <?= $i === 0 ? 'la plus lourde' : 'suivante' ?></span>
    </p>
    <h2 class="mesure"><?= e($p['titre']) ?></h2>

    <div class="grille grille--2">
      <article class="carte">
        <h3>Ce que ça vous coûte</h3>
        <p style="font-size:2.25rem;font-weight:800;line-height:1.1;margin:.5rem 0 1rem">
          <?= e($p['chiffre']) ?>
        </p>
        <p class="doux"><?= e($p['detail']) ?></p>
        <p class="champ__aide" style="margin-top:1rem">
          <strong>Comment on l'obtient :</strong> <?= e($p['methode']) ?>
        </p>
      </article>

      <article class="carte">
        <h3>Ce qu'on peut récupérer</h3>
        <p class="doux">
          C'est exactement ce que traite notre gain
          « <?= e(str_replace(['Récupérez ', 'Gagnez ', 'Convertissez ', 'Démultipliez '], '', (string)(cfg("gains.{$p['cle']}.titre") ?? ''))) ?> ».
        </p>
        <?php if ($p['promesse'] !== ''): ?>
          <span class="manifeste__impact"><?= e($p['promesse']) ?></span>
        <?php endif; ?>
        <p class="champ__aide" style="margin-top:1rem">
          Cette promesse est celle que nous affichons publiquement sur tout le
          site. Elle n'a pas été ajustée pour votre cas — c'est le rendez-vous
          qui sert à ça.
        </p>
      </article>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?php if ($reste !== []): ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Pour plus tard</span>
      <span class="etiquette-section__texte">Vu aussi, mais moins urgent</span>
    </p>
    <h2 class="mesure">On ne traite pas tout<span class="suite">en même temps.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Vouloir tout régler d'un coup, c'est ne rien terminer. Ces points existent,
      ils attendront que les deux premiers soient réglés.
    </p>
    <div class="pile" style="margin-top:2rem;max-width:44rem">
      <?php foreach ($reste as $p): ?>
        <div class="carte">
          <h3><?= e($p['titre']) ?></h3>
          <p class="doux" style="margin:0"><?= e($p['detail']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">La suite</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Ce calcul est un début.<span class="suite">Le vrai chiffre vient de vos données.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Ce que vous venez de lire repose sur cinq réponses. Trente minutes avec
        vos chiffres réels donnent un montant en FCFA, un délai et un ordre de
        priorité. Nous ne vendons rien pendant cet échange.
      </p>
    </div>
    <div class="diagnostic__actions">
      <a class="bouton bouton--safran" href="/pages/contact">
        <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
        <?= icone('whatsapp') ?> En parler sur WhatsApp
      </a>
      <span class="diagnostic__note"><?= e(cfg('cta.promesse')) ?></span>
    </div>
  </div>
</section>
