<?php
/**
 * Article.
 *
 * Les 6 slugs existants sont conservés à l'identique : ils sont indexés.
 *
 * @var array $article
 * @var array $commentaires
 * @var array $suggestions
 * @var string|null $etatCommentaire
 * @var string|null $messageCommentaire
 */
?>

<article>
  <section class="hero">
    <div class="contenant">
      <p class="sur-titre"><?= e($article['category_label'] ?? 'Article') ?></p>
      <h1 class="mesure"><?= e($article['title']) ?></h1>
      <p class="chapo mesure"><?= e($article['excerpt'] ?? '') ?></p>
      <p style="font-size:.875rem;color:rgba(255,255,255,.7)">
        Publié le <?= e(dateFr($article['created_at'] ?? null)) ?>
        <?php if (!empty($article['read_time'])): ?> · <?= e($article['read_time']) ?> de lecture<?php endif; ?>
      </p>
    </div>
  </section>

  <section class="section">
    <div class="contenant">
      <?php if (!empty($article['image_url'])): ?>
        <img src="<?= e($article['image_url']) ?>" alt=""
             style="border-radius:1.25rem;margin-bottom:2rem;width:100%;aspect-ratio:16/9;object-fit:cover"
             width="1200" height="675" fetchpriority="high" decoding="async">
      <?php endif; ?>

      <?php /* Contenu rédigé en administration : rendu tel quel, volontairement. */ ?>
      <div class="redaction"><?= $article['content_html'] ?></div>
    </div>
  </section>
</article>

<?php
$diagnosticTexte = "Cet article décrit un problème que vous vivez peut-être. Trente minutes "
                 . "suffisent pour savoir ce qu'il vous coûte réellement, et par quoi commencer.";
require dirname(__DIR__) . '/partials/diagnostic.php';
?>

<section class="section section--alt">
  <div class="contenant">
    <h2>Commentaires</h2>

    <?php if ($commentaires): ?>
      <div class="pile" style="margin-bottom:2rem">
        <?php foreach ($commentaires as $com): ?>
          <div class="carte">
            <p style="margin-bottom:.5rem"><?= nl2br(e($com['comment'])) ?></p>
            <p class="doux" style="margin:0;font-size:.875rem">
              <strong class="fort"><?= e($com['name']) ?></strong> · <?= e(dateFr($com['created_at'])) ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="doux">Aucun commentaire pour le moment. Le vôtre sera le premier.</p>
    <?php endif; ?>

    <?php if (!empty($etatCommentaire)): ?>
      <div class="alerte alerte--<?= $etatCommentaire === 'ok' ? 'ok' : 'erreur' ?>">
        <?= e($messageCommentaire) ?>
      </div>
    <?php endif; ?>

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
  </div>
</section>

<?php if ($suggestions): ?>
<section class="section">
  <div class="contenant">
    <h2>À lire ensuite</h2>
    <div class="grille" style="margin-top:1.5rem">
      <?php foreach ($suggestions as $a): ?>
        <?php require __DIR__ . '/vignette.php'; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
