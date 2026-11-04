<?php
/** @var array $demandes */
use EA\Core\Csrf;
?>
<h1 style="font-size:1.5rem">Demandes de diagnostic</h1>

<div class="pile" data-liste-vide>
  <p class="doux" data-message-vide<?= $demandes ? ' hidden' : '' ?>>Aucune demande reçue pour l'instant.</p>
    <?php foreach ($demandes as $d): $p = $d['donnees']; ?>
      <article class="carte<?= empty($d['read']) ? ' carte--a-traiter' : '' ?>" data-ligne>
        <div class="rangee" style="justify-content:space-between">
          <div>
            <h2 style="font-size:1.15rem;margin-bottom:.25rem">
              <?= e($p['nom'] ?? 'Sans nom') ?>
              <?php if (!empty($p['entreprise'])): ?>
                <span class="doux" style="font-weight:400">· <?= e($p['entreprise']) ?></span>
              <?php endif; ?>
            </h2>
            <p class="doux" style="margin:0;font-size:.875rem">
              Reçue le <?= e(dateFr($d['created_at'])) ?> à <?= e(substr((string)$d['created_at'], 11, 5)) ?>
            </p>
          </div>
          <?php if (empty($d['read'])): ?><span class="etiquette">Nouveau</span><?php endif; ?>
        </div>

        <div class="rangee" style="margin-top:.75rem">
          <?php if (!empty($p['telephone'])):
            $numero = preg_replace('/\D+/', '', (string)$p['telephone']);
            $numero = str_starts_with($numero, '225') ? $numero : '225' . ltrim($numero, '0'); ?>
            <a class="bouton bouton--whatsapp" href="https://wa.me/<?= e($numero) ?>" target="_blank" rel="noopener">
              <?= icone('whatsapp') ?> <?= e($p['telephone']) ?>
            </a>
            <a class="bouton bouton--contour" href="tel:<?= e($p['telephone']) ?>">Appeler</a>
          <?php endif; ?>
          <?php if (!empty($p['email'])): ?>
            <a class="bouton bouton--contour" href="mailto:<?= e($p['email']) ?>"><?= e($p['email']) ?></a>
          <?php endif; ?>
        </div>

        <?php if (!empty($p['besoin'])): ?>
          <blockquote style="margin:1rem 0 0;padding:.75rem 1rem;background:var(--fond-alt);border-radius:.75rem">
            <?= nl2br(e($p['besoin'])) ?>
          </blockquote>
        <?php endif; ?>

        <div class="rangee" style="margin-top:1rem">
          <?php if (empty($d['read'])): ?>
            <form method="post" action="/admin/demandes/lue" data-async="lue">
              <?= Csrf::champ() ?>
              <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
              <button class="bouton bouton--contour" type="submit"><?= icone('coche') ?> Marquer comme traitée</button>
            </form>
          <?php endif; ?>
          <form method="post" action="/admin/demandes/supprimer"
                data-async="supprimer" data-confirmer="Supprimer définitivement cette demande ?">
            <?= Csrf::champ() ?>
            <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
            <button class="bouton bouton--contour" type="submit">Supprimer</button>
          </form>
        </div>
      </article>
    <?php endforeach; ?>
</div>
