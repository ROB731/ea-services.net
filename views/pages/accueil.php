<?php
/**
 * Accueil.
 *
 * Test des 5 secondes : le titre dit ce qu'on obtient, le sous-titre dit
 * comment, et le bouton dit quoi faire. Aucun outil n'est nommé au-dessus
 * de la ligne de flottaison.
 *
 * @var array $temoignages
 * @var array $articles
 */
$gains = (array)cfg('gains');
?>

<section class="hero hero--photos">
  <div class="hero__fond" aria-hidden="true">
    <img src="/assets/hero-nuit-900.jpg" srcset="/assets/hero-nuit-900.jpg 900w, /assets/hero-nuit-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" fetchpriority="high">
    <img src="/assets/hero-jour-900.jpg" srcset="/assets/hero-jour-900.jpg 900w, /assets/hero-jour-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" loading="lazy">
    <img src="/assets/hero-plateau-900.jpg" srcset="/assets/hero-plateau-900.jpg 900w, /assets/hero-plateau-1920.jpg 1920w"
         sizes="100vw" alt="" width="1920" height="864" loading="lazy">
  </div>
  <div class="hero__scrim" aria-hidden="true"></div>

  <div class="contenant" style="position:relative;z-index:2">
    <p class="sur-titre">Entreprises et indépendants en Côte d'Ivoire</p>
    <h1 class="mesure">Augmentez vos résultats sans augmenter vos coûts</h1>
    <p class="chapo mesure">
      Les entreprises qui prospèrent ne travaillent pas plus : elles arrêtent
      de perdre. Nous identifions ce que vous perdez chaque mois — en heures,
      en clients, en visibilité — puis nous le récupérons, avec un chiffre en face.
    </p>

    <div class="rangee" style="margin-top:1.5rem">
      <a class="bouton bouton--or" href="/pages/contact">
        <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour" href="/pages/services" style="color:#fff;border-color:rgba(255,255,255,.3)">
        Voir comment
      </a>
    </div>
    <p style="margin-top:.75rem;font-size:.875rem;color:var(--or-400);font-weight:600">
      <?= e(cfg('cta.promesse')) ?>
    </p>

    <div class="hero__preuves">
      <div class="hero__preuve">
        <span class="chiffre">420 à 720 h</span>
        <span>récupérées par an</span>
      </div>
      <div class="hero__preuve">
        <span class="chiffre">2 min</span>
        <span>pour répondre à un prospect</span>
      </div>
      <div class="hero__preuve">
        <span class="chiffre">+40 %</span>
        <span>de demandes venues de Google</span>
      </div>
      <div class="hero__preuve">
        <span class="chiffre">+20 à 40 %</span>
        <span>de chiffre d'affaires la 1<sup>re</sup> année</span>
      </div>
    </div>

    <?php /* Attribution requise par la licence CC BY-SA 4.0 des photos
            (Wikimedia Commons) : discrète, mais honnête et présente. */ ?>
    <p class="hero__credit">
      Photos : Abidjan, Wikimedia Commons —
      <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener">CC BY-SA 4.0</a>
    </p>
  </div>
</section>

<?php /* 1. La perte subie — un relevé sobre, pas trois cartes identiques :
          le chiffre parle, le décor n'est pas nécessaire pour se reconnaître. */ ?>
<section class="section">
  <div class="contenant">
    <div class="duo">
      <div>
        <div class="entete-section">
          <p class="sur-titre">Ce que ça vous coûte, aujourd'hui</p>
          <h2 class="mesure">Trois pertes invisibles qui freinent votre croissance</h2>
          <p class="chapo mesure">
            Elles n'apparaissent sur aucune facture. C'est pour ça qu'on les laisse durer
            — jusqu'à ce qu'on les mette en face d'un chiffre.
          </p>
        </div>

        <div class="releve" style="--ton:var(--perte)">
          <div class="releve__ligne">
            <span class="releve__chiffre">420-720 h</span>
            <div class="releve__corps">
              <h3>Le temps qui part en tâches répétitives</h3>
              <p class="doux">
                Relances, suivis, saisies, la même réponse écrite dix fois par semaine — dix à
                dix-huit semaines de travail perdues chaque année, sans que rien ne l'indique nulle part.
              </p>
            </div>
          </div>
          <div class="releve__ligne">
            <span class="releve__chiffre">30 %</span>
            <div class="releve__corps">
              <h3>Les clients qui appellent ailleurs</h3>
              <p class="doux">
                Cinq minutes sans réponse, et un prospect essaie le concurrent suivant. Vous avez
                payé pour l'attirer ; il part quand même.
              </p>
            </div>
          </div>
          <div class="releve__ligne">
            <span class="releve__chiffre">?</span>
            <div class="releve__corps">
              <h3>La visibilité qu'on ne mesure jamais</h3>
              <p class="doux">
                Quelqu'un vous cherche sur Google, trouve un concurrent, et vous ne le saurez
                jamais — il ne vous a pas contacté.
              </p>
            </div>
          </div>
        </div>
      </div>

      <?php /* PLACEHOLDER TEMPORAIRE — à remplacer par une vraie photo. */ ?>
      <figure class="duo__image">
        <img src="/assets/temporaire-reponse.jpg" alt="" loading="lazy" width="900" height="1200">
        <figcaption>Une demande qui attend — c'est exactement ce que ces trois pertes coûtent.</figcaption>
      </figure>
    </div>
  </div>
