<?php
/**
 * À propos.
 *
 * Note d'intégrité : la version précédente affichait « 94 % de satisfaction
 * (92 clients satisfaits sur 98) ». Ce chiffre n'est adossé à aucune enquête
 * vérifiable dans les archives du projet — il n'est donc pas repris ici.
 * Règle du projet : jamais un chiffre de résultat inventé.
 */
?>

<section class="hero hero--photos">
  <?php $heroPhoto = 'plateau'; require dirname(__DIR__) . '/partials/hero-photo.php'; ?>
  <div class="contenant">
    <p class="sur-titre">À propos</p>
    <h1 class="mesure">Pourquoi EA-SERVICES existe</h1>
    <p class="chapo mesure">
      Parce que nous avons vu trop de bonnes entreprises rester petites pour de
      mauvaises raisons.
    </p>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <div class="mesure">
      <p>
        Un dirigeant qui passe soixante heures par semaine sur des tâches qu'une
        machine ferait mieux. Un commercial qui perd une affaire parce qu'il n'a
        pas eu le temps de rappeler. Une entreprise sérieuse que personne ne
        trouve, pendant que son concurrent moins bon récupère les clients.
      </p>
      <p>
        Dans aucun de ces cas le problème n'était la compétence. C'était
        l'organisation autour de la compétence.
      </p>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="contenant">
    <p class="sur-titre">Notre principe</p>
    <h2 class="mesure">Il n'existe pas d'achat, il n'existe que des investissements</h2>
    <p class="chapo mesure">
      Quand vous dépensez, vous attendez un retour. Un repas supprime la faim.
      Un recrutement doit produire plus qu'il ne coûte. Un site doit amener des
      clients. Sinon ce n'est pas un investissement, c'est une dépense.
    </p>
    <p class="mesure">
      Nous appliquons ce principe à nous-mêmes. Avant de vous proposer quoi que
      ce soit, nous répondons à trois questions — et si nous n'y arrivons pas,
      nous ne le proposons pas :
    </p>

    <div class="grille" style="margin-top:1.5rem">
      <div class="gain gain--seren">
        <h3>Quel problème réel ?</h3>
        <p>Pas un inconfort théorique : une perte que vous subissez déjà, cette semaine.</p>
      </div>
      <div class="gain gain--conv">
        <h3>Quel résultat mesurable ?</h3>
        <p>Combien d'heures, combien de demandes, combien de FCFA. Un chiffre, pas un adjectif.</p>
      </div>
      <div class="gain gain--ca">
        <h3>Au bout de combien de temps ?</h3>
        <p>Le mois où le gain dépasse l'investissement. S'il n'arrive jamais, on vous le dit.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <p class="sur-titre">Notre méthode</p>
    <h2 class="mesure">Quatre étapes, dans cet ordre</h2>

    <ol class="etapes" style="margin-top:2rem;max-width:44rem">
      <li class="etape">
        <div>
          <h3>Diagnostic — gratuit, 30 minutes</h3>
          <p class="doux">
            Nous vous posons des questions sur votre façon de travailler et nous
            écoutons. Nous ne vendons rien à cette étape, et ce n'est pas une
            formule de politesse : tant que nous ne savons pas où vous perdez,
            nous n'avons rien à vous proposer.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Recommandation sur mesure</h3>
          <p class="doux">
            Jamais de formule toute faite. Vos deux priorités du moment, le gain
            attendu pour chacune, l'investissement en face. Vous choisissez par
            où commencer, ou vous décidez d'attendre.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mise en place et formation</h3>
          <p class="doux">
            Nous installons, puis nous formons votre équipe. L'objectif est que
            vous n'ayez pas besoin de nous pour faire tourner le quotidien.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mesure et ajustement</h3>
          <p class="doux">
            Chaque semaine : qu'est-ce qui a produit un résultat ? On l'amplifie.
            Qu'est-ce qui n'a rien donné ? On l'arrête, sans le défendre.
          </p>
        </div>
      </li>
    </ol>
  </div>
</section>

<section class="section section--alt">
  <div class="contenant">
    <p class="sur-titre">Nos engagements</p>
    <h2 class="mesure">Quatre choses sur lesquelles vous pouvez nous juger</h2>

    <div class="grille" style="margin-top:1.5rem">
      <div class="carte">
        <h3><?= icone('document', 'ico ico--lg') ?> Transparence</h3>
        <p>Nous expliquons ce que nous faisons, en français, sans vocabulaire technique. Si une prestation coûte 500 000 FCFA, nous disons ce que vous obtenez en retour.</p>
      </div>
      <div class="carte">
        <h3><?= icone('cible', 'ico ico--lg') ?> Résultats mesurés</h3>
        <p>Nous ne nous contentons pas de « ça marche bien ». Nous comparons avant et après, avec des chiffres que vous pouvez vérifier vous-même.</p>
      </div>
      <div class="carte">
        <h3><?= icone('coche', 'ico ico--lg') ?> Pas de dépendance</h3>
        <p>Nous vous formons pour que vous soyez autonome. Un prestataire dont on ne peut pas se passer est un risque, pas un partenaire.</p>
      </div>
      <div class="carte">
        <h3><?= icone('serenite', 'ico ico--lg') ?> Sur la durée</h3>
        <p>Nous ne livrons pas un projet avant de disparaître. Nous gagnons quand vous gagnez — c'est le seul modèle qui tienne.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <p class="sur-titre">Qui nous sommes</p>
    <h2 class="mesure">Une équipe basée à Abidjan</h2>
    <p class="chapo mesure">
      Nous travaillons depuis <?= e(cfg('contact.quartier')) ?>, à <?= e(cfg('contact.ville')) ?>,
      avec des entreprises ivoiriennes. Nous connaissons le marché parce que
      nous y sommes.
    </p>
    <p class="mesure">
      Nous accompagnons des cabinets de recrutement, des agents commerciaux, des
      entreprises de services et des indépendants — sur la visibilité, la
      prospection, le recrutement et l'organisation du quotidien.
    </p>

    <?php
    /**
     * PLACEHOLDERS TEMPORAIRES (2026-08-06) — à remplacer dès que le
     * dirigeant fournit de vraies photos (demandé explicitement, en attente).
     * Aucune des deux légendes n'affirme "c'est nous" ou "ce sont nos
     * bureaux" — ni l'un ni l'autre ne serait vrai pour l'instant, et la
     * règle du projet interdit d'attribuer une photo à une réalité qu'elle
     * ne montre pas. Dès réception des vraies photos, remplacer les fichiers
     * public/assets/temporaire-equipe.jpg et temporaire-abidjan.jpg et retirer
     * ce commentaire.
     */
    ?>
    <div class="grille grille--2" style="margin-top:2.5rem">
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-equipe.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Le suivi d'un dossier client — mesuré, semaine après semaine.
        </figcaption>
      </figure>
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-abidjan.jpg" alt="Vue d'Abidjan" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Abidjan — là où nous travaillons, avec vous.
        </figcaption>
      </figure>
    </div>
    <p class="doux" style="font-size:.6875rem;text-align:right;margin-top:.5rem">
      Photos temporaires — Shixart1985 (CC BY 2.0) et Aman ADO (CC BY-SA 4.0), Wikimedia Commons.
    </p>
  </div>
</section>

<?php
$diagnosticTexte = "La meilleure façon de savoir si nous pouvons vous aider est de nous parler "
                 . "trente minutes. Si nous ne sommes pas la bonne solution, nous vous le dirons.";
require dirname(__DIR__) . '/partials/diagnostic.php';
?>
