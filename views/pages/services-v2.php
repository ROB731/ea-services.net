<?php
/**
 * Services — direction v2.
 *
 * Le CONTENU est repris mot pour mot de la version précédente : il est validé
 * et applique la doctrine (on part de la perte vécue, jamais de l'outil ; chaque
 * bloc finit sur sa ligne Impact chiffrée). Seule la forme change.
 *
 * Le vocabulaire suit celui de l'accueil v2 — `etiquette-section`, `carte`,
 * `page-large`, `manifeste__impact` — plutôt que les cartes colorées de la v1.
 * C'est un parti pris assumé de cette direction : le relevé est typographique,
 * la couleur ne porte plus le sens à elle seule (cf. skill ea-design, qui exige
 * justement que l'information ne repose jamais sur la seule teinte).
 */
$gains = (array)cfg('gains');

/* Un tableau plutôt que cinq blocs recopiés : la structure est strictement la
   même pour les cinq, seul le fond change. Repris tel quel de la v1. */
$services = [
    [
        'cle' => 'temps', 'icone' => 'temps', 'numero' => '01',
        'mots' => ['Automatisation'],
        'titre' => $gains['temps']['titre'],
        'probleme' => "Vous passez vos journées sur des tâches qu'une machine ferait sans vous : "
                    . "relancer un prospect, ressaisir les mêmes informations d'un carnet à un fichier, "
                    . "répondre pour la dixième fois à la même question. Le soir, le vrai travail n'a pas avancé.",
        'solution' => [
            'Vos relances partent toutes seules, au bon moment : le jour même, à trois jours, à sept jours.',
            'Les demandes qui arrivent sont triées avant vous : celles qui méritent votre temps remontent en premier.',
            'Vos informations se recopient d\'un endroit à l\'autre sans vous — plus de double saisie, plus de doublons.',
            'Une sauvegarde part chaque jour, sans que personne n\'y pense.',
        ],
        'resultat' => "Ces heures vous reviennent. Combien exactement dépend de votre activité : "
                    . "nous les comptons avec vous avant de commencer, puis nous mesurons ce qui a "
                    . "réellement été récupéré.",
        'impact' => $gains['temps']['impact'],
    ],
    [
        'cle' => 'conversion', 'icone' => 'conversion', 'numero' => '02',
        'mots' => ['Automatisation', 'Présence en ligne'],
        'titre' => $gains['conversion']['titre'],
        'probleme' => "Un client vous écrit à 21 h. Vous le voyez le lendemain à 11 h. Entre-temps il a écrit "
                    . "à deux autres entreprises, et l'une d'elles a répondu. Vous n'avez pas perdu sur le prix "
                    . "ni sur la qualité : vous avez perdu sur le délai.",
        'solution' => [
            'Chaque demande reçoit une réponse en moins de deux minutes, à toute heure, y compris la nuit et le dimanche.',
            'Trois questions simples suffisent à savoir si la demande est sérieuse — vous ne rappelez que celles qui le sont.',
            'Une demande sans réponse est relancée automatiquement jusqu\'à ce qu\'elle aboutisse.',
            'Vous gardez la main : rien ne part en votre nom sans que vous ayez validé le message type.',
        ],
        'resultat' => "Plus aucune demande ne reste sans réponse. Sept prospects sur dix arrivent déjà "
                    . "qualifiés dans votre téléphone.",
        'impact' => $gains['conversion']['impact'],
    ],
    [
        'cle' => 'visibilite', 'icone' => 'visibilite', 'numero' => '03',
        'mots' => ['Présence en ligne'],
        'titre' => $gains['visibilite']['titre'],
        'probleme' => "Quelqu'un cherche exactement ce que vous vendez, à Abidjan, aujourd'hui. "
                    . "Il tape sa recherche sur son téléphone. Il ne vous trouve pas. Il appelle "
                    . "le premier nom de la liste, et ce n'est pas vous.",
        'solution' => [
            'Un site qui répond vite sur téléphone et qui dit en cinq secondes ce que vous apportez.',
            'Vos pages écrites autour des mots que vos clients tapent réellement, pas de ceux qui vous plaisent.',
            'Vos profils publics complets et cohérents : même nom, même numéro, même adresse partout.',
            'Des publications régulières, préparées à l\'avance, qui prouvent que vous êtes actif.',
        ],
        'resultat' => "On vous trouve quand on vous cherche. Les demandes arrivent sans que vous ayez "
                    . "à courir après.",
        'impact' => $gains['visibilite']['impact'],
    ],
    [
        'cle' => 'ca', 'icone' => 'croissance', 'numero' => '04',
        'mots' => ['Développement sur mesure', 'Accompagnement'],
        'titre' => $gains['ca']['titre'],
        'probleme' => "Pour gagner plus, il faudrait travailler plus. Vos journées sont déjà pleines. "
                    . "Vous êtes devenu le plafond de votre propre entreprise.",
        'solution' => [
            'Tous vos prospects au même endroit : où en est chacun, qui doit être rappelé cette semaine.',
            'Une visibilité sur le mois à venir : combien d\'affaires sont réellement en train de se conclure.',
            'L\'endroit exact où vous perdez vos clients, identifié chiffres en main.',
            'Un point chaque semaine : ce qui a marché, on le refait ; ce qui n\'a rien donné, on l\'arrête.',
        ],
        'resultat' => "Votre chiffre d'affaires monte grâce au temps récupéré et aux prospects convertis, "
                    . "sans une heure de travail supplémentaire.",
        'impact' => $gains['ca']['impact'],
    ],
    [
        'cle' => 'serenite', 'icone' => 'serenite', 'numero' => '05',
        'mots' => ['Infrastructure'],
        'titre' => $gains['serenite']['titre'],
        'probleme' => "Le fichier de vos clients est sur un seul ordinateur. Vous ne savez pas ce que vous "
                    . "devez faire des données que vous collectez. Le jour où l'ordinateur tombe, "
                    . "vous perdez dix ans de travail.",
        'solution' => [
            'Vos données recopiées automatiquement à deux endroits distincts, chaque jour.',
            'Vos obligations sur les données personnelles respectées : consentement, suppression sur demande.',
            'Une surveillance permanente : si quelque chose tombe, nous le savons avant vos clients.',
            'Un interlocuteur qui répond en moins de deux heures quand il y a un problème.',
        ],
        'resultat' => "Vos données survivent à n'importe quel incident matériel, et vous êtes en règle.",
        'impact' => $gains['serenite']['impact'],
    ],
];

