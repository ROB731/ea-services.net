<?php
/**
 * Réalisations — direction v2.
 *
 * Même contenu que l'ancienne version (trois cas clients chiffrés, jamais
 * inventés), mise en forme avec les composants déjà utilisés sur l'accueil
 * pour les deux mêmes cas (.bascules/.bascule/.investissement) plutôt que
 * les tableaux de la v1 — pour que cette page ait l'air de faire partie du
 * même site que les autres, pas d'un gabarit différent.
 *
 * Sites et applications réalisés (2026-08-17) : chaque aperçu charge le vrai
 * site en direct (pas une image), sauf ivoirrapid.ci qui bloque tout
 * affichage en frame de son côté (frame-ancestors 'none', y compris pour
 * lui-même) — une vraie capture d'écran y est utilisée à la place, jamais
 * une image inventée. Les trois sites sous sites-sfb.ea-services.net ont
 * explicitement été autorisés à s'afficher depuis ea-services.net (décision
 * du dirigeant, 2026-08-17) : leur configuration serveur limitait
 * jusque-là l'affichage en frame à sfb.ea-services.net uniquement.
 */
$sitesRealises = [
    [
        'nom' => "Emile'S Boutik",
        'categorie' => 'Boutique en ligne',
        'description' => "Vente de parfums, sacs, chaussures et bijoux à Abidjan : catalogue complet, "
                        . "commande par WhatsApp, paiement à la livraison, livraison en 24 à 48 h.",
        'url' => 'https://sites-sfb.ea-services.net/emile-s-boutik/',
    ],
    [
        'nom' => 'Hôtel Hibiscus Marcory',
        'categorie' => 'Site vitrine hôtelier',
        'description' => "Un hôtel 3 étoiles et demi à Marcory : chambres et tarifs, restaurant, "
                        . "salle d'événements, réservation express par téléphone ou WhatsApp.",
        'url' => 'https://sites-sfb.ea-services.net/hotel-hibiscus-marcory/',
    ],
    [
        'nom' => 'Africa Eco Race',
        'categorie' => 'Site événementiel',
        'description' => "Le rallye-raid Maroc–Mauritanie–Sénégal : parcours détaillé, partenaires "
                        . "et inscription des pilotes, motos et camions.",
        'url' => 'https://sites-sfb.ea-services.net/race-africa-site/',
    ],
    [
        'nom' => 'IvoirRapid',
        'categorie' => 'Plateforme de livraison',
        'description' => "Livraison express de plis, documents et colis à Abidjan : suivi en direct, "
                        . "plus de 100 entreprises partenaires, paiement Mobile Money.",
        'url' => 'https://ivoirrapid.ci',
        'image' => '/assets/realisations/ivoirrapid.png',
    ],
    [
        'nom' => 'Espace client IvoirRapid',
        'categorie' => 'Espace client sécurisé',
        'description' => "L'interface où les entreprises partenaires d'IvoirRapid gèrent leur compte "
                        . "et suivent leurs envois.",
        'url' => 'https://client.ivoirrapid.ci',
    ],
    [
        'nom' => 'EMPLOI.EA',
        'categorie' => "Plateforme d'emploi",
        'description' => "CV et lettres de motivation générés par IA, candidature en un clic et suivi "
                        . "des candidatures pour les chercheurs d'emploi ivoiriens.",
        'url' => 'https://ea-services.net/emploi.ea/',
    ],
    [
        'nom' => 'SFB',
        'categorie' => 'Prospection commerciale',
        'description' => "Trouver de nouveaux clients à partir de données, pas de suppositions — "
                        . "l'outil de prospection utilisé pour EA-SERVICES elle-même.",
        'url' => 'https://sfb.ea-services.net/',
    ],
];
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Réalisations</span>
      <span class="etiquette-section__texte">Trois cas, chiffres à l'appui</span>
    </p>
    <h1 class="mesure titre-machine">Des cas réels,<em>avec les chiffres.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Agence de développement web à Abidjan — nos réalisations</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Pas de théorie et pas de superlatifs. Voici trois situations, ce qui a
      été mis en place, et ce que ça a donné.
    </p>
  </div>
</section>

