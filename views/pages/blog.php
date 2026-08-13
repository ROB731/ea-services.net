<?php
/**
 * Résultats — l'URL /pages/blog est conservée telle quelle (déjà indexée,
 * 56 visites mesurées sur son ancienne version .html).
 *
 * La page rassemble les cas clients chiffrés ET les articles : c'est la page
 * de preuve du site. Un visiteur qui hésite vient ici.
 *
 * @var array $articles
 */
?>

<section class="hero hero--photos">
  <?php $heroPhoto = 'nuit'; require dirname(__DIR__) . '/partials/hero-photo.php'; ?>
  <div class="contenant">
    <p class="sur-titre">Résultats</p>
    <h1 class="mesure">Des cas réels, avec les chiffres</h1>
    <p class="chapo mesure">
      Pas de théorie et pas de superlatifs. Voici trois situations, ce qui a été
      mis en place, et ce que ça a donné.
    </p>
  </div>
</section>

<section class="section">
  <div class="contenant">

    <article class="carte" style="margin-bottom:2rem">
      <span class="etiquette">Cabinet de recrutement · Côte d'Ivoire</span>
      <h2 style="margin-top:.75rem">Multiplier ses placements par trois en six mois</h2>

      <div class="grille grille--2" style="margin-top:1.5rem">
        <div>
          <h3>La situation de départ</h3>
          <p>
            Quinze consultants, une dizaine de placements par mois, des clients
            venus uniquement du réseau personnel du dirigeant. Une croissance
            plafonnée par la taille du carnet d'adresses.
          </p>
          <h3>Ce qui coûtait le plus cher</h3>
          <ul class="liste-cochee">
            <li><span>Aucune présence en ligne : les entreprises qui cherchaient un cabinet ne le trouvaient pas.</span></li>
            <li><span>Dix heures de recherche manuelle par placement.</span></li>
            <li><span>Des demandes reçues puis oubliées, faute d'un endroit unique pour les suivre.</span></li>
          </ul>
        </div>
        <div class="gain gain--conv">
          <h3>Après six mois</h3>
          <div class="defile-x">
            <table class="tableau">
              <thead>
                <tr><th>Indicateur</th><th>Avant</th><th>Après</th></tr>
              </thead>
              <tbody>
                <tr><td>Placements par mois</td><td>10</td><td class="chiffre">30</td></tr>
                <tr><td>Temps par placement</td><td>10 h</td><td class="chiffre">3 h</td></tr>
                <tr><td>Chiffre d'affaires mensuel</td><td>1 M FCFA</td><td class="chiffre">3 M FCFA</td></tr>
                <tr><td>Origine des clients</td><td>Réseau seul</td><td>50 % en ligne</td></tr>
              </tbody>
            </table>
          </div>
          <span class="impact">Investissement ~250 000 FCFA par mois, gain ~1 500 000 FCFA par mois</span>
        </div>
      </div>
    </article>

    <article class="carte" style="margin-bottom:2rem">
      <span class="etiquette">Agent commercial · Côte d'Ivoire</span>
      <h2 style="margin-top:.75rem">Cinq fois plus de prospects, sans une heure de travail en plus</h2>

      <div class="grille grille--2" style="margin-top:1.5rem">
        <div>
          <h3>La situation de départ</h3>
          <p>
            Trois prospects trouvés par jour, à la main. Quatre heures
            quotidiennes passées à chercher des contacts — soit 80 % du temps
            de travail consacré à la partie qui ne rapporte rien.
          </p>
          <h3>Ce qui a été mis en place</h3>
          <ul class="liste-cochee">
            <li><span>Une liste quotidienne d'entreprises correspondant à sa cible.</span></li>
            <li><span>Un premier message envoyé pour lui, puis des relances programmées.</span></li>
            <li><span>Un suivi centralisé pour ne plus laisser tomber une affaire en cours.</span></li>
          </ul>
        </div>
        <div class="gain gain--temps">
          <h3>Après trois mois</h3>
          <div class="defile-x">
            <table class="tableau">
              <thead>
                <tr><th>Indicateur</th><th>Avant</th><th>Après</th></tr>
              </thead>
              <tbody>
                <tr><td>Prospects qualifiés par jour</td><td>3</td><td class="chiffre">15</td></tr>
                <tr><td>Temps de recherche par jour</td><td>4 h</td><td class="chiffre">1 h</td></tr>
                <tr><td>Affaires en cours</td><td>20</td><td class="chiffre">45</td></tr>
                <tr><td>Taux de conclusion</td><td>50 %</td><td>52 %</td></tr>
              </tbody>
            </table>
          </div>
          <span class="impact">3 heures récupérées par jour, huit affaires supplémentaires par mois</span>
        </div>
      </div>
    </article>

    <article class="carte">
      <span class="etiquette">Entreprise de services · Côte d'Ivoire</span>
      <h2 style="margin-top:.75rem">Quinze heures récupérées chaque semaine par le dirigeant</h2>

      <div class="grille grille--2" style="margin-top:1.5rem">
        <div>
          <h3>La situation de départ</h3>
          <p>
            Cinq salariés, un dirigeant à cinquante heures par semaine, dont
            l'essentiel en messages, appels de suivi, saisies et vérifications
            de commandes.
          </p>
          <h3>Ce qui a été mis en place</h3>
          <ul class="liste-cochee">
            <li><span>Les réponses courantes et les relances envoyées automatiquement.</span></li>
            <li><span>Les informations recopiées d'un endroit à l'autre sans intervention.</span></li>
            <li><span>Une sauvegarde quotidienne et une surveillance des pannes.</span></li>
          </ul>
        </div>
        <div class="gain gain--seren">
          <h3>Le résultat</h3>
          <ul class="liste-cochee">
            <li><span><strong class="fort">15 heures par semaine</strong> rendues au dirigeant, soit trois heures par jour.</span></li>
            <li><span>Les oublis de suivi ont chuté de <strong class="fort">80 %</strong>.</span></li>
            <li><span>Une journée complète par semaine réaffectée au développement.</span></li>
          </ul>
          <span class="impact">Investissement ~150 000 FCFA par mois pour une journée de dirigeant récupérée par semaine</span>
        </div>
      </div>
    </article>

  </div>
