<?php
/** @var array $articles
 *  @var array|null $edite */
use EA\Core\Csrf;
$e = $edite ?? null;
?>
<h1 style="font-size:1.5rem"><?= $e ? 'Modifier un article' : 'Articles' ?></h1>

<section class="carte" style="margin-bottom:1.5rem">
  <h2 style="font-size:1.15rem"><?= $e ? 'Modification' : 'Nouvel article' ?></h2>

  <?php if ($e): ?>
    <p class="doux" style="font-size:.875rem">
      Adresse publique : <a href="/article/<?= e($e['slug']) ?>" target="_blank" rel="noopener">/article/<?= e($e['slug']) ?></a>.
      Elle ne change pas quand vous modifiez le titre — c'est l'adresse connue de Google.
    </p>
  <?php endif; ?>

  <form method="post" action="/admin/articles/enregistrer">
    <?= Csrf::champ() ?>
    <input type="hidden" name="id" value="<?= (int)($e['id'] ?? 0) ?>">

    <div class="champ">
      <label for="titre">Titre</label>
      <input type="text" id="titre" name="titre" required maxlength="200" value="<?= e($e['title'] ?? '') ?>">
      <span class="champ__aide">Partez de ce que le lecteur cherche, pas de ce que vous vendez.</span>
    </div>

    <div class="champ">
      <label for="categorie">Étiquette</label>
      <input type="text" id="categorie" name="categorie" maxlength="40"
             value="<?= e($e['category_label'] ?? '') ?>" placeholder="ANALYSE">
    </div>

    <div class="champ">
      <label for="extrait">Résumé (sert aussi sur Google et WhatsApp)</label>
      <textarea id="extrait" name="extrait" style="min-height:5rem" maxlength="300"><?= e($e['excerpt'] ?? '') ?></textarea>
      <span class="champ__aide">Environ 150 caractères. Laissé vide, il est calculé automatiquement.</span>
    </div>

    <div class="champ">
      <label for="image">Adresse de l'image d'illustration</label>
      <input type="url" id="image" name="image" value="<?= e($e['image_url'] ?? '') ?>">
    </div>

    <div class="champ">
      <label for="contenu">Contenu</label>
      <textarea id="contenu" name="contenu" required style="min-height:22rem"><?= e($e['content'] ?? '') ?></textarea>
      <span class="champ__aide">
        Une ligne vide sépare deux paragraphes. Une ligne courte seule devient un titre.
        Un tiret en début de ligne fait une liste. **Le texte entre deux étoiles** est en gras.
      </span>
    </div>

    <div class="champ">
      <label for="publie">Visibilité</label>
      <select id="publie" name="publie">
        <option value="1" <?= (int)($e['published'] ?? 1) === 1 ? 'selected' : '' ?>>Publié — visible par tous</option>
        <option value="0" <?= (int)($e['published'] ?? 1) === 0 ? 'selected' : '' ?>>Brouillon — invisible</option>
      </select>
    </div>

    <div class="rangee">
      <button type="submit" class="bouton bouton--marine">Enregistrer</button>
      <?php if ($e): ?><a class="bouton bouton--contour" href="/admin/articles">Annuler</a><?php endif; ?>
    </div>
  </form>
</section>

<section class="carte">
  <h2 style="font-size:1.15rem"><?= count($articles) ?> article<?= count($articles) > 1 ? 's' : '' ?></h2>
  <div class="defile-x">
    <table class="tableau">
      <thead><tr><th>Titre</th><th>Étiquette</th><th>Date</th><th>État</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($articles as $a): ?>
        <tr>
          <td><a href="/article/<?= e($a['slug']) ?>" target="_blank" rel="noopener"><?= e($a['title']) ?></a></td>
          <td><span class="etiquette"><?= e($a['category_label']) ?></span></td>
          <td class="doux" style="white-space:nowrap"><?= e(dateFr($a['created_at'])) ?></td>
          <td><?= (int)$a['published'] === 1 ? 'Publié' : '<span class="doux">Brouillon</span>' ?></td>
          <td>
            <div class="rangee" style="flex-wrap:nowrap">
              <a class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem"
                 href="/admin/articles/<?= (int)$a['id'] ?>">Modifier</a>
              <form method="post" action="/admin/articles/basculer">
                <?= Csrf::champ() ?>
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">
                  <?= (int)$a['published'] === 1 ? 'Masquer' : 'Publier' ?>
                </button>
              </form>
              <form method="post" action="/admin/articles/supprimer"
                    onsubmit="return confirm('Supprimer cet article ? Son adresse deviendra introuvable pour Google.')">
                <?= Csrf::champ() ?>
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">Supprimer</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
