<?php
/**
 * Solutions — direction v2.
 *
 * Contenu repris mot pour mot de la version précédente — seule la forme
 * change. Les fonds colorés par gain (.gain--visi, .gain--conv…) de la v1
 * sont remplacés par des cartes neutres avec la ligne d'impact en
 * `.investissement`, comme sur /pages/realisations : la couleur ne porte
 * plus le sens à elle seule (cf. skill ea-design).
 */
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Nos solutions</span>
      <span class="etiquette-section__texte">Trois ensembles qui se renforcent</span>
    </p>
    <h1 class="mesure titre-machine">Trois ensembles<em>qui se renforcent.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Agence de développement web — solutions sur mesure à Abidjan</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Un outil isolé règle un problème et en crée deux. Ces trois ensembles
      sont faits pour fonctionner ensemble : ce que l'un attire, l'autre le
      convertit, le troisième le retient.
    </p>
  </div>
</section>

<?php
/**
 * PLACEHOLDERS TEMPORAIRES (2026-08-06) — mêmes photos que /pages/a-propos,
 * à remplacer par de vraies photos dès qu'elles sont disponibles. Aucune
 * légende n'affirme "c'est nous" ou "notre bureau".
 */
?>
<section class="section section--claire">
  <div class="page-large">
    <div class="grille grille--2">
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-equipe.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;display:block">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Trois solutions, un seul suivi — rien ne se perd entre les dossiers.
        </figcaption>
      </figure>
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-abidjan.jpg" alt="Vue d'Abidjan" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;display:block">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Abidjan — le marché pour lequel ces trois solutions sont pensées.
        </figcaption>
      </figure>
    </div>
    <p class="doux" style="font-size:.6875rem;text-align:right;margin-top:.5rem">
      Photos temporaires — Shixart1985 (CC BY 2.0) et Aman ADO (CC BY-SA 4.0), Wikimedia Commons.
    </p>
  </div>
</section>

<?php /* ------------------------------------------------- Les trois ensembles */ ?>
<section class="section section--papier">
  <div class="page-large">

    <article class="carte" style="margin-bottom:1.5rem">
      <span class="chapeau">Présence Digitale 360°</span>
      <h2 style="margin-bottom:.5rem">On vous trouve, et on vous prend au sérieux</h2>
      <p class="doux">Votre vitrine, vos pages publiques et vos publications, traitées comme
         un tout cohérent — pas comme trois chantiers séparés qu'on abandonne au bout de deux mois.</p>

      <div class="grille grille--2" style="margin-top:1.25rem">
        <div>
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li>Un site rapide sur téléphone, qui dit en cinq secondes ce que vous apportez.</li>
            <li>Des pages construites autour des recherches réelles de vos clients.</li>
            <li>Vos profils publics complets : mêmes informations partout, aucune contradiction.</li>
            <li>Des publications régulières préparées à l'avance.</li>
            <li>Vos avis clients et vos résultats mis en avant, à l'endroit où l'on hésite.</li>
            <li>Une réponse automatique aux questions courantes, à toute heure.</li>
          </ul>
          <span class="investissement"><?= e(cfg('gains.visibilite.impact')) ?></span>
        </div>
        <div>
          <h3>À qui c'est destiné</h3>
          <p class="doux">
            À vous si l'on vous demande encore « vous avez un site ? », si votre
            dernière publication date de plusieurs mois, ou si vos clients viennent
            uniquement par le bouche-à-oreille.
          </p>
          <p class="doux" style="margin-top:.75rem">
            C'est presque toujours le premier chantier : sans visibilité, les deux
            autres solutions travaillent dans le vide.
          </p>
        </div>
      </div>
    </article>

    <article class="carte" style="margin-bottom:1.5rem">
      <span class="chapeau">SFB · Prospection autonome</span>
      <h2 style="margin-bottom:.5rem">Arrêtez de chercher vos clients, occupez-vous de les convaincre</h2>
      <p class="doux">Trouver un prospect n'est pas votre métier. Conclure, si. Cet ensemble
         s'occupe de la première partie pour que vous gardiez la seconde.</p>

      <div class="grille grille--2" style="margin-top:1.25rem">
        <div>
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li>Une liste d'entreprises qui correspondent vraiment à votre cible : secteur, ville, taille.</li>
            <li>Tous vos prospects au même endroit, avec où en est chacun.</li>
            <li>Un premier message personnalisé envoyé pour vous, puis des relances au bon rythme.</li>
            <li>Chaque semaine, la liste de ceux qu'il faut relancer maintenant.</li>
            <li>L'historique complet de chaque échange : vous reprenez une conversation six mois après sans rien avoir oublié.</li>
          </ul>
          <span class="investissement"><?= e(cfg('gains.conversion.impact')) ?></span>
        </div>
        <div>
          <h3>À qui c'est destiné</h3>
          <p class="doux">
            Aux commerciaux, indépendants et petites équipes de vente qui passent
            plus de temps à chercher des contacts qu'à leur parler.
          </p>
          <p class="doux" style="margin-top:.75rem">
            Un agent commercial suivi est passé de trois à quinze prospects
            qualifiés par jour, en récupérant trois heures quotidiennes.
          </p>
        </div>
      </div>
    </article>

    <article class="carte">
      <span class="chapeau">EMPLOI.EA · Recrutement</span>
      <h2 style="margin-bottom:.5rem">Recrutez sans y passer vos soirées</h2>
      <p class="doux">Une annonce publiée, deux cents candidatures, aucune méthode pour les
         trier. Le recrutement mange le temps de ceux qui devraient diriger.</p>

      <div class="grille grille--2" style="margin-top:1.25rem">
        <div>
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li>Votre annonce diffusée là où sont réellement les candidats.</li>
            <li>Un premier tri sur vos critères : seuls les profils recevables remontent jusqu'à vous.</li>
            <li>Une pré-qualification automatique qui vous épargne les entretiens inutiles.</li>
            <li>Tous vos candidats conservés, y compris les non-retenus : le prochain poste part avec une longueur d'avance.</li>
          </ul>
          <span class="investissement">Un recrutement mené en deux fois moins de temps</span>
        </div>
        <div>
          <h3>À qui c'est destiné</h3>
          <p class="doux">
            Aux entreprises qui recrutent plusieurs fois par an et aux cabinets
            de recrutement qui veulent traiter plus de postes sans grossir.
          </p>
          <p class="doux" style="margin-top:.75rem">
            EMPLOI.EA est une solution en service, déjà utilisée par des
            structures en Côte d'Ivoire.
          </p>
        </div>
      </div>
    </article>

  </div>
