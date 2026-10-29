<?php
/**
 * À propos — direction v2.
 *
 * Contenu repris mot pour mot de la version précédente — seule la forme
 * change, pour rejoindre le système de composants du reste du site
 * (cartes neutres plutôt que fonds colorés par gain, supprimés ailleurs sur
 * la v2 : cf. ea-v2.css, « c'était la première cause de fadeur »).
 *
 * Note d'intégrité conservée : la version d'origine affichait « 94 % de
 * satisfaction (92 clients sur 98) », chiffre non vérifiable dans les
 * archives du projet — il n'est pas repris ici. Jamais un chiffre inventé.
 */
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">À propos</span>
      <span class="etiquette-section__texte">Pourquoi EA-SERVICES existe</span>
    </p>
    <h1 class="mesure titre-machine">Pourquoi EA-SERVICES<em>existe.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Agence de développement web à Abidjan, Côte d'Ivoire</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Parce que nous avons vu trop de bonnes entreprises rester petites pour de
      mauvaises raisons.
    </p>
  </div>
</section>

<?php /* --------------------------------------------------------- Constat */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="mesure-large">
      Un dirigeant qui passe soixante heures par semaine sur des tâches qu'une
      machine ferait mieux. Un commercial qui perd une affaire parce qu'il n'a
      pas eu le temps de rappeler. Une entreprise sérieuse que personne ne
      trouve, pendant que son concurrent moins bon récupère les clients.
    </p>
    <p class="mesure-large doux" style="margin-top:1rem">
      Dans aucun de ces cas le problème n'était la compétence. C'était
      l'organisation autour de la compétence.
    </p>
  </div>
</section>

<?php /* ---------------------------------------------------- Notre principe */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Notre principe</span>
      <span class="etiquette-section__texte">Trois questions avant toute proposition</span>
    </p>
    <h2 class="mesure">Il n'existe pas d'achat.<span class="suite">Il n'existe que des investissements.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Quand vous dépensez, vous attendez un retour. Un recrutement doit
      produire plus qu'il ne coûte. Un site doit amener des clients. Sinon ce
      n'est pas un investissement, c'est une dépense. Nous appliquons ce
      principe à nous-mêmes — et si nous n'avons pas les réponses, nous ne
      proposons rien.
    </p>

    <div class="grille grille--3" style="margin-top:1.75rem">
      <article class="carte">
        <h3>Quel problème réel ?</h3>
        <p class="doux">Pas un inconfort théorique : une perte que vous subissez déjà, cette semaine.</p>
      </article>
      <article class="carte">
        <h3>Quel résultat mesurable ?</h3>
        <p class="doux">Combien d'heures, combien de demandes, combien de FCFA. Un chiffre, pas un adjectif.</p>
      </article>
      <article class="carte">
        <h3>Au bout de combien de temps ?</h3>
        <p class="doux">Le mois où le gain dépasse l'investissement. S'il n'arrive jamais, on vous le dit.</p>
      </article>
    </div>
  </div>
</section>

<?php /* ----------------------------------------------------- Notre méthode */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Notre méthode</span>
      <span class="etiquette-section__texte">Quatre étapes, dans cet ordre</span>
    </p>
    <h2 class="mesure">Toujours le même<span class="suite">déroulé.</span></h2>

    <ol class="etapes" style="max-width:44rem">
      <li class="etape">
        <div>
          <h3>Diagnostic — gratuit, 30 minutes</h3>
          <p class="doux">
            Nous vous posons des questions sur votre façon de travailler et
            nous écoutons. Nous ne vendons rien à cette étape, et ce n'est pas
            une formule de politesse : tant que nous ne savons pas où vous
            perdez, nous n'avons rien à vous proposer.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Recommandation sur mesure</h3>
          <p class="doux">
            Jamais de formule toute faite. Vos deux priorités du moment, le
            gain attendu pour chacune, l'investissement en face. Vous
            choisissez par où commencer, ou vous décidez d'attendre.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mise en place et formation</h3>
          <p class="doux">
            Nous installons, puis nous formons votre équipe. L'objectif est
            que vous n'ayez pas besoin de nous pour faire tourner le
            quotidien.
          </p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mesure et ajustement</h3>
          <p class="doux">
            Chaque semaine : qu'est-ce qui a produit un résultat ? On
            l'amplifie. Qu'est-ce qui n'a rien donné ? On l'arrête, sans le
            défendre.
          </p>
        </div>
      </li>
    </ol>
  </div>
