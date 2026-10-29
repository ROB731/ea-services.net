<?php
/** @var array $articles
 *  @var array|null $edite
 *  @var array $sections */
use EA\Core\Csrf;
$e = $edite ?? null;
$sections = $sections ?? [];
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

  <div style="background:var(--marine-050);border:1px solid var(--bordure);border-radius:var(--arrondi);padding:1rem;margin-bottom:1.25rem">
    <h3 style="font-size:.9375rem;margin-bottom:.25rem">Assistant — proposer un brouillon</h3>
    <p class="doux" style="font-size:.8125rem;margin-bottom:.75rem">
      Il rédige une proposition à partir d'un sujet. Il n'invente jamais de chiffre ni de cas
      client — vous relisez et complétez avant d'enregistrer. Rien n'est publié automatiquement.
    </p>
    <div class="champ">
      <label for="assistant-sujet">Sujet de l'article</label>
      <input type="text" id="assistant-sujet" maxlength="200"
             placeholder="Ex : pourquoi les demandes clients se perdent sans automatisation">
    </div>
    <div class="champ">
      <label for="assistant-points">Points à couvrir (facultatif)</label>
      <textarea id="assistant-points" style="min-height:4rem"></textarea>
    </div>
    <button type="button" class="bouton bouton--contour" id="assistant-generer-article">
      Générer un brouillon
    </button>
    <p class="doux" style="font-size:.8125rem;margin-top:.5rem" id="assistant-article-etat" aria-live="polite"></p>
  </div>

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
      <label for="image">Image de couverture</label>
      <div class="rangee" style="align-items:flex-start">
        <div style="flex:1;min-width:14rem">
          <input type="text" id="image" name="image" value="<?= e($e['image_url'] ?? '') ?>"
                 placeholder="/uploads/articles/… ou une adresse externe">
          <span class="champ__aide">Depuis votre appareil : le bouton ci-contre remplit ce champ automatiquement.</span>
        </div>
        <label class="bouton bouton--contour" style="min-height:2.75rem;cursor:pointer" data-televerser-image data-cible="image" data-apercu="apercu-image">
          Choisir une photo
          <input type="file" accept="image/jpeg,image/png,image/webp,image/gif" hidden>
        </label>
      </div>
      <img id="apercu-image" src="<?= e($e['image_url'] ?? '') ?>" alt=""
           style="<?= empty($e['image_url']) ? 'display:none;' : '' ?>margin-top:.75rem;max-width:14rem;border-radius:var(--arrondi);display:block">
    </div>

    <div class="champ">
      <label for="contenu">Contenu (texte simple, sans photo)</label>
      <textarea id="contenu" name="contenu" style="min-height:12rem"><?= e($e['content'] ?? '') ?></textarea>
      <span class="champ__aide">
        Une ligne vide sépare deux paragraphes. Une ligne courte seule devient un titre.
        Un tiret en début de ligne fait une liste. **Le texte entre deux étoiles** est en gras.
        Laissez vide si vous écrivez l'article en sections ci-dessous.
      </span>
    </div>

    <div class="champ">
      <label style="margin-bottom:.25rem">Sections avec photo ou vidéo (facultatif)</label>
      <p class="doux" style="font-size:.8125rem;margin-bottom:.75rem">
        Utile pour illustrer chaque étape ou chaque idée par sa propre image. Si vous en ajoutez,
        elles remplacent le contenu simple ci-dessus sur la page publiée. L'ordre ci-dessous est
        celui d'affichage.
      </p>

      <div id="sections-liste">
        <?php foreach ($sections as $i => $s): ?>
          <?php require __DIR__ . '/_section-article.php'; ?>
        <?php endforeach; ?>
      </div>

      <button type="button" class="bouton bouton--contour" id="ajouter-section">+ Ajouter une section</button>

      <?php /* Gabarit d'une section vide, cloné par admin.js — mêmes noms de
               champs que ci-dessus, "__INDEX__" est remplacé par un compteur
               à chaque ajout pour que sections[__INDEX__][...] devienne un
               index réel. */ ?>
      <template id="modele-section">
        <?php $i = '__INDEX__'; $s = []; require __DIR__ . '/_section-article.php'; ?>
      </template>
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
      <button type="submit" class="bouton bouton--contour"
              formaction="/admin/articles/previsualiser" formtarget="_blank">
        Prévisualiser
      </button>
      <?php if ($e): ?><a class="bouton bouton--contour" href="/admin/articles">Annuler</a><?php endif; ?>
    </div>
    <p class="doux" id="brouillon-etat" style="font-size:.8125rem;margin-top:.5rem" aria-live="polite"></p>
  </form>
</section>

<section class="carte">
  <h2 style="font-size:1.15rem" id="compte-articles"><?= count($articles) ?> article<?= count($articles) > 1 ? 's' : '' ?></h2>

  <div class="rangee" style="align-items:flex-end;margin-bottom:.5rem">
    <div class="champ" style="flex:1;min-width:14rem;margin-bottom:0">
      <label for="filtre-articles-recherche">Rechercher</label>
      <input type="search" id="filtre-articles-recherche" placeholder="Un titre ou une étiquette…">
    </div>
    <div class="champ" style="min-width:10rem;margin-bottom:0">
      <label for="filtre-articles-etat">État</label>
      <select id="filtre-articles-etat">
        <option value="">Tous les états</option>
        <option value="publie">Publiés seulement</option>
        <option value="brouillon">Brouillons seulement</option>
      </select>
    </div>
  </div>
  <p class="doux" id="filtre-articles-vide" style="display:none;margin-bottom:1rem">Aucun article ne correspond à cette recherche.</p>

  <div class="defile-x">
    <table class="tableau">
      <thead><tr><th>Titre</th><th>Étiquette</th><th>Date</th><th>État</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($articles as $a): ?>
        <tr data-ligne data-etat-ligne="<?= (int)$a['published'] === 1 ? 'publie' : 'brouillon' ?>"
            data-recherche="<?= e(mb_strtolower($a['title'] . ' ' . $a['category_label'])) ?>">
          <td><a href="/article/<?= e($a['slug']) ?>" target="_blank" rel="noopener"><?= e($a['title']) ?></a></td>
          <td><span class="etiquette"><?= e($a['category_label']) ?></span></td>
          <td class="doux" style="white-space:nowrap"><?= e(dateFr($a['created_at'])) ?></td>
          <td data-etat-publication>
            <span class="badge-etat badge-etat--<?= (int)$a['published'] === 1 ? 'publie' : 'brouillon' ?>">
              <?= (int)$a['published'] === 1 ? 'Publié' : 'Brouillon' ?>
            </span>
          </td>
          <td>
            <div class="rangee" style="flex-wrap:nowrap">
              <a class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem"
                 href="/admin/articles/<?= (int)$a['id'] ?>">Modifier</a>
              <a class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem"
                 href="/admin/articles/<?= (int)$a['id'] ?>/previsualiser" target="_blank" rel="noopener">Aperçu</a>
              <form method="post" action="/admin/articles/basculer" data-async="basculer">
                <?= Csrf::champ() ?>
                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                <button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">
                  <?= (int)$a['published'] === 1 ? 'Masquer' : 'Publier' ?>
                </button>
              </form>
              <form method="post" action="/admin/articles/supprimer" data-async="supprimer"
                    data-confirmer="Supprimer cet article ? Son adresse deviendra introuvable pour Google.">
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
