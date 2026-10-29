<?php
/**
 * Une ligne du constructeur de sections — partagée entre le rendu serveur
 * (sections déjà enregistrées) et le gabarit cloné par admin.js pour une
 * nouvelle section. `$i` est un index (entier ou "__INDEX__" dans le
 * gabarit JS) utilisé tel quel dans les noms de champs `sections[$i][...]`.
 *
 * @var int|string $i
 * @var array $s
 */
$s = $s ?? [];
?>
<div class="carte" style="margin-bottom:.75rem;padding:1rem" data-section>
  <div class="champ">
    <label>Intertitre de la section (facultatif)</label>
    <input type="text" name="sections[<?= $i ?>][heading]" maxlength="200" value="<?= e($s['heading'] ?? '') ?>">
  </div>
  <div class="champ">
    <label>Texte de la section</label>
    <textarea name="sections[<?= $i ?>][body]" style="min-height:6rem"><?= e($s['body'] ?? '') ?></textarea>
  </div>
  <div class="champ">
    <label>Photo de la section (facultatif)</label>
    <div class="rangee" style="align-items:flex-start">
      <input type="text" name="sections[<?= $i ?>][image]" value="<?= e($s['image_url'] ?? '') ?>"
             placeholder="/uploads/articles/…" style="flex:1;min-width:12rem" data-section-image>
      <label class="bouton bouton--contour" style="min-height:2.75rem;cursor:pointer" data-televerser-image>
        Choisir une photo
        <input type="file" accept="image/jpeg,image/png,image/webp,image/gif" hidden>
      </label>
    </div>
    <img src="<?= e($s['image_url'] ?? '') ?>" alt="" data-section-apercu
         style="<?= empty($s['image_url']) ? 'display:none;' : '' ?>margin-top:.75rem;max-width:12rem;border-radius:var(--arrondi);display:block">
    <div data-section-bloc-prompt hidden style="margin-top:.5rem">
      <label style="font-size:.8125rem;font-weight:600">Prompt image — à coller dans ChatGPT/DALL·E</label>
      <div class="rangee" style="align-items:flex-start;flex-wrap:nowrap">
        <textarea data-section-prompt-image readonly style="min-height:3.5rem;font-size:.8125rem;flex:1"></textarea>
        <button type="button" class="bouton bouton--contour" data-copier-prompt
                style="min-height:2.75rem;white-space:nowrap">Copier</button>
      </div>
    </div>
  </div>
  <div class="champ">
    <label>Vidéo de la section (facultatif)</label>
    <input type="url" name="sections[<?= $i ?>][video]" value="<?= e($s['video_url'] ?? '') ?>"
           placeholder="Lien YouTube ou Vimeo" data-section-video>
    <span class="champ__aide">Un lien classique suffit, ex. https://www.youtube.com/watch?v=…</span>
    <p class="doux" data-section-suggestion-video style="font-size:.8125rem;margin-top:.25rem;font-style:italic"></p>
  </div>
  <button type="button" class="bouton bouton--contour" data-supprimer-section
          style="min-height:2.25rem;padding:.25rem .625rem">Supprimer cette section</button>
</div>