</section>

<?php /* --------------------------------------------------- Nos engagements */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Nos engagements</span>
      <span class="etiquette-section__texte">Sur quoi vous pouvez nous juger</span>
    </p>
    <h2 class="mesure">Quatre choses,<span class="suite">vérifiables.</span></h2>

    <div class="grille grille--2" style="margin-top:1.75rem">
      <article class="carte">
        <h3><?= icone('document', 'ico ico--lg') ?> Transparence</h3>
        <p class="doux">Nous expliquons ce que nous faisons, en français, sans vocabulaire
           technique. Si une prestation coûte 500 000 FCFA, nous disons ce que vous obtenez en retour.</p>
      </article>
      <article class="carte">
        <h3><?= icone('cible', 'ico ico--lg') ?> Résultats mesurés</h3>
        <p class="doux">Nous ne nous contentons pas de « ça marche bien ». Nous comparons
           avant et après, avec des chiffres que vous pouvez vérifier vous-même.</p>
      </article>
      <article class="carte">
        <h3><?= icone('coche', 'ico ico--lg') ?> Pas de dépendance</h3>
        <p class="doux">Nous vous formons pour que vous soyez autonome. Un prestataire dont
           on ne peut pas se passer est un risque, pas un partenaire.</p>
      </article>
      <article class="carte">
        <h3><?= icone('serenite', 'ico ico--lg') ?> Sur la durée</h3>
        <p class="doux">Nous ne livrons pas un projet avant de disparaître. Nous gagnons
           quand vous gagnez — c'est le seul modèle qui tienne.</p>
      </article>
    </div>
  </div>
</section>

<?php /* ----------------------------------------------------- Qui nous sommes */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Qui nous sommes</span>
      <span class="etiquette-section__texte">Une équipe basée à Abidjan</span>
    </p>
    <h2 class="mesure">Nous connaissons le marché<span class="suite">parce que nous y sommes.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Nous travaillons depuis <?= e(cfg('contact.quartier')) ?>, à <?= e(cfg('contact.ville')) ?>,
      avec des entreprises ivoiriennes. Nous accompagnons des cabinets de
      recrutement, des agents commerciaux, des entreprises de services et des
      indépendants — sur la visibilité, la prospection, le recrutement et
      l'organisation du quotidien.
    </p>

    <?php
    /**
     * PLACEHOLDERS TEMPORAIRES (2026-08-06) — à remplacer dès que le
     * dirigeant fournit de vraies photos (demandé explicitement, en
     * attente). Aucune légende n'affirme "c'est nous" ou "nos bureaux".
     */
    ?>
    <div class="grille grille--2" style="margin-top:1.75rem">
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-equipe.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;display:block">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Le suivi d'un dossier client — mesuré, semaine après semaine.
        </figcaption>
      </figure>
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-abidjan.jpg" alt="Vue d'Abidjan" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;display:block">
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

<?php /* ------------------------------------------------------ Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">La meilleure façon de savoir<span class="suite">si nous pouvons vous aider.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes pour en parler. Si nous ne sommes pas la bonne
        solution, nous vous le dirons.
      </p>
    </div>
    <div class="diagnostic__actions">
      <a class="bouton bouton--safran" href="/diagnostic">
        <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
        <?= icone('whatsapp') ?> Écrire sur WhatsApp
      </a>
      <span class="diagnostic__note"><?= e(cfg('cta.promesse')) ?></span>
    </div>
  </div>
</section>
