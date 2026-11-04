<?php
/**
 * Accueil — v2, direction « éditorial affirmé ».
 *
 * Le fond ne change pas : ce sont les cinq gains de config/site.php, les trois
 * pertes et les deux cas déjà en ligne. Ce qui change, c'est la manière de les
 * poser — un déroulé de démonstration numéroté (la perte, le gain, la preuve,
 * la méthode) au lieu de six sections de cartes identiques.
 *
 * Aucune photo n'affirme montrer EA-SERVICES : ce sont des photos
 * illustratives d'Abidjan sous licence Wikimedia, créditées en bas de
 * bandeau. Trois images en fondu enchaîné (ea-v2.js) : purement décoratives,
 * la première reste affichée en continu sans JavaScript ou en mouvement
 * réduit — rien ne casse, il n'y a simplement pas de mouvement.
 *
 * @var array $temoignages
 * @var array $articles
 */
$gains  = (array)cfg('gains');
$icones = ['temps' => 'temps', 'conversion' => 'conversion', 'visibilite' => 'visibilite',
           'ca' => 'croissance', 'serenite' => 'serenite'];
?>

<section class="heros">
  <div class="heros__fond" aria-hidden="true">
    <img src="/assets/hero-nuit-900.jpg"
         srcset="/assets/hero-nuit-900.jpg 900w, /assets/hero-nuit-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" fetchpriority="high">
    <img src="/assets/hero-jour-900.jpg"
         srcset="/assets/hero-jour-900.jpg 900w, /assets/hero-jour-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" loading="lazy">
    <img src="/assets/hero-plateau-900.jpg"
         srcset="/assets/hero-plateau-900.jpg 900w, /assets/hero-plateau-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" loading="lazy">
  </div>
  <div class="heros__voile" aria-hidden="true"></div>

  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">01 / La promesse</span>
      <span class="etiquette-section__texte">Agence de développement web et d'automatisation à Abidjan</span>
    </p>

    <h1 class="titre-machine">Vous ne manquez pas de travail.<em>Vous perdez ce qu'il rapporte.</em></h1>

    <p class="heros__badge">
      <?= icone('cible') ?> Agence de développement web &amp; logiciel sur mesure — Abidjan, Côte d'Ivoire
    </p>

    <p class="heros__chapo">
      Les entreprises qui prospèrent ne travaillent pas plus : elles arrêtent de
      perdre. Nous chiffrons ce qui vous échappe chaque mois — en heures, en
      clients, en visibilité — puis nous le récupérons.
    </p>

    <div class="heros__actions">
      <a class="bouton bouton--safran" href="/diagnostic">
        Chiffrer mes deux plus grosses pertes <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour-clair" href="#la-perte">
        Voir ce que ça coûte
      </a>
    </div>

    <p class="heros__promesse"><span class="point-actif"></span><?= e(cfg('cta.promesse')) ?></p>
  </div>

  <?php /* La grille est imbriquée dans .page-large plutôt que de l'être :
           sinon la gouttière du conteneur se peint dans la couleur des
           séparateurs et laisse un liseré parasite de chaque côté. */ ?>
  <div class="page-large">
    <div class="heros__chiffres">
      <div class="heros__chiffre"><strong>420-720 h</strong><span>récupérées par an</span></div>
      <div class="heros__chiffre"><strong>2 min</strong><span>pour répondre à un prospect</span></div>
      <div class="heros__chiffre"><strong>+40 %</strong><span>de demandes venues de Google</span></div>
      <div class="heros__chiffre"><strong>+20 à 40 %</strong><span>de chiffre d'affaires la 1<sup>re</sup> année</span></div>
    </div>
    <p class="heros__note">
      Ce sont nos résultats mesurés chez d'autres entreprises — pas une promesse
      identique pour tous. Chaque activité perd différemment ; le diagnostic
      chiffre la vôtre.
    </p>
  </div>

  <div class="page-large">
    <p class="heros__credit">
      Photo : Abidjan, Wikimedia Commons —
      <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener">CC BY-SA 4.0</a>.
      Emplacement d'une photo réelle d'EA-SERVICES.
    </p>
  </div>
</section>

