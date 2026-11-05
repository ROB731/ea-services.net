<?php
/**
 * Page d'expertise — gabarit commun aux pages de config/expertises.php.
 *
 * Ordre imposé par la doctrine : la requête (h1) → la perte → ce qu'on met en
 * place et le gain chiffré → la méthode → ce qui nous distingue → la preuve
 * réelle (si elle existe) → les questions → les lectures → le diagnostic.
 *
 * @var string $slug
 * @var array  $x         l'expertise (config/expertises.php)
 * @var array  $gain      le gain rattaché (config/site.php)
 * @var array  $articles  articles publiés liés (title, slug, excerpt)
 * @var array  $voisines  autres expertises liées : slug => expertise
 */
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <nav class="ariane" aria-label="Fil d'Ariane">
      <a href="/">Accueil</a> <span aria-hidden="true">›</span>
      <a href="/pages/prestations">Prestations</a> <span aria-hidden="true">›</span>
      <span aria-current="page"><?= e($x['libelle']) ?></span>
    </nav>
    <div class="expertise-heros">
      <div>
        <h1 class="mesure titre-long titre-machine"><?= e($x['h1']) ?><em><?= e($x['h1_suite']) ?></em></h1>
        <p class="heros__badge"><?= icone($x['icone']) ?> <?= e($x['badge']) ?></p>
        <p class="mesure-large doux" style="margin-top:1.25rem"><?= e($x['chapo']) ?></p>
        <div class="diagnostic__actions" style="margin-top:1.75rem">
          <a class="bouton bouton--safran" href="/diagnostic"><?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?></a>
          <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
            <?= icone('whatsapp') ?> Écrire sur WhatsApp
          </a>
          <span class="diagnostic__note"><?= e(cfg('cta.promesse')) ?></span>
        </div>
      </div>
      <?php if (!empty($x['visuel'])): ?>
        <?php /* Premier écran : chargé tout de suite (pas de lazy), dimensions
                 fixées pour éviter tout décalage de mise en page. */ ?>
        <figure class="expertise-heros__visuel">
          <img src="<?= e($x['visuel']['src']) ?>" alt="<?= e($x['visuel']['alt']) ?>"
               width="640" height="520" fetchpriority="high">
          <figcaption>Illustration de principe</figcaption>
        </figure>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php /* ------------------------------------------------- Ce que vous perdez */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Ce que vous perdez</span>
      <span class="etiquette-section__texte">Avant de parler de solution</span>
    </p>
    <h2 class="mesure">Trois pertes que vous vivez<span class="suite">peut-être déjà.</span></h2>
    <div class="grille grille--3" style="margin-top:1.5rem">
      <?php foreach ($x['pertes'] as $i => [$titre, $texte]): ?>
        <article class="carte carte--perte">
          <p class="perte__rang" aria-hidden="true"><span><?= sprintf('%02d', $i + 1) ?></span></p>
          <h3><?= e($titre) ?></h3>
          <p class="doux"><?= e($texte) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* ------------------------------------------- Ce que nous mettons en place */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Ce que vous obtenez</span>
      <span class="etiquette-section__texte"><?= e($gain['titre'] ?? '') ?></span>
    </p>
    <h2 class="mesure">Ce que nous mettons en place<span class="suite">et ce que ça change.</span></h2>

    <div class="grille grille--2" style="margin-top:1.5rem">
      <article class="carte">
        <h3>Concrètement</h3>
        <ul class="liste-cochee">
          <?php foreach ($x['livrables'] as $point): ?>
            <li><?= e($point) ?></li>
          <?php endforeach; ?>
        </ul>
        <?php if (!empty($gain['gain'])): ?>
          <p class="doux" style="margin-top:1rem"><?= e($gain['gain']) ?></p>
        <?php endif; ?>
        <?php if (!empty($gain['impact'])): ?>
          <span class="investissement"><strong>Impact :</strong> <?= e($gain['impact']) ?></span>
        <?php endif; ?>
      </article>

      <article class="carte">
        <h3>C'est pour vous si…</h3>
        <ul class="liste-cochee">
          <?php foreach ($x['pour_qui'] as $situation): ?>
            <li><?= e($situation) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="doux" style="margin-top:1rem">
          Vous ne vous reconnaissez pas ? Le diagnostic sert aussi à ça : vous
          dire honnêtement si ce n'est pas votre priorité.
        </p>
      </article>
    </div>
  </div>
</section>

<?php /* ------------------------------------------------------- La photo */ ?>
<?php if (!empty($x['photo'])): $ph = $x['photo']; ?>
<section class="section section--papier" style="padding-bottom:0">
  <div class="page-large">
    <figure class="photo-bandeau">
      <img src="/assets/photos/<?= e($ph['fichier']) ?>-700.jpg"
           srcset="/assets/photos/<?= e($ph['fichier']) ?>-700.jpg 700w, /assets/photos/<?= e($ph['fichier']) ?>-1200.jpg 1200w"
           sizes="(min-width: 74rem) 74rem, 100vw" alt="<?= e($ph['alt']) ?>" loading="lazy"
           style="aspect-ratio:<?= e($ph['ratio']) ?>">
      <figcaption>
        <span><?= e($ph['legende']) ?></span>
        <a class="photo-bandeau__credit" href="<?= e($ph['source']) ?>" target="_blank" rel="noopener">Photo : <?= e($ph['credit']) ?></a>
      </figcaption>
    </figure>
  </div>