/* Les pages d'expertise qui détaillent chaque gain (config/expertises.php). */
$expertises   = \EA\Core\Config::expertises();
$pagesParGain = [
    'temps'      => ['automatisation-taches-entreprise', 'application-mobile-abidjan'],
    'conversion' => ['chatbot-whatsapp-entreprise', 'boutique-en-ligne-abidjan'],
    'visibilite' => ['creation-site-web-abidjan', 'referencement-google-abidjan'],
    'ca'         => ['logiciel-sur-mesure-abidjan', 'boutique-en-ligne-abidjan'],
    'serenite'   => ['maintenance-informatique-abidjan', 'formation-informatique-ia-abidjan'],
];

/* Illustrations de principe (outils/maquettes.py) : ce que le gain donne, concrètement. */
$visuelsParGain = [
    'temps'      => ['/assets/expertises/automatisation.svg', "Illustration : des relances qui partent automatiquement au bon moment"],
    'conversion' => ['/assets/expertises/chatbot-whatsapp.svg', "Illustration : une conversation WhatsApp où le client reçoit une réponse immédiate"],
    'visibilite' => ['/assets/expertises/referencement.svg', "Illustration : une entreprise qui apparaît sur la carte et dans les résultats de recherche"],
    'ca'         => ['/assets/expertises/logiciel-sur-mesure.svg', "Illustration : un outil qui regroupe toutes les commandes et leur statut"],
    'serenite'   => ['/assets/expertises/maintenance.svg', "Illustration : la sauvegarde du jour réussie à deux endroits, tous les services en marche"],
];

$libelles = [
    'temps' => 'Temps', 'conversion' => 'Conversion', 'visibilite' => 'Visibilité',
    'ca' => "Chiffre d'affaires", 'serenite' => 'Sérénité',
];

/* Le mot que quelqu'un tape réellement dans Google n'est jamais « gagnez du
   temps » — c'est « automatisation », « développement logiciel »… Chaque
   gain est donc rattaché au(x) mot-clé(s) public(s) sous lequel on le
   cherche, affichés en pastille sous le titre (voir plus bas). */
