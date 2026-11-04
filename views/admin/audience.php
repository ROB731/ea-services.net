<?php
/** @var array $parJour, $pages, $origines
 *  @var int $total, $robots, $confirmees */
$max = max(1, ...array_map(static fn($j) => (int)$j['n'], $parJour ?: [['n' => 1]]));
?>
<h1 style="font-size:1.5rem">Audience</h1>

<div class="grille">
  <div class="stat">
    <span class="chiffre"><?= number_format($total, 0, ',', ' ') ?></span>
    <span>visites humaines depuis le début</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= number_format(array_sum(array_column($parJour, 'n')), 0, ',', ' ') ?></span>
    <span>sur les 30 derniers jours</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= number_format($confirmees, 0, ',', ' ') ?></span>
    <span>visites confirmées par une vraie interaction (30 jours) : le chiffre fiable</span>
  </div>
  <div class="stat">
    <span class="chiffre"><?= number_format($robots, 0, ',', ' ') ?></span>
    <span>requêtes de robots écartées du comptage</span>
  </div>
</div>

<section class="carte" style="margin-top:1.5rem">
  <h2 style="font-size:1.15rem">30 derniers jours</h2>
  <?php if (!$parJour): ?>
    <p class="doux">Pas encore de données.</p>
  <?php else: ?>
    <div class="defile-x">
      <div style="display:flex;align-items:flex-end;gap:3px;height:9rem;min-width:30rem">
        <?php foreach ($parJour as $j): $h = max(4, (int)round((int)$j['n'] / $max * 100)); ?>
          <div style="flex:1;background:var(--marine-600);border-radius:3px 3px 0 0;height:<?= $h ?>%"
               title="<?= e($j['jour']) ?> : <?= (int)$j['n'] ?> visites"></div>
        <?php endforeach; ?>
      </div>
    </div>
    <p class="doux" style="font-size:.8125rem;margin-top:.5rem">
      Du <?= e(dateFr($parJour[0]['jour'])) ?> au <?= e(dateFr(end($parJour)['jour'])) ?>.
      Maximum sur un jour : <?= $max ?> visites.
    </p>
  <?php endif; ?>
</section>

<div class="grille grille--2" style="margin-top:1.5rem">
  <section class="carte">
    <h2 style="font-size:1.15rem">Pages les plus vues</h2>
    <div class="defile-x">
      <table class="tableau">
        <tbody>
        <?php foreach ($pages as $p): ?>
          <tr><td><?= e($p['path']) ?></td><td class="chiffre"><?= (int)$p['n'] ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="carte">
    <h2 style="font-size:1.15rem">D'où viennent les visiteurs</h2>
    <?php if (!$origines): ?>
      <p class="doux">
        Aucune origine enregistrée. C'est attendu tant que le site n'est pas
        déclaré à la Search Console de Google.
      </p>
    <?php else: ?>
      <div class="defile-x">
        <table class="tableau">
          <tbody>
          <?php foreach ($origines as $o): ?>
            <tr>
              <td style="word-break:break-all"><?= e(mb_substr((string)$o['referrer'], 0, 70)) ?></td>
              <td class="chiffre"><?= (int)$o['n'] ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</div>