</section>
<?php endif; ?>

<?php /* ------------------------------------------------------- La méthode */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Comment on travaille</span>
      <span class="etiquette-section__texte">Toujours le même déroulé</span>
    </p>
    <h2 class="mesure">Quatre étapes,<span class="suite">jamais dans le désordre.</span></h2>
    <ol class="etapes" style="max-width:44rem">
      <li class="etape"><div>
        <h3>Diagnostic — gratuit, 30 minutes</h3>
        <p class="doux">Nous écoutons comment vous travaillez et nous chiffrons ce que vous perdez. Nous ne vendons rien à cette étape.</p>
      </div></li>
      <li class="etape"><div>
        <h3>Recommandation chiffrée</h3>
        <p class="doux">Le montant, le gain mensuel attendu en FCFA, et le nombre de mois au bout duquel l'un dépasse l'autre. Vous décidez ensuite, ou vous attendez.</p>
      </div></li>
      <li class="etape"><div>
        <h3>Mise en place et formation</h3>
        <p class="doux">Nous installons, puis nous formons votre équipe, pour que le quotidien tourne sans nous.</p>
      </div></li>
      <li class="etape"><div>
        <h3>Mesure et ajustement</h3>
        <p class="doux">Ce qui produit un résultat est amplifié. Ce qui ne donne rien est arrêté, sans le défendre.</p>
      </div></li>
    </ol>
  </div>
</section>

<?php /* ---------------------------------------------- Ce qui nous distingue */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Pourquoi nous</span>
      <span class="etiquette-section__texte">Il existe beaucoup d'agences. Voici ce qui change ici.</span>
    </p>
    <h2 class="mesure">Ce que vous ne trouverez pas<span class="suite">dans un simple devis.</span></h2>
    <div class="grille grille--2" style="margin-top:1.5rem">
      <?php foreach ($x['differences'] as [$titre, $texte]): ?>
        <article class="carte">
          <h3><?= icone('coche') ?> <?= e($titre) ?></h3>
          <p class="doux"><?= e($texte) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* ------------------------------------------------------- La preuve */ ?>
<?php if (!empty($x['preuves'])): $p = $x['preuves']; ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">La preuve</span>
      <span class="etiquette-section__texte">Du réel, que vous pouvez vérifier</span>
    </p>
    <h2 class="mesure"><?= e($p['titre']) ?></h2>
    <p class="mesure-large doux" style="margin-top:1rem"><?= e($p['texte']) ?></p>
    <?php if (!empty($p['lien'])): ?>
      <p style="margin-top:1.5rem">
        <a class="bouton bouton--contour-clair" href="<?= e($p['lien'][0]) ?>"><?= e($p['lien'][1]) ?> <?= icone('fleche') ?></a>
      </p>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php /* ------------------------------------------------------- Questions */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Questions fréquentes</span>
      <span class="etiquette-section__texte"><?= e($x['libelle']) ?></span>
    </p>
    <h2 class="mesure">Les questions qu'on nous pose<span class="suite">avant de commencer.</span></h2>
    <div style="margin-top:1.5rem;display:grid;gap:.75rem;max-width:52rem">
      <?php foreach ($x['faq'] as [$question, $reponse]): ?>
        <details class="faq carte">
          <summary><?= e($question) ?><?= icone('fleche', 'ico faq__fleche') ?></summary>
          <p class="doux"><?= e($reponse) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* ---------------------------------------------------- Pour aller plus loin */ ?>
<?php if ($articles || $voisines): ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Pour aller plus loin</span>
      <span class="etiquette-section__texte">Lectures et expertises liées</span>
    </p>

    <?php if ($articles): ?>
      <h2 class="mesure">À lire avant de décider</h2>
      <div class="grille grille--3" style="margin-top:1.25rem">
        <?php foreach ($articles as $a): ?>
          <article class="carte">
            <h3><a href="/article/<?= e($a['slug']) ?>"><?= e($a['title']) ?></a></h3>
            <p class="doux"><?= e(mb_strimwidth((string)$a['excerpt'], 0, 160, '…')) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($voisines): ?>
      <h2 class="mesure" style="margin-top:2.5rem">Souvent demandé avec</h2>
      <div class="grille grille--3" style="margin-top:1.25rem">
        <?php foreach ($voisines as $vSlug => $v): ?>
          <a class="carte carte--lien" href="/pages/<?= e($vSlug) ?>">
            <h3><?= icone($v['icone']) ?> <?= e($v['libelle']) ?></h3>
            <p class="doux"><?= e($v['h1_suite']) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php /* --------------------------------------------------- Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Combien cela vous coûte<span class="suite">aujourd'hui ?</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes pour chiffrer ce que vous perdez, et savoir si c'est
        vraiment par là qu'il faut commencer — ou s'il vaut mieux traiter
        autre chose d'abord.
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
