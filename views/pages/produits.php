<?php
/**
 * Solutions.
 *
 * Trois ensembles, présentés par le résultat qu'ils produisent. Le nom
 * commercial vient en second, comme une étiquette — jamais comme titre :
 * un client ne cherche pas « SFB », il cherche à arrêter de perdre des
 * prospects.
 */
?>

<section class="hero hero--photos">
  <?php $heroPhoto = 'jour'; require dirname(__DIR__) . '/partials/hero-photo.php'; ?>
  <div class="contenant">
    <p class="sur-titre">Nos solutions</p>
    <h1 class="mesure">Trois ensembles qui se renforcent</h1>
    <p class="chapo mesure">
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
<section class="section section--serre">
  <div class="contenant">
    <div class="grille grille--2">
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-equipe.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Trois solutions, un seul suivi — rien ne se perd entre les dossiers.
        </figcaption>
      </figure>
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-abidjan.jpg" alt="Vue d'Abidjan" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
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

<section class="section">
  <div class="contenant">

    <article class="carte" style="margin-bottom:2rem">
      <span class="etiquette">Présence Digitale 360°</span>
      <h2 style="margin-top:.75rem">On vous trouve, et on vous prend au sérieux</h2>
      <p class="chapo">
        Votre vitrine, vos pages publiques et vos publications, traitées comme
        un tout cohérent — pas comme trois chantiers séparés qu'on abandonne
        au bout de deux mois.
      </p>
      <div class="grille" style="margin-top:1.5rem">
        <div class="gain gain--visi">
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li><span>Un site rapide sur téléphone, qui dit en cinq secondes ce que vous apportez.</span></li>
            <li><span>Des pages construites autour des recherches réelles de vos clients.</span></li>
            <li><span>Vos profils publics complets : mêmes informations partout, aucune contradiction.</span></li>
            <li><span>Des publications régulières préparées à l'avance.</span></li>
            <li><span>Vos avis clients et vos résultats mis en avant, à l'endroit où l'on hésite.</span></li>
            <li><span>Une réponse automatique aux questions courantes, à toute heure.</span></li>
          </ul>
          <span class="impact"><?= e(cfg('gains.visibilite.impact')) ?></span>
        </div>
        <div class="gain gain--seren">
          <h3>À qui c'est destiné</h3>
          <p>
            À vous si l'on vous demande encore « vous avez un site ? », si votre
            dernière publication date de plusieurs mois, ou si vos clients viennent
            uniquement par le bouche-à-oreille.
          </p>
          <p class="doux">
            C'est presque toujours le premier chantier : sans visibilité, les deux
            autres solutions travaillent dans le vide.
          </p>
        </div>
      </div>
    </article>

    <article class="carte" style="margin-bottom:2rem">
      <span class="etiquette">SFB · Prospection autonome</span>
      <h2 style="margin-top:.75rem">Arrêtez de chercher vos clients, occupez-vous de les convaincre</h2>
      <p class="chapo">
        Trouver un prospect n'est pas votre métier. Conclure, si. Cet ensemble
        s'occupe de la première partie pour que vous gardiez la seconde.
      </p>
      <div class="grille" style="margin-top:1.5rem">
        <div class="gain gain--conv">
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li><span>Une liste d'entreprises qui correspondent vraiment à votre cible : secteur, ville, taille.</span></li>
            <li><span>Tous vos prospects au même endroit, avec où en est chacun.</span></li>
            <li><span>Un premier message personnalisé envoyé pour vous, puis des relances au bon rythme.</span></li>
            <li><span>Chaque semaine, la liste de ceux qu'il faut relancer maintenant.</span></li>
            <li><span>L'historique complet de chaque échange : vous reprenez une conversation six mois après sans rien avoir oublié.</span></li>
          </ul>
          <span class="impact"><?= e(cfg('gains.conversion.impact')) ?></span>
        </div>
        <div class="gain gain--temps">
          <h3>À qui c'est destiné</h3>
          <p>
            Aux commerciaux, indépendants et petites équipes de vente qui passent
            plus de temps à chercher des contacts qu'à leur parler.
          </p>
          <p class="doux">
            Un agent commercial suivi est passé de trois à quinze prospects
            qualifiés par jour, en récupérant trois heures quotidiennes.
          </p>
        </div>
      </div>
    </article>

    <article class="carte">
      <span class="etiquette">EMPLOI.EA · Recrutement</span>
      <h2 style="margin-top:.75rem">Recrutez sans y passer vos soirées</h2>
      <p class="chapo">
        Une annonce publiée, deux cents candidatures, aucune méthode pour les
        trier. Le recrutement mange le temps de ceux qui devraient diriger.
      </p>
      <div class="grille" style="margin-top:1.5rem">
        <div class="gain gain--ca">
          <h3>Ce que vous obtenez</h3>
          <ul class="liste-cochee">
            <li><span>Votre annonce diffusée là où sont réellement les candidats.</span></li>
            <li><span>Un premier tri sur vos critères : seuls les profils recevables remontent jusqu'à vous.</span></li>
            <li><span>Une pré-qualification automatique qui vous épargne les entretiens inutiles.</span></li>
            <li><span>Tous vos candidats conservés, y compris les non-retenus : le prochain poste part avec une longueur d'avance.</span></li>
          </ul>
          <span class="impact">Un recrutement mené en deux fois moins de temps</span>
        </div>
        <div class="gain gain--seren">
          <h3>À qui c'est destiné</h3>
          <p>
            Aux entreprises qui recrutent plusieurs fois par an et aux cabinets
            de recrutement qui veulent traiter plus de postes sans grossir.
          </p>
          <p class="doux">
            EMPLOI.EA est une solution en service, déjà utilisée par des
            structures en Côte d'Ivoire.
          </p>
        </div>
      </div>
    </article>

  </div>
</section>

<section class="section section--alt">
  <div class="contenant">
    <p class="sur-titre">L'effet d'ensemble</p>
    <h2 class="mesure">Pourquoi les combiner change tout</h2>
    <p class="chapo mesure">
      Prenons un cabinet de recrutement. Séparément, chaque solution règle un
      point. Ensemble, elles se nourrissent :
    </p>

    <ol class="etapes" style="margin-top:2rem;max-width:44rem">
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

    <p class="mesure" style="margin-top:1.5rem">
      <strong class="fort">C'est exactement ce parcours</strong> qu'a suivi un cabinet
      de recrutement ivoirien : de dix à trente placements par mois en six mois.
      <a href="/pages/blog">Le détail chiffré est ici.</a>
    </p>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <p class="sur-titre">Investissement</p>
    <h2 class="mesure">Le prix n'est pas la bonne question</h2>
    <p class="chapo mesure">
      La bonne question est : est-ce que ça rapporte plus que ça ne coûte ?
      Nous ne donnons pas de tarif au catalogue, parce qu'un tarif au catalogue
      ne veut rien dire tant qu'on ne connaît pas votre situation.
    </p>
    <p class="mesure">
      Ce que nous vous donnons pendant le diagnostic, en revanche : le montant
      de l'investissement, le gain mensuel attendu en FCFA, et le nombre de mois
      au bout duquel l'un dépasse l'autre. Si ce calcul ne vous est pas favorable,
      nous vous le dirons.
    </p>
  </div>
</section>

<?php
$diagnosticTexte = "Trente minutes pour savoir laquelle de ces trois solutions vous rapporterait "
                 . "le plus dès maintenant — et lesquelles peuvent attendre.";
require dirname(__DIR__) . '/partials/diagnostic.php';
?>