</section>

<?php /* ------------------------------------------------------ Application mobile */ ?>
<section class="section section--papier">
  <div class="page-large">
    <article class="carte">
      <span class="chapeau">Sonnera · Application Android</span>
      <h2 style="margin-bottom:.5rem">Plus aucune consigne perdue dans un groupe de discussion</h2>
      <p class="doux">Une alarme qui sonne même téléphone verrouillé, des tâches réparties
         entre collègues, et un responsable prévenu quand quelque chose traîne.</p>
      <p style="margin-top:1rem">
        <a class="bouton bouton--marine" href="/pages/sonnera">Découvrir Sonnera <?= icone('fleche') ?></a>
      </p>
    </article>
  </div>
</section>

<?php /* ------------------------------------------------------ L'effet d'ensemble */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">L'effet d'ensemble</span>
      <span class="etiquette-section__texte">Pourquoi les combiner change tout</span>
    </p>
    <h2 class="mesure">Séparément, chacune règle un point.<span class="suite">Ensemble, elles se nourrissent.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Prenons un cabinet de recrutement.
    </p>

    <ol class="etapes" style="max-width:44rem">
      <li class="etape">
        <div>
          <h3>La visibilité amène les demandes</h3>
          <p class="doux">Le site et les publications font arriver des entreprises qui recrutent.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>La prospection va chercher les autres</h3>
          <p class="doux">Celles qui recrutent mais ne vous connaissent pas encore sont contactées directement.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Le recrutement absorbe la charge</h3>
          <p class="doux">Trois fois plus de postes à traiter, sans tripler l'équipe.</p>
        </div>
      </li>
    </ol>

    <p class="mesure-large" style="margin-top:1.5rem;font-weight:600">
      C'est exactement ce parcours qu'a suivi un cabinet de recrutement
      ivoirien : de dix à trente placements par mois en six mois.
      <a href="/pages/realisations">Le détail chiffré est ici.</a>
    </p>
  </div>
</section>

<?php /* ------------------------------------------------------- Investissement */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Investissement</span>
      <span class="etiquette-section__texte">Le prix n'est pas la bonne question</span>
    </p>
    <h2 class="mesure">Est-ce que ça rapporte<span class="suite">plus que ça ne coûte ?</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Nous ne donnons pas de tarif au catalogue, parce qu'un tarif au
      catalogue ne veut rien dire tant qu'on ne connaît pas votre situation.
    </p>
    <p class="mesure-large doux" style="margin-top:1rem">
      Ce que nous vous donnons pendant le diagnostic, en revanche : le montant
      de l'investissement, le gain mensuel attendu en FCFA, et le nombre de
      mois au bout duquel l'un dépasse l'autre. Si ce calcul ne vous est pas
      favorable, nous vous le dirons.
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
      <h2 class="mesure">Laquelle de ces trois solutions<span class="suite">vous rapporterait le plus ?</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes pour savoir laquelle vous rapporterait le plus dès
        maintenant — et lesquelles peuvent attendre.
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
