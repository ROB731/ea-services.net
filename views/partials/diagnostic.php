<?php
/**
 * L'appel à l'action unique du site. Toute page finit ici — accueil,
 * services, solutions, résultats, à propos, et jusqu'au bas des articles.
 * Un seul chemin de conversion, jamais deux propositions concurrentes.
 *
 * @var string|null $diagnosticTexte Accroche adaptée à la page (facultatif).
 */
$texte = $diagnosticTexte
    ?? "Trente minutes pour comprendre comment vous travaillez aujourd'hui, "
     . "identifier vos deux plus grosses pertes, et chiffrer ce que vous "
     . "récupérez. Nous ne vendons rien pendant cet échange.";
?>
<section class="section">
  <div class="contenant">
    <div class="diagnostic">
      <h2><?= e(cfg('cta.titre')) ?></h2>
      <p class="mesure centre"><?= e($texte) ?></p>
      <div class="rangee">
        <a class="bouton bouton--or" href="/pages/contact">
          <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
        </a>
        <a class="bouton bouton--whatsapp" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
          <?= icone('whatsapp') ?> Écrire sur WhatsApp
        </a>
      </div>
      <span class="diagnostic__promesse"><?= e(cfg('cta.promesse')) ?></span>
    </div>
  </div>
</section>