<?php /* ------------------------------------------------- 02 / LA PERTE */ ?>
<section class="section section--claire" id="la-perte">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">02 / La perte</span>
      <span class="etiquette-section__texte">Ce que ça vous coûte aujourd'hui</span>
    </p>
    <h2 class="mesure">Votre croissance ne disparaît pas.<span class="suite">Elle fuit par endroits.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Ces pertes n'apparaissent sur aucune facture. C'est pour ça qu'on les laisse
      durer — jusqu'à ce qu'on les mette en face d'un chiffre.
    </p>

    <?php /* Le pont entre les deux publics : celui qui a mal (perte) et celui
             qui a de l'ambition (croissance). Le reste de la page garde la
             structure perte→gain — elle marche pour les deux, à condition de
             le dire une fois, clairement, avant d'y entrer. */ ?>
    <p class="mesure-large" style="margin-top:1rem;font-weight:600">
      Que vous partiez d'une perte à arrêter ou d'une croissance à accélérer,
      la question est la même : quel est le prochain chiffre que vous voulez
      voir bouger ? Voici, pour commencer, ce que la plupart des dirigeants
      perdent sans le voir — que vous soyez déjà en avance ou pas.
    </p>

    <div class="releve">
      <div class="releve__ligne">
        <span class="releve__chiffre">420-720 h</span>
        <div>
          <h3>Le temps qui part en tâches répétitives</h3>
          <p class="doux">Relances, suivis, saisies, la même réponse écrite dix fois par
             semaine. Dix à dix-huit semaines de travail par an, que rien n'indique nulle part.</p>
        </div>
        <span class="releve__bascule">tâches → temps récupéré</span>
      </div>
      <div class="releve__ligne">
        <span class="releve__chiffre">30 %</span>
        <div>
          <h3>Les clients qui appellent ailleurs</h3>
          <p class="doux">Cinq minutes sans réponse, et le prospect essaie le concurrent
             suivant. Vous avez payé pour l'attirer ; il part quand même.</p>
        </div>
        <span class="releve__bascule">délai → conversion</span>
      </div>
      <div class="releve__ligne">
        <span class="releve__chiffre">?</span>
        <div>
          <h3>La visibilité que vous ne mesurez jamais</h3>
          <p class="doux">Quelqu'un vous cherche à Abidjan, trouve un autre nom, et vous
             ne le saurez jamais — il ne vous a pas contacté.</p>
        </div>
        <span class="releve__bascule">invisibilité → demandes</span>
      </div>
    </div>
  </div>
</section>