</section>

<?php /* 2. Le gain chiffré — les cinq gains en manifeste numéroté, pas cinq
          cartes identiques : la variation de traitement entre cette section
          et /pages/services (qui garde les cartes) évite de répéter deux
          fois la même composition pour le même contenu. */ ?>
<section class="section section--alt">
  <div class="contenant">
    <div class="duo">
      <?php /* PLACEHOLDER TEMPORAIRE — à remplacer par une vraie photo. */ ?>
      <figure class="duo__image">
        <img src="/assets/temporaire-equipe.jpg" alt="" loading="lazy" width="900" height="1200">
        <figcaption>Ce qu'on mesure, semaine après semaine.</figcaption>
      </figure>

      <div>
        <div class="entete-section">
          <p class="sur-titre">Ce qu'on change</p>
          <h2 class="mesure">Cinq résultats, mesurés chaque semaine</h2>
          <p class="chapo mesure">
            Pas des outils à apprendre. Ces cinq lignes, avec leur chiffre — c'est ce qu'on
            s'engage à vous livrer.
          </p>
        </div>

        <div class="manifeste">
          <div class="manifeste__ligne" style="--ton:var(--gain-temps)">
            <span class="manifeste__num">01</span>
            <div class="manifeste__corps">
              <h3><?= e($gains['temps']['titre']) ?></h3>
              <p class="doux"><?= e($gains['temps']['gain']) ?></p>
            </div>
            <span class="manifeste__impact"><?= e($gains['temps']['impact']) ?></span>
          </div>
          <div class="manifeste__ligne" style="--ton:var(--gain-conv)">
            <span class="manifeste__num">02</span>
            <div class="manifeste__corps">
              <h3><?= e($gains['conversion']['titre']) ?></h3>
              <p class="doux"><?= e($gains['conversion']['gain']) ?></p>
            </div>
            <span class="manifeste__impact"><?= e($gains['conversion']['impact']) ?></span>
          </div>
          <div class="manifeste__ligne" style="--ton:var(--gain-visi)">
            <span class="manifeste__num">03</span>
            <div class="manifeste__corps">
              <h3><?= e($gains['visibilite']['titre']) ?></h3>
              <p class="doux"><?= e($gains['visibilite']['gain']) ?></p>
            </div>
            <span class="manifeste__impact"><?= e($gains['visibilite']['impact']) ?></span>
          </div>
          <div class="manifeste__ligne" style="--ton:var(--gain-ca)">
            <span class="manifeste__num">04</span>
            <div class="manifeste__corps">
              <h3><?= e($gains['ca']['titre']) ?></h3>
              <p class="doux"><?= e($gains['ca']['gain']) ?></p>
            </div>
            <span class="manifeste__impact"><?= e($gains['ca']['impact']) ?></span>
          </div>
          <div class="manifeste__ligne" style="--ton:var(--gain-seren)">
            <span class="manifeste__num">05</span>
            <div class="manifeste__corps">
              <h3><?= e($gains['serenite']['titre']) ?></h3>
              <p class="doux"><?= e($gains['serenite']['gain']) ?></p>
            </div>
            <span class="manifeste__impact"><?= e($gains['serenite']['impact']) ?></span>
          </div>
        </div>

        <p style="margin-top:2rem">
          <a class="bouton bouton--marine" href="/pages/services">
            Le détail des cinq gains <?= icone('fleche') ?>
          </a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php /* 3. La preuve. */ ?>
