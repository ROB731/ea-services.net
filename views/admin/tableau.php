<?php
/** @var int $visitesHumaines, $visites30j, $demandesNonLues, $articlesPublies, $commentairesEnAttente
 *  @var array $dernieresDemandes, $pagesVues */
?>
<h1 style="font-size:1.5rem">Tableau de bord</h1>

<div class="grille">
  <div class="stat">
    <span class="chiffre"><?= number_format($visites30j, 0, ',', ' ') ?></span>
    <span>visites sur 30 jours</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= number_format($visitesHumaines, 0, ',', ' ') ?></span>
    <span>visites depuis le début (robots exclus)</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= $demandesNonLues ?></span>
    <span>demande<?= $demandesNonLues > 1 ? 's' : '' ?> non lue<?= $demandesNonLues > 1 ? 's' : '' ?></span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= $articlesPublies ?></span>
    <span>articles publiés</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= $commentairesEnAttente ?></span>
    <span>commentaire<?= $commentairesEnAttente > 1 ? 's' : '' ?> à relire</span>
  </div>
</div>

<div class="grille grille--2" style="margin-top:1.5rem">
  <section class="carte">
    <h2 style="font-size:1.15rem">Dernières demandes</h2>
    <?php if (!$dernieresDemandes): ?>
      <p class="doux">Aucune demande pour le moment.</p>
    <?php else: ?>
      <div class="defile-x">
        <table class="tableau">
          <tbody>
          <?php foreach ($dernieresDemandes as $d): $p = json_decode((string)$d['payload_json'], true) ?: []; ?>
            <tr>
              <td>
                <strong><?= e($p['nom'] ?? 'Sans nom') ?></strong>
                <?php if (!empty($p['entreprise'])): ?><span class="doux"> · <?= e($p['entreprise']) ?></span><?php endif; ?>
                <br><span class="doux" style="font-size:.8125rem"><?= e(dateFr($d['created_at'])) ?></span>
              </td>
              <td><?= empty($d['read']) ? '<span class="etiquette">Nouveau</span>' : '' ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p style="margin-top:1rem"><a class="bouton bouton--contour" href="/admin/demandes">Toutes les demandes</a></p>
    <?php endif; ?>
  </section>

  <section class="carte">
    <h2 style="font-size:1.15rem">Pages les plus vues (30 jours)</h2>
    <?php if (!$pagesVues): ?>
      <p class="doux">Pas encore de données.</p>
    <?php else: ?>
      <div class="defile-x">
        <table class="tableau">
          <tbody>
          <?php foreach ($pagesVues as $p): ?>
            <tr><td><?= e($p['path']) ?></td><td class="chiffre"><?= (int)$p['n'] ?></td></tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</div>