<?php /* ------------------------------------------------------- Les 3 cas */ ?>
<section class="section section--claire">
  <div class="page-large">

    <article class="carte" style="margin-bottom:1.5rem">
      <span class="chapeau">Cabinet de recrutement · Côte d'Ivoire</span>
      <h2 style="margin-bottom:.75rem">Multiplier ses placements par trois en six mois</h2>
      <p class="doux">Quinze consultants, une dizaine de placements par mois, des
         clients venus uniquement du réseau personnel du dirigeant. Une croissance
         plafonnée par la taille du carnet d'adresses.</p>

      <ul class="liste-cochee" style="margin-top:1rem">
        <li>Aucune présence en ligne : les entreprises qui cherchaient un cabinet ne le trouvaient pas.</li>
        <li>Dix heures de recherche manuelle par placement.</li>
        <li>Des demandes reçues puis oubliées, faute d'un endroit unique pour les suivre.</li>
      </ul>

      <div class="bascules" style="margin-top:1.25rem">
        <div class="bascule"><span>Placements par mois</span><strong>10 <b>→</b> 30</strong></div>
        <div class="bascule"><span>Temps par placement</span><strong>10 h <b>→</b> 3 h</strong></div>
        <div class="bascule"><span>Chiffre d'affaires mensuel</span><strong>1 M <b>→</b> 3 M FCFA</strong></div>
        <div class="bascule"><span>Origine des clients</span><strong>Réseau <b>→</b> 50 % en ligne</strong></div>
      </div>
      <span class="investissement">Investissement ~250 000 FCFA / mois, gain ~1 500 000 FCFA / mois.</span>
    </article>

    <article class="carte" style="margin-bottom:1.5rem">
      <span class="chapeau">Agent commercial · Côte d'Ivoire</span>
      <h2 style="margin-bottom:.75rem">Cinq fois plus de prospects, sans une heure de travail en plus</h2>
      <p class="doux">Trois prospects trouvés par jour, à la main. Quatre heures
         quotidiennes passées à chercher des contacts — soit 80 % du temps de
         travail consacré à la partie qui ne rapporte rien.</p>

      <ul class="liste-cochee" style="margin-top:1rem">
        <li>Une liste quotidienne d'entreprises correspondant à sa cible.</li>
        <li>Un premier message envoyé pour lui, puis des relances programmées.</li>
        <li>Un suivi centralisé pour ne plus laisser tomber une affaire en cours.</li>
      </ul>

      <div class="bascules" style="margin-top:1.25rem">
        <div class="bascule"><span>Prospects qualifiés / jour</span><strong>3 <b>→</b> 15</strong></div>
        <div class="bascule"><span>Temps de recherche / jour</span><strong>4 h <b>→</b> 1 h</strong></div>
        <div class="bascule"><span>Affaires en cours</span><strong>20 <b>→</b> 45</strong></div>
      </div>
      <span class="investissement">3 heures récupérées par jour, huit affaires supplémentaires par mois.</span>
    </article>

    <article class="carte">
      <span class="chapeau">Entreprise de services · Côte d'Ivoire</span>
      <h2 style="margin-bottom:.75rem">Quinze heures récupérées chaque semaine par le dirigeant</h2>
      <p class="doux">Cinq salariés, un dirigeant à cinquante heures par semaine,
         dont l'essentiel en messages, appels de suivi, saisies et vérifications
         de commandes.</p>

      <ul class="liste-cochee" style="margin-top:1rem">
        <li>Les réponses courantes et les relances envoyées automatiquement.</li>
        <li>Les informations recopiées d'un endroit à l'autre sans intervention.</li>
        <li>Une sauvegarde quotidienne et une surveillance des pannes.</li>
      </ul>

      <div class="bascules" style="margin-top:1.25rem">
        <div class="bascule"><span>Heures rendues au dirigeant / semaine</span><strong>0 <b>→</b> 15 h</strong></div>
        <div class="bascule"><span>Oublis de suivi</span><strong>— <b>→</b> -80 %</strong></div>
      </div>
      <span class="investissement">Investissement ~150 000 FCFA / mois pour une journée de dirigeant récupérée par semaine.</span>
    </article>

  </div>
</section>

<?php /* --------------------------------------------- Sites et applications */ ?>
<section class="section section--sable">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">En ligne</span>
      <span class="etiquette-section__texte">Des sites et applications réels, pas des maquettes</span>
    </p>
    <h2 class="mesure">Voyez-les<span class="suite">directement.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem;margin-bottom:1.75rem">
      Chaque aperçu ci-dessous charge le vrai site, en direct.
    </p>

    <div class="grille grille--3">
      <?php foreach ($sitesRealises as $s): ?>
        <article class="carte" style="padding:0;overflow:hidden">
          <div class="apercu-site">
            <?php if (!empty($s['image'])): ?>
              <img src="<?= e($s['image']) ?>" alt="Aperçu du site <?= e($s['nom']) ?>" loading="lazy">
            <?php else: ?>
              <iframe src="<?= e($s['url']) ?>" title="<?= e($s['nom']) ?>" loading="lazy"
                      referrerpolicy="no-referrer"
                      sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox"></iframe>
            <?php endif; ?>
          </div>
          <div style="padding:1.5rem">
            <span class="chapeau"><?= e($s['categorie']) ?></span>
            <h3><?= e($s['nom']) ?></h3>
            <p class="doux" style="font-size:.9375rem"><?= e($s['description']) ?></p>
            <p style="margin-top:1rem">
              <a class="lien-fleche" href="<?= e($s['url']) ?>" target="_blank" rel="noopener">
                Ouvrir le site <?= icone('fleche') ?>
              </a>
            </p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* --------------------------------------------------------- Méthode */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Ce que ces cas ont en commun</span>
      <span class="etiquette-section__texte">Toujours la même méthode</span>
    </p>
    <h2 class="mesure">Trois étapes,<span class="suite">jamais dans le désordre.</span></h2>

    <ol class="etapes" style="max-width:44rem">
      <li class="etape">
        <div>
          <h3>Chiffrer la perte</h3>
          <p class="doux">Combien d'heures, combien de demandes, combien de FCFA — avant de proposer quoi que ce soit.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Traiter les deux plus grosses</h3>
          <p class="doux">Jamais les cinq à la fois : deux chantiers menés à leur terme valent mieux que cinq entamés.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Mesurer chaque semaine</h3>
          <p class="doux">Un gain qu'on ne mesure pas est un gain qu'on ne peut pas défendre.</p>
        </div>
      </li>
    </ol>

    <p style="margin-top:1.75rem">
      <a class="lien-fleche" href="/pages/blog">Lire nos articles <?= icone('fleche') ?></a>
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
      <h2 class="mesure">Ces entreprises ont commencé<span class="suite">par un diagnostic gratuit.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Le vôtre est gratuit et sans engagement. Trente minutes pour savoir ce
        que vous perdez réellement, et par quoi commencer.
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
