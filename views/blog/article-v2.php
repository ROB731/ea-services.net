<?php
/**
 * Article — direction v2.
 *
 * Les 6 slugs existants sont conservés à l'identique : ils sont indexés.
 * Le titre n'utilise pas l'effet machine à écrire des autres pages : un
 * titre d'article est écrit en administration, sa longueur n'est pas
 * maîtrisée comme celle des titres figés du reste du site.
 *
 * @var array $article
 * @var array $sections
 * @var array $commentaires
 * @var array $suggestions
 * @var string|null $etatCommentaire
 * @var string|null $messageCommentaire
 * @var bool|null $apercu
 */
?>

<?php if (!empty($apercu)): ?>
  <div class="bandeau-apercu" role="status">
    Aperçu — cet article n'est pas visible publiquement dans cet état.
  </div>
<?php endif; ?>

<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index"><?= e($article['category_label'] ?? 'Article') ?></span>
      <span class="etiquette-section__texte">
        Publié le <?= e(dateFr($article['created_at'] ?? null)) ?>
        <?php if (!empty($article['read_time'])): ?> · <?= e($article['read_time']) ?> de lecture<?php endif; ?>
      </span>
    </p>
    <h1 class="mesure"><?= e($article['title']) ?></h1>
    <?php if (!empty($article['excerpt'])): ?>
      <p class="mesure-large doux" style="margin-top:1.25rem"><?= e($article['excerpt']) ?></p>
    <?php endif; ?>

    <?php if (empty($apercu)): $urlArticle = \EA\Core\Config::url('/article/' . $article['slug']); ?>
      <div class="partage" aria-label="Partager cet article">
        <span class="partage__etiquette">Partager</span>
        <a class="partage__bouton" href="https://wa.me/?text=<?= urlencode($article['title'] . ' — ' . $urlArticle) ?>"
           target="_blank" rel="noopener" aria-label="Partager sur WhatsApp"><?= icone('whatsapp') ?></a>
        <a class="partage__bouton" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($urlArticle) ?>"
           target="_blank" rel="noopener" aria-label="Partager sur Facebook"><?= icone('facebook') ?></a>
        <button type="button" class="partage__bouton" data-copier-lien data-lien="<?= e($urlArticle) ?>" aria-label="Copier le lien">
          <?= icone('lien') ?>
        </button>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--claire">
  <div class="page-large">
    <?php if (!empty($article['image_url'])): ?>
      <img src="<?= e($article['image_url']) ?>" alt=""
           style="border-radius:var(--arrondi-lg);margin-bottom:2rem;width:100%;max-width:42rem;aspect-ratio:16/9;object-fit:cover"
           width="1200" height="675" fetchpriority="high" decoding="async">
    <?php endif; ?>

    <?php if ($sections): ?>
      <?php /* Article écrit par sections (voir /admin/articles) : chacune
               porte son propre texte et, si le dirigeant l'a ajoutée, sa
               propre photo ou vidéo — prime sur le contenu simple. */ ?>
      <?php foreach ($sections as $s): ?>
        <div style="margin-bottom:2rem;max-width:42rem">
          <?php if (!empty($s['heading'])): ?>
            <h2><?= e($s['heading']) ?></h2>
          <?php endif; ?>
          <?php if (!empty($s['image_url'])): ?>
            <img src="<?= e($s['image_url']) ?>" alt=""
                 style="border-radius:var(--arrondi-lg);margin-bottom:1.25rem;width:100%;aspect-ratio:16/9;object-fit:cover"
                 loading="lazy" decoding="async">
          <?php endif; ?>
          <?php if (!empty($s['video_src'])): ?>
            <div style="position:relative;aspect-ratio:16/9;margin-bottom:1.25rem;border-radius:var(--arrondi-lg);overflow:hidden">
              <iframe src="<?= e($s['video_src']) ?>" title="<?= e($s['heading'] ?: $article['title']) ?>"
                      style="position:absolute;inset:0;width:100%;height:100%;border:0"
                      loading="lazy" referrerpolicy="strict-origin-when-cross-origin"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          <?php endif; ?>
          <div class="redaction"><?= $s['body_html'] ?></div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <?php /* Contenu rédigé en administration : rendu tel quel, volontairement. */ ?>
      <div class="redaction"><?= $article['content_html'] ?></div>
    <?php endif; ?>

    <?php
      // Deux des cinq gains, en rotation selon l'article — pas toujours les
      // mêmes deux, pour que la promotion interne reste pertinente sur la
      // durée plutôt que de montrer systématiquement les deux premiers.
      $tousGains = (array)cfg('gains');
      $clesGains = array_keys($tousGains);
      $icones    = ['temps' => 'temps', 'conversion' => 'conversion', 'visibilite' => 'visibilite',
                    'ca' => 'croissance', 'serenite' => 'serenite'];
      $n = count($clesGains);
      $depart = $n ? ((int)($article['id'] ?? 0)) % $n : 0;
      $promoCles = $n ? [$clesGains[$depart], $clesGains[($depart + 1) % $n]] : [];
    ?>
    <?php if ($promoCles && empty($apercu)): ?>
      <div class="promo-article" style="max-width:42rem">
        <p class="promo-article__etiquette">Pendant que vous lisez</p>
        <div class="promo-article__grille">
          <?php foreach ($promoCles as $cle): $g = $tousGains[$cle]; ?>
            <a class="promo-article__carte" href="/pages/services#gain-<?= e($cle) ?>">
              <?= icone($icones[$cle] ?? 'cible', 'ico ico--lg') ?>
              <span class="promo-article__titre"><?= e($g['titre']) ?></span>
              <span class="promo-article__impact"><?= e($g['impact']) ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
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
        Trente minutes suffisent pour savoir ce qu'il vous coûte réellement,
        et par quoi commencer. Gratuit, sans engagement.
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

