<?php
/** @var array $commentaires */
use EA\Core\Csrf;
$attente = array_filter($commentaires, static fn($c) => (int)$c['published'] === 0);
?>
<h1 style="font-size:1.5rem">Commentaires</h1>
<p class="doux">
  <?= count($attente) ?> en attente de relecture. Un commentaire n'apparaît sur
  le site qu'après votre validation.
</p>

<div class="pile" data-liste-vide>
  <p class="doux" data-message-vide<?= $commentaires ? ' hidden' : '' ?>>Aucun commentaire pour l'instant.</p>
    <?php foreach ($commentaires as $c): ?>
      <article class="carte" data-ligne style="<?= (int)$c['published'] === 0 ? 'border-left:4px solid var(--or-500)' : '' ?>">
        <p class="doux" style="font-size:.875rem;margin-bottom:.5rem">
          Sur <a href="/article/<?= e($c['slug']) ?>" target="_blank" rel="noopener"><?= e($c['title']) ?></a>
          · <?= e(dateFr($c['created_at'])) ?>
          <?php if ((int)$c['published'] === 0): ?> · <strong data-badge-attente>en attente</strong><?php endif; ?>
        </p>
        <p style="margin-bottom:.5rem"><?= nl2br(e($c['comment'])) ?></p>
        <p class="doux" style="font-size:.875rem">— <?= e($c['name']) ?></p>

        <div class="rangee">
          <?php if ((int)$c['published'] === 0): ?>
            <form method="post" action="/admin/commentaires/valider" data-async="valider">
              <?= Csrf::champ() ?>
              <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
              <button class="bouton bouton--marine" type="submit"><?= icone('coche') ?> Publier</button>
            </form>
          <?php endif; ?>
          <form method="post" action="/admin/commentaires/supprimer"
                data-async="supprimer" data-confirmer="Supprimer ce commentaire ?">
            <?= Csrf::champ() ?>
            <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
            <button class="bouton bouton--contour" type="submit">Supprimer</button>
          </form>
        </div>
      </article>
    <?php endforeach; ?>
</div>