<section class="section">
  <div class="contenant">
    <div class="entete-section">
      <p class="sur-titre">La preuve</p>
      <h2 class="mesure">Des chiffres, pas des adjectifs</h2>
    </div>

    <div class="grille grille--2">
      <article class="carte">
        <span class="etiquette">Cabinet de recrutement · Côte d'Ivoire</span>
        <h3 style="margin-top:.75rem">De 10 à 30 placements par mois en six mois</h3>
        <p class="doux">
          Aucune visibilité en ligne, dix heures de recherche par placement,
          des demandes oubliées faute de suivi.
        </p>
        <ul class="liste-cochee">
          <li>Placements : 10 → 30 par mois</li>
          <li>Temps par placement : 10 h → 3 h</li>
          <li>Chiffre d'affaires : 1 M FCFA → 3 M FCFA par mois</li>
        </ul>
        <p><a href="/pages/blog">Lire le cas complet <?= icone('fleche') ?></a></p>
      </article>

      <article class="carte">
        <span class="etiquette">Agent commercial · Côte d'Ivoire</span>
        <h3 style="margin-top:.75rem">Trois heures récupérées chaque jour</h3>
        <p class="doux">
          Quatre heures par jour à chercher des prospects, soit 80 % du temps
          passé loin de la vente.
        </p>
        <ul class="liste-cochee">
          <li>Prospects qualifiés : 3 → 15 par jour</li>
          <li>Temps de recherche : 4 h → 1 h par jour</li>
          <li>Affaires en cours : 20 → 45</li>
        </ul>
        <p><a href="/pages/blog">Lire le cas complet <?= icone('fleche') ?></a></p>
      </article>
    </div>

    <?php if ($temoignages): ?>
      <h3 style="margin-top:2.5rem">Ce qu'en disent nos clients</h3>
      <div class="grille" style="margin-top:1rem">
        <?php foreach ($temoignages as $t): ?>
          <figure class="carte" style="margin:0">
            <blockquote style="margin:0 0 .75rem;font-size:1.0625rem">« <?= e($t['comment']) ?> »</blockquote>
            <figcaption class="doux" style="font-size:.9375rem">
              <strong class="fort"><?= e($t['name']) ?></strong>
              <span aria-label="<?= (int)$t['rating'] ?> sur 5" style="color:var(--or-600)">
                · <?= str_repeat('★', max(0, min(5, (int)$t['rating']))) ?>
              </span>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <?php
      /**
       * Emplacement réservé honnête (règle du projet : jamais un témoignage
       * inventé). Les trois avis précédents ("Madjik Pharma", "IvoirRapid",
       * "Utilisateur SFB") ont été retirés le 2026-08-06 — invérifiables, et
       * l'un citait l'ancien nom de produit "SFB". Ce bloc disparaît de
       * lui-même dès qu'un vrai témoignage est ajouté en administration.
       */
      ?>
      <div class="carte" style="margin-top:2.5rem;border-style:dashed;text-align:center">
        <p class="doux" style="margin:0">
          Espace réservé aux avis de nos clients — en attente d'un premier témoignage vérifié.
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php /* Comment on travaille — lève l'objection « et concrètement ? ». */ ?>
<section class="section section--alt">
  <div class="contenant">
    <div class="entete-section">
      <p class="sur-titre">Comment on travaille</p>
      <h2 class="mesure">Quatre étapes, aucune surprise</h2>
    </div>

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
          <p class="doux">Vos deux priorités du moment, le gain attendu pour chacune, le coût en face. Vous choisissez.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mise en place et formation</h3>
          <p class="doux">On installe, on vous forme, votre équipe reste autonome.</p>
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

<?php if ($articles): ?>
<section class="section">
  <div class="contenant">
    <div class="entete-section">
      <p class="sur-titre">À lire</p>
      <h2>Nos derniers articles</h2>
    </div>
    <div class="grille">
      <?php foreach (array_slice($articles, 0, 3) as $a): ?>
        <?php require dirname(__DIR__) . '/blog/vignette.php'; ?>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:1.5rem">
      <a class="bouton bouton--contour" href="/pages/blog">Tous les articles <?= icone('fleche') ?></a>
    </p>
  </div>
</section>
<?php endif; ?>

<?php require dirname(__DIR__) . '/partials/diagnostic.php'; ?>