$iconesMots = [
    'Présence en ligne' => 'visibilite', 'Développement sur mesure' => 'croissance',
    'Automatisation' => 'temps', 'Formation' => 'serenite',
    'Accompagnement' => 'cible', 'Infrastructure' => 'document',
];
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Nos services</span>
      <span class="etiquette-section__texte">Cinq pertes, cinq réponses</span>
    </p>
    <?php /* `em` et non `span.suite` : le systeme de design fait passer la
             seconde ligne en bloc via `h1 em` et `h2 span.suite`. Dans un h1,
             span.suite reste en ligne — le titre se collait sans espace. */ ?>
    <h1 class="mesure titre-machine">Cinq pertes.<em>Cinq façons de les arrêter.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Agence de développement web &amp; automatisation — Abidjan, Côte d'Ivoire</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Chaque service part d'une perte que vous subissez déjà. Pas d'une
      technologie qu'il faudrait adopter. Vous choisissez par où commencer.
    </p>
    <p class="mesure-large" style="margin-top:1rem;font-weight:600">
      Ces cinq pertes ne parlent pas qu'à ceux qui vont mal : arrêter une
      fuite et accélérer une croissance, c'est le même travail. Si vous allez
      déjà bien, ces cinq leviers sont ceux qui vous font aller plus vite.
    </p>
  </div>
</section>

<?php /* Les cinq gains, développés. Fond alterné pour séparer les blocs sans
         ajouter de bordure : la respiration fait le découpage. */ ?>
<?php foreach ($services as $i => $s): ?>
<section class="section <?= $i % 2 ? 'section--sable' : 'section--papier' ?>" id="gain-<?= e($s['cle']) ?>">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index"><?= e($s['numero']) ?></span>
      <span class="etiquette-section__texte"><?= e($libelles[$s['cle']]) ?></span>
    </p>
    <h2 class="mesure"><?= icone($s['icone'], 'ico ico--lg') ?> <?= e($s['titre']) ?></h2>

    <?php if (!empty($s['mots'])): ?>
      <div class="marqueurs" style="margin:1rem 0 1.5rem">
        <?php foreach ($s['mots'] as $mot): ?>
          <span class="marqueur"><?= icone($iconesMots[$mot] ?? 'cible') ?> <?= e($mot) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($visuelsParGain[$s['cle']])): [$src, $alt] = $visuelsParGain[$s['cle']]; ?>
      <img src="<?= e($src) ?>" alt="<?= e($alt) ?>" width="640" height="520" loading="lazy"
           style="display:block;width:100%;max-width:36rem;height:auto;border-radius:1rem;margin:0 0 1.5rem">
    <?php endif; ?>

    <div class="grille grille--2">
      <article class="carte">
        <h3>Ce que vous vivez aujourd'hui</h3>
        <p class="doux"><?= e($s['probleme']) ?></p>
      </article>

      <article class="carte">
        <h3>Ce qu'on met en place</h3>
        <ul class="liste-cochee">
          <?php foreach ($s['solution'] as $point): ?>
            <li><?= e($point) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="doux" style="margin-top:1rem"><?= e($s['resultat']) ?></p>
        <span class="manifeste__impact"><?= e($s['impact']) ?></span>
        <?php if (!empty($pagesParGain[$s['cle']])): ?>
          <p style="margin-top:1rem;font-size:.9375rem">En détail :
            <?php foreach ($pagesParGain[$s['cle']] as $n => $slugX): ?><?= $n ? ' · ' : '' ?><a href="/pages/<?= e($slugX) ?>"><?= e($expertises[$slugX]['libelle'] ?? $slugX) ?></a><?php endforeach; ?>
          </p>
        <?php endif; ?>
      </article>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?php /* ------------------------------------------------- Par où commencer */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Par où commencer</span>
      <span class="etiquette-section__texte">On ne traite pas les cinq d'un coup</span>
    </p>
    <h2 class="mesure">On ne fait pas les cinq<span class="suite">en même temps.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Vouloir tout traiter d'un coup, c'est ne rien terminer. Le diagnostic sert
      exactement à ça : trouver les deux gains qui rapportent le plus, chez vous,
      maintenant — et laisser les trois autres pour plus tard.
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
      <h2 class="mesure">Trente minutes pour<span class="suite">choisir vos deux priorités.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes pour repérer, parmi ces cinq gains, les deux qui vous
        rapporteront le plus dès le premier trimestre. Nous ne vendons rien
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