</section>

<?php if ($articles): ?>
<section class="section section--alt">
  <div class="contenant">
    <p class="sur-titre">Analyses</p>
    <h2>Nos articles</h2>
    <p class="chapo mesure">
      Écrits à partir de ce que les entreprises ivoiriennes cherchent réellement
      sur Google, pas de ce qui nous arrange.
    </p>
    <div class="grille" style="margin-top:1.5rem">
      <?php foreach ($articles as $a): ?>
        <?php require dirname(__DIR__) . '/blog/vignette.php'; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="contenant">
    <p class="sur-titre">Ce que ces cas ont en commun</p>
    <h2 class="mesure">Toujours la même méthode</h2>
    <ol class="etapes" style="margin-top:1.5rem;max-width:44rem">
      <li class="etape"><div><h3>Chiffrer la perte</h3><p class="doux">Combien d'heures, combien de demandes, combien de FCFA — avant de proposer quoi que ce soit.</p></div></li>
      <li class="etape"><div><h3>Traiter les deux plus grosses</h3><p class="doux">Jamais les cinq à la fois : deux chantiers menés à leur terme valent mieux que cinq entamés.</p></div></li>
      <li class="etape"><div><h3>Mesurer chaque semaine</h3><p class="doux">Un gain qu'on ne mesure pas est un gain qu'on ne peut pas défendre.</p></div></li>
    </ol>
  </div>
</section>

<?php
$diagnosticTexte = "Ces entreprises ont commencé par un diagnostic de trente minutes. "
                 . "Le vôtre est gratuit et sans engagement.";
require dirname(__DIR__) . '/partials/diagnostic.php';
?>
