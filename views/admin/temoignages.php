<?php
/** @var array $temoignages
 *  @var array|null $edite */
use EA\Core\Csrf;
$e = $edite ?? null;
?>
<h1 style="font-size:1.5rem"><?= $e ? 'Modifier un témoignage' : 'Témoignages' ?></h1>

<div class="alerte alerte--erreur" style="border-color:var(--or-500);background:var(--or-100);color:var(--texte)">
  <strong>Règle absolue :</strong> n'inscrivez ici que des avis réellement
  donnés par un client, avec son accord. Un faux témoignage engage la parole
  d'une entreprise tierce — c'est la faute la plus grave possible sur ce site.
  Modifier sert à corriger une transcription (faute de frappe, note), jamais
  à changer le sens de ce qu'un client a réellement dit.
</div>

<section class="carte" style="margin-bottom:1.5rem">
  <h2 style="font-size:1.15rem"><?= $e ? 'Modification' : 'Ajouter un avis réel' ?></h2>
  <form method="post" action="/admin/temoignages/enregistrer"
        <?= $e ? '' : 'data-async="ajouter-temoignage"' ?>>
    <?= Csrf::champ() ?>
    <input type="hidden" name="id" value="<?= (int)($e['id'] ?? 0) ?>">
    <div class="champ">
      <label for="nom">Nom du client ou de l'entreprise</label>
      <input type="text" id="nom" name="nom" required maxlength="120" value="<?= e($e['name'] ?? '') ?>">
    </div>
    <div class="champ">
      <label for="avis">Son avis, dans ses mots</label>
      <textarea id="avis" name="avis" required maxlength="1000"><?= e($e['comment'] ?? '') ?></textarea>
      <span class="champ__aide">
        Collez le message réel du client tel quel (WhatsApp, mail…), puis
        <button type="button" id="assistant-corriger-avis" style="border:0;background:none;padding:0;color:var(--marine-600);text-decoration:underline;cursor:pointer;font:inherit">corrigez l'orthographe avec l'assistant</button>
        si besoin — il ne change que la forme, jamais le sens.
      </span>
    </div>
    <div class="champ">
      <label for="note">Note</label>
      <select id="note" name="note">
        <?php for ($i = 5; $i >= 1; $i--): ?>
          <option value="<?= $i ?>" <?= (int)($e['rating'] ?? 5) === $i ? 'selected' : '' ?>>
            <?= str_repeat('★', $i) ?> (<?= $i ?>/5)
          </option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="rangee">
      <button type="submit" class="bouton bouton--marine"><?= $e ? 'Enregistrer' : 'Ajouter' ?></button>
      <?php if ($e): ?><a class="bouton bouton--contour" href="/admin/temoignages">Annuler</a><?php endif; ?>
    </div>
  </form>
</section>

<section class="carte">
  <h2 style="font-size:1.15rem" id="compte-temoignages"><?= count($temoignages) ?> témoignage<?= count($temoignages) > 1 ? 's' : '' ?></h2>
  <div class="pile" style="margin-top:1rem" id="liste-temoignages" data-liste-vide>
    <?php foreach ($temoignages as $t): ?>
      <div data-ligne style="border-left:3px solid var(--or-500);padding-left:1rem">
        <p style="margin-bottom:.25rem">« <?= e($t['comment']) ?> »</p>
        <p class="doux" style="font-size:.875rem;margin-bottom:.5rem">
          <strong><?= e($t['name']) ?></strong>
          · <span style="color:var(--or-600)"><?= str_repeat('★', max(0, min(5, (int)$t['rating']))) ?></span>
        </p>
        <div class="rangee" style="flex-wrap:nowrap">
          <a class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem"
             href="/admin/temoignages/<?= (int)$t['id'] ?>">Modifier</a>
          <form method="post" action="/admin/temoignages/supprimer"
                data-async="supprimer" data-confirmer="Supprimer ce témoignage ?">
            <?= Csrf::champ() ?>
            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
            <button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">Supprimer</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