<?php /* -------------------------------------------------- 03 / LE GAIN */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">03 / Le gain</span>
      <span class="etiquette-section__texte">Ce que nous mesurons chaque semaine</span>
    </p>
    <h2 class="mesure">La technique reste derrière.<span class="suite">Le résultat passe devant.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Pas des outils à apprendre. Ces cinq lignes, avec leur chiffre — c'est ce
      que nous nous engageons à vous livrer.
    </p>

    <div class="manifeste">
      <?php $n = 0; foreach ($gains as $cle => $gain): $n++; ?>
        <div class="manifeste__ligne">
          <span class="manifeste__num"><?= sprintf('%02d', $n) ?></span>
          <div class="manifeste__corps">
            <h3><?= e($gain['titre']) ?></h3>
            <p class="doux"><?= e($gain['gain']) ?></p>
          </div>
          <span class="manifeste__impact"><?= e($gain['impact']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <p style="margin-top:2rem">
      <a class="lien-fleche" href="/pages/services">Le détail des cinq gains <?= icone('fleche') ?></a>
    </p>
  </div>
</section>

<?php /* ------------------------------------------------ 04 / LA PREUVE */ ?>
<section class="section section--sable">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">04 / La preuve</span>
      <span class="etiquette-section__texte">Des chiffres avant les adjectifs</span>
    </p>
    <h2 class="mesure">Ce qui change quand<span class="suite">la fuite est traitée.</span></h2>

    <div class="grille grille--2">
      <article class="carte">
        <span class="chapeau">Cabinet de recrutement · Côte d'Ivoire</span>
        <h3>De 10 à 30 placements par mois en six mois</h3>
        <p class="doux">Aucune visibilité en ligne, dix heures de recherche par
           placement, des demandes oubliées faute de suivi.</p>
        <div class="bascules">
          <div class="bascule"><span>Placements par mois</span><strong>10 <b>→</b> 30</strong></div>
          <div class="bascule"><span>Temps par placement</span><strong>10 h <b>→</b> 3 h</strong></div>
          <div class="bascule"><span>Chiffre d'affaires mensuel</span><strong>1 M <b>→</b> 3 M</strong></div>
        </div>
        <span class="investissement">Investissement ~250 000 FCFA / mois, gain ~1 500 000 FCFA / mois.</span>
      </article>

      <article class="carte">
        <span class="chapeau">Agent commercial · Côte d'Ivoire</span>
        <h3>Trois heures récupérées chaque jour</h3>
        <p class="doux">Quatre heures par jour à chercher des prospects, soit 80 %
           du temps passé loin de la vente.</p>
        <div class="bascules">
          <div class="bascule"><span>Prospects qualifiés / jour</span><strong>3 <b>→</b> 15</strong></div>
          <div class="bascule"><span>Temps de recherche / jour</span><strong>4 h <b>→</b> 1 h</strong></div>
          <div class="bascule"><span>Affaires en cours</span><strong>20 <b>→</b> 45</strong></div>
        </div>
        <span class="investissement">3 heures récupérées par jour, huit affaires de plus par mois.</span>
      </article>
    </div>

    <p style="margin-top:1.5rem">
      <a class="lien-fleche" href="/pages/realisations">Lire les cas complets <?= icone('fleche') ?></a>
    </p>

    <?php if ($temoignages): ?>
      <div class="grille grille--3">
        <?php foreach ($temoignages as $t): ?>
          <figure class="carte" style="margin:0">
            <blockquote style="margin:0 0 .75rem;font-size:1.0625rem">« <?= e($t['comment']) ?> »</blockquote>
            <figcaption class="doux" style="font-size:.9375rem">
              <strong><?= e($t['name']) ?></strong>
              <span aria-label="<?= (int)$t['rating'] ?> sur 5" style="color:var(--safran-encre)">
                · <?= str_repeat('★', max(0, min(5, (int)$t['rating']))) ?>
              </span>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <?php /* Règle absolue du projet : jamais un témoignage inventé, et
               jamais un visage généré. Ce bloc dit la même chose que les cas
               chiffrés au-dessus (des faits, pas des adjectifs), et disparaît
               dès qu'un vrai avis est saisi en administration. */ ?>
      <div class="reserve reserve--avis">
        <span class="reserve__icone"><?= icone('cible') ?></span>
        <p class="reserve__titre">Nos clients parlent en chiffres, bientôt en mots</p>
        <p class="reserve__texte">Les cas ci-dessus sont vérifiés et mesurés. Les avis nommés
           de nos clients arrivent ici dès qu'ils nous les confient — jamais avant, jamais inventés.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php /* ----------------------------------------- 05 / PAR OÙ COMMENCER */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">05 / Le point de départ</span>
      <span class="etiquette-section__texte">Vous choisissez par où commencer</span>
    </p>
    <h2 class="mesure">Pas un catalogue.<span class="suite">Un premier gain.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Nous ne menons jamais les cinq chantiers à la fois. Le diagnostic sert à
      trouver les deux qui rapportent le plus chez vous, maintenant.
    </p>

    <div class="grille grille--2">
      <article class="carte">
        <span class="chapeau"><?= icone('cible') ?> Nos services</span>
        <h3>Cinq pertes, cinq façons de les arrêter</h3>
        <p class="doux">Le temps, les clients, la visibilité, le chiffre d'affaires
           et la sérénité — avec un chiffre en face de chacun.</p>
        <p style="margin-top:1rem"><a class="lien-fleche" href="/pages/services">Voir les services <?= icone('fleche') ?></a></p>
      </article>

      <article class="carte">
        <span class="chapeau"><?= icone('document') ?> Nos solutions</span>
        <h3>Trois ensembles qui se renforcent</h3>
        <p class="doux">Présence en ligne, prospection commerciale et recrutement :
           ce que l'un attire, l'autre le convertit, le troisième le retient.</p>
        <p style="margin-top:1rem"><a class="lien-fleche" href="/pages/produits">Voir les solutions <?= icone('fleche') ?></a></p>
      </article>
    </div>
  </div>
</section>

<?php /* ----------------------------------------------- 06 / LA MÉTHODE */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">06 / La méthode</span>
      <span class="etiquette-section__texte">Aucune surprise après le diagnostic</span>
    </p>
    <h2 class="mesure">Vous savez toujours<span class="suite">ce qui vient ensuite.</span></h2>

    <ol class="etapes" style="max-width:44rem">
      <li class="etape">
        <div>
          <h3>Diagnostic — gratuit, 30 minutes</h3>
          <p class="doux">On vous pose des questions et on écoute. On ne vend rien à cette étape.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Recommandation chiffrée</h3>
          <p class="doux">Vos deux priorités, le gain attendu pour chacune, le coût en face. Vous choisissez.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mise en place et formation</h3>
          <p class="doux">On installe, on forme, votre équipe reste autonome sur le quotidien.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mesure chaque semaine</h3>
          <p class="doux">Ce qui marche, on l'amplifie. Ce qui ne marche pas, on l'arrête.</p>
        </div>
      </li>
    </ol>
  </div>
</section>

<?php /* --------------------------------------------- 07 / NOS PRESTATIONS */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">07 / Nos prestations</span>
      <span class="etiquette-section__texte">Ce qu'il y a concrètement dans la boîte à outils</span>
    </p>
    <h2 class="mesure">Six familles.<span class="suite">Un seul point d'entrée : le diagnostic.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem;margin-bottom:1.5rem">
      Présence en ligne, développement sur mesure, automatisation, formation,
      accompagnement, infrastructure — chacune rattachée à l'un des cinq gains
      ci-dessus.
    </p>

    <div class="grille grille--3" style="margin-bottom:1.75rem">
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/presence-en-ligne.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Présence en ligne</h3>
          <p class="doux">Ce qui vous rend trouvable et crédible, du premier clic jusqu'à l'achat.</p>
        </div>
      </article>
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/developpement-sur-mesure.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Développement sur mesure</h3>
          <p class="doux">Quand un site ou un outil standard ne suffit plus, notre équipe de
             développement de logiciel construit exactement ce qu'il vous faut.</p>
        </div>
      </article>
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/automatisation.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Automatisation</h3>
          <p class="doux">Les tâches répétitives tournent sans vous.</p>
        </div>
      </article>
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/formation.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Formation</h3>
          <p class="doux">Pour que votre équipe n'ait plus besoin de nous sur le quotidien.</p>
        </div>
      </article>
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/accompagnement.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Accompagnement</h3>
          <p class="doux">Un regard extérieur régulier sur vos décisions, pas un cours ponctuel.</p>
        </div>
      </article>
      <article class="carte" style="padding:0;overflow:hidden">
        <img src="/assets/prestations/infrastructure.svg" alt="" width="400" height="220"
             style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
        <div style="padding:1.5rem">
          <h3>Infrastructure</h3>
          <p class="doux">Ce qui continue de tourner pendant que vous ne regardez pas.</p>
        </div>
      </article>
    </div>

    <?php /* Accès direct à chaque expertise : ce que les gens cherchent sur Google. */ ?>
    <div class="marqueurs" style="margin-bottom:1.75rem">
      <?php foreach (\EA\Core\Config::expertises() as $slugX => $xp): ?>
        <a class="marqueur" href="/pages/<?= e($slugX) ?>"><?= icone($xp['icone']) ?> <?= e($xp['libelle']) ?></a>
      <?php endforeach; ?>
    </div>

    <a class="bouton bouton--marine" href="/pages/prestations">
      Voir le détail des prestations <?= icone('fleche') ?>
    </a>
  </div>
</section>

<?php if ($articles): ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">08 / Notre blog</span>
      <span class="etiquette-section__texte">Écrit pour ce que les entreprises cherchent vraiment</span>
    </p>
    <h2 class="mesure">Nos derniers articles</h2>

    <div class="grille grille--3">
      <?php foreach (array_slice($articles, 0, 3) as $a): ?>
        <article class="carte">
          <span class="chapeau"><?= e($a['category_label'] ?? '') ?></span>
          <h3><a href="/article/<?= e($a['slug']) ?>" style="text-decoration:none"><?= e($a['title']) ?></a></h3>
          <p class="doux" style="font-size:.9375rem"><?= e($a['excerpt'] ?? '') ?></p>
          <p class="doux" style="font-size:.8125rem;margin-top:1rem">
            <?= e(dateFr($a['created_at'] ?? null)) ?>
            <?php if (!empty($a['read_time'])): ?> · <?= e($a['read_time']) ?> de lecture<?php endif; ?>
          </p>
        </article>
      <?php endforeach; ?>
    </div>

    <p style="margin-top:1.75rem">
      <a class="lien-fleche" href="/pages/blog">Voir tous nos articles <?= icone('fleche') ?></a>
    </p>
  </div>
</section>
<?php endif; ?>

<?php /* ------------------------------------------------ Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">08 / Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Trente minutes pour<span class="suite">voir plus clair.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Vous repartez avec vos deux pertes prioritaires, le gain attendu et une
        décision simple : agir maintenant, ou attendre. Nous ne vendons rien
        pendant cet échange.
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
