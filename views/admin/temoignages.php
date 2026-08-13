<?php
/** @var array $temoignages */
use EA\Core\Csrf;
?>
<h1 style="font-size:1.5rem">Témoignages</h1>

<div class="alerte alerte--erreur" style="border-color:var(--or-500);background:var(--or-100);color:var(--texte)">
  <strong>Règle absolue :</strong> n'inscrivez ici que des avis réellement
  donnés par un client, avec son accord. Un faux témoignage engage la parole
  d'une entreprise tierce — c'est la faute la plus grave possible sur ce site.
</div>

<section class="carte" style="margin-bottom:1.5rem">
  <h2 style="font-size:1.15rem">Ajouter un avis réel</h2>
  <form method="post" action="/admin/temoignages/ajouter">
    <?= Csrf::champ() ?>
    <div class="champ">
      <label for="nom">Nom du client ou de l'entreprise</label>
      <input type="text" id="nom" name="nom" required maxlength="120">
    </div>
    <div class="champ">
      <label for="avis">Son avis, dans ses mots</label>
      <textarea id="avis" name="avis" required maxlength="1000"></textarea>
    </div>
    <div class="champ">
      <label for="note">Note</label>
      <select id="note" name="note">
        <?php for ($i = 5; $i >= 1; $i--): ?>
          <option value="<?= $i ?>"><?= str_repeat('★', $i) ?> (<?= $i ?>/5)</option>
        <?php endfor; ?>
      </select>
    </div>
    <button type="submit" class="bouton bouton--marine">Ajouter</button>
  </form>
</section>

<section class="carte">
  <h2 style="font-size:1.15rem"><?= count($temoignages) ?> témoignage<?= count($temoignages) > 1 ? 's' : '' ?></h2>
  <div class="pile" style="margin-top:1rem">
    <?php foreach ($temoignages as $t): ?>
      <div style="border-left:3px solid var(--or-500);padding-left:1rem">
        <p style="margin-bottom:.25rem">« <?= e($t['comment']) ?> »</p>
        <p class="doux" style="font-size:.875rem;margin-bottom:.5rem">
          <strong><?= e($t['name']) ?></strong>
          · <span style="color:var(--or-600)"><?= str_repeat('★', max(0, min(5, (int)$t['rating']))) ?></span>
        </p>
        <form method="post" action="/admin/temoignages/supprimer"
              onsubmit="return confirm('Supprimer ce témoignage ?')">
          <?= Csrf::champ() ?>
          <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
          <button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">Supprimer</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</section>