<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Réactions</span>
      <span class="etiquette-section__texte">Commentaires</span>
    </p>
    <h2 class="mesure">Ce qu'en pensent<span class="suite">nos lecteurs.</span></h2>

    <?php if ($commentaires): ?>
      <div class="pile" style="margin:1.75rem 0 2rem;max-width:42rem">
        <?php foreach ($commentaires as $com): ?>
          <div class="carte">
            <p style="margin-bottom:.5rem"><?= nl2br(e($com['comment'])) ?></p>
            <p class="doux" style="margin:0;font-size:.875rem">
              <strong><?= e($com['name']) ?></strong> · <?= e(dateFr($com['created_at'])) ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="doux" style="margin:1.75rem 0 2rem">Aucun commentaire pour le moment. Le vôtre sera le premier.</p>
    <?php endif; ?>

    <?php if (!empty($etatCommentaire)): ?>
      <div class="alerte alerte--<?= $etatCommentaire === 'ok' ? 'ok' : 'erreur' ?>" style="max-width:36rem">
        <?= e($messageCommentaire) ?>
      </div>
    <?php endif; ?>

    <?php if (empty($apercu)): ?>
    <form method="post" action="/article/<?= e($article['slug']) ?>/commentaire" style="max-width:36rem">
      <?= \EA\Core\Csrf::champ() ?>
      <div class="piege" aria-hidden="true">
        <label for="site-com">Ne remplissez pas ce champ</label>
        <input type="text" id="site-com" name="site" tabindex="-1" autocomplete="off">
      </div>
      <div class="champ">
        <label for="nom-com">Votre nom</label>
        <input type="text" id="nom-com" name="nom" required autocomplete="name">
      </div>
      <div class="champ">
        <label for="texte-com">Votre commentaire</label>
        <textarea id="texte-com" name="commentaire" required></textarea>
      </div>
      <button type="submit" class="bouton bouton--marine bouton--large">Publier mon commentaire</button>
      <p class="champ__aide" style="margin-top:.5rem">Les commentaires sont relus avant publication.</p>
    </form>
    <?php else: ?>
      <p class="doux" style="max-width:36rem">Les commentaires sont désactivés en aperçu.</p>
    <?php endif; ?>
  </div>
</section>

<?php if ($suggestions): ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">À suivre</span>
      <span class="etiquette-section__texte">À lire ensuite</span>
    </p>
    <h2 class="mesure">D'autres articles<span class="suite">qui pourraient vous servir.</span></h2>

    <div class="grille grille--3">
      <?php foreach ($suggestions as $a): ?>
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
  </div>
</section>
<?php endif; ?>
