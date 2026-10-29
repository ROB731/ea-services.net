<?php
/**
 * Diagnostic automatique — le questionnaire.
 *
 * Cinq questions, pas une de plus. La doctrine impose le test des cinq
 * secondes : si remplir demande de réfléchir, la page a échoué.
 *
 * Aucune question n'est obligatoire sauf celles qui servent au calcul. Les
 * coordonnées sont facultatives ET c'est écrit : on ne prend pas le résultat
 * en otage contre un numéro de téléphone. La doctrine dit « vous repartez
 * avec, que vous travailliez avec nous ou non » — ça se respecte ici aussi.
 *
 * @var string|null $erreur
 */
?>

<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Diagnostic</span>
      <span class="etiquette-section__texte">Deux minutes, cinq questions</span>
    </p>
    <h1 class="mesure titre-machine">Chiffrez vos pertes<em>avant même qu'on se parle.</em></h1>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Cinq questions sur votre semaine. Vous obtenez immédiatement vos deux plus
      grosses pertes, chiffrées à partir de vos propres réponses. Le calcul est
      montré : vous pouvez le refaire de tête.
    </p>
  </div>
</section>

<section class="section section--papier">
  <div class="page-large">

    <?php if (!empty($erreur)): ?>
      <div class="alerte alerte--erreur" style="max-width:44rem"><?= e($erreur) ?></div>
    <?php endif; ?>

    <form method="post" action="/diagnostic" style="max-width:44rem">
      <?= \EA\Core\Csrf::champ() ?>

      <?php /* Piège à robots : un humain ne le voit pas et ne le remplit jamais. */ ?>
      <div class="piege" aria-hidden="true">
        <label for="site">Ne remplissez pas ce champ</label>
        <input type="text" id="site" name="site" tabindex="-1" autocomplete="off">
      </div>

      <div class="champ">
        <label for="heures">1. Combien d'heures par semaine passez-vous sur des tâches répétitives ?</label>
        <input type="number" id="heures" name="heures" min="0" max="60" step="1" required
               inputmode="numeric" placeholder="Par exemple : 8">
        <span class="champ__aide">Relances, ressaisies d'un carnet vers un fichier, mêmes réponses écrites dix fois.</span>
      </div>

      <div class="champ">
        <label for="delai">2. Quand une demande arrive, en combien de temps répondez-vous ?</label>
        <select id="delai" name="delai" required>
          <option value="">Choisissez…</option>
          <option value="minutes">En quelques minutes</option>
          <option value="heures">En quelques heures</option>
          <option value="demain">Le lendemain</option>
          <option value="parfois">Parfois jamais, faute de temps</option>
        </select>
      </div>

      <div class="champ">
        <label for="demandes">3. Combien de demandes recevez-vous par semaine ?</label>
        <input type="number" id="demandes" name="demandes" min="0" max="500" step="1" required
               inputmode="numeric" placeholder="Par exemple : 12">
        <span class="champ__aide">Appels, messages WhatsApp, formulaires — tout ce qui demande une réponse.</span>
      </div>

      <div class="champ">
        <label for="trouve">4. Comment vos clients vous trouvent-ils, le plus souvent ?</label>
        <select id="trouve" name="trouve" required>
          <option value="">Choisissez…</option>
          <option value="bouche">Par le bouche-à-oreille</option>
          <option value="reseaux">Par les réseaux sociaux</option>
          <option value="google">En cherchant sur Google</option>
          <option value="melange">Un peu de tout</option>
        </select>
      </div>

      <div class="champ">
        <label for="sauvegarde">5. Vos données clients sont-elles sauvegardées ailleurs que sur votre ordinateur ?</label>
        <select id="sauvegarde" name="sauvegarde" required>
          <option value="">Choisissez…</option>
          <option value="oui">Oui, automatiquement</option>
          <option value="non">Non</option>
          <option value="sais-pas">Je ne sais pas</option>
        </select>
      </div>

      <hr style="border:0;border-top:1px solid var(--trait);margin:2rem 0">

      <p class="doux" style="margin-bottom:1.25rem">
        <strong>Vos coordonnées sont facultatives.</strong> Le résultat s'affiche
        de toute façon. Ne les laissez que si vous voulez qu'on vous rappelle
        pour aller plus loin.
      </p>

      <div class="champ">
        <label for="nom">Votre nom</label>
        <input type="text" id="nom" name="nom" autocomplete="name">
      </div>

      <div class="champ">
        <label for="telephone">Téléphone ou WhatsApp</label>
        <input type="tel" id="telephone" name="telephone" autocomplete="tel" inputmode="tel"
               placeholder="01 02 03 04 05">
      </div>

      <div class="champ">
        <label for="email">Courriel</label>
        <input type="email" id="email" name="email" autocomplete="email" inputmode="email">
      </div>

      <button type="submit" class="bouton bouton--safran bouton--large">
        Voir mes deux plus grosses pertes <?= icone('fleche') ?>
      </button>
      <p class="champ__aide" style="margin-top:.75rem">
        Gratuit, sans engagement. Vos réponses servent uniquement à établir ce
        diagnostic et à vous recontacter si vous l'avez demandé.
      </p>
    </form>

  </div>
</section>
