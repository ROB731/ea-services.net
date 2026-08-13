<?php
/**
 * Services — les cinq gains, développés.
 *
 * Chaque bloc suit le même ordre : ce que vous perdez, ce qu'on met en place,
 * ce que vous récupérez (ligne Impact). Le vocabulaire reste celui du client :
 * aucun outil n'est nommé, aucun terme technique.
 */
$gains = (array)cfg('gains');
?>

<section class="hero hero--photos">
  <?php $heroPhoto = 'plateau'; require dirname(__DIR__) . '/partials/hero-photo.php'; ?>
  <div class="contenant">
    <p class="sur-titre">Nos services</p>
    <h1 class="mesure">Cinq pertes, cinq façons de les arrêter</h1>
    <p class="chapo mesure">
      Chaque service part d'une perte que vous subissez déjà. Pas d'une
      technologie qu'il faudrait adopter. Vous choisissez par où commencer.
    </p>
  </div>
</section>

<?php
/**
 * PLACEHOLDERS TEMPORAIRES (2026-08-06) — à remplacer par de vraies photos
 * du travail réel dès qu'elles sont disponibles (voir a-propos.php pour la
 * même remarque). Légendes volontairement génériques : aucune n'affirme
 * "c'est nous" ou "notre bureau".
 */
?>
<section class="section section--serre">
  <div class="contenant">
    <div class="grille grille--2">
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-reponse.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Répondre vite, même en déplacement — pas seulement depuis un bureau.
        </figcaption>
      </figure>
      <figure class="carte" style="margin:0;padding:0;overflow:hidden">
        <img src="/assets/temporaire-suivi.jpg" alt="" loading="lazy" width="900" height="675"
             style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:0">
        <figcaption class="doux" style="padding:1rem 1.25rem;font-size:.875rem">
          Le suivi, noté et daté — pour ne jamais perdre le fil d'un dossier.
        </figcaption>
      </figure>
    </div>
    <p class="doux" style="font-size:.6875rem;text-align:right;margin-top:.5rem">
      Photos temporaires — Shixart1985, Wikimedia Commons (CC BY 2.0).
    </p>
  </div>
</section>

<?php
/* Un tableau plutôt que cinq blocs recopiés : la structure est strictement
   la même pour les cinq, seul le fond change. */
$services = [
    [
        'cle' => 'temps', 'ton' => 'temps', 'icone' => 'temps',
        'numero' => '01',
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
        'resultat' => "Vous récupérez huit à quatorze heures chaque semaine — l'équivalent d'une à "
                    . "deux journées complètes rendues à la stratégie.",
        'impact' => $gains['temps']['impact'],
    ],
    [
        'cle' => 'conversion', 'ton' => 'conv', 'icone' => 'conversion',
        'numero' => '02',
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
        'cle' => 'visibilite', 'ton' => 'visi', 'icone' => 'visibilite',
        'numero' => '03',
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
        'cle' => 'ca', 'ton' => 'ca', 'icone' => 'croissance',
        'numero' => '04',
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
        'cle' => 'serenite', 'ton' => 'seren', 'icone' => 'serenite',
        'numero' => '05',
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
?>

<?php foreach ($services as $i => $s): ?>
<section class="section<?= $i % 2 ? ' section--alt' : '' ?>">
  <div class="contenant">
    <p class="sur-titre"><?= e($s['numero']) ?> · <?= e(ucfirst($s['cle'] === 'ca' ? "chiffre d'affaires" : $s['cle'])) ?></p>
    <h2 class="mesure"><?= icone($s['icone'], 'ico ico--lg') ?> <?= e($s['titre']) ?></h2>

    <div class="grille grille--2" style="margin-top:1.5rem">
      <article class="gain gain--perte">
        <h3>Ce que vous vivez aujourd'hui</h3>
        <p><?= e($s['probleme']) ?></p>
      </article>

      <article class="gain gain--<?= e($s['ton']) ?>">
        <h3>Ce qu'on met en place</h3>
        <ul class="liste-cochee">
          <?php foreach ($s['solution'] as $point): ?>
            <li><span><?= e($point) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <p style="margin-top:1rem"><?= e($s['resultat']) ?></p>
        <span class="impact"><?= e($s['impact']) ?></span>
      </article>
    </div>
  </div>
</section>
<?php endforeach; ?>

<section class="section">
  <div class="contenant">
    <p class="sur-titre">Par où commencer</p>
    <h2 class="mesure">On ne fait pas les cinq en même temps</h2>
    <p class="chapo mesure">
      Vouloir tout traiter d'un coup, c'est ne rien terminer. Le diagnostic sert
      exactement à ça : trouver les deux gains qui rapportent le plus, chez vous,
      maintenant — et laisser les trois autres pour plus tard.
    </p>
  </div>
</section>

<?php
$diagnosticTexte = "Trente minutes pour repérer, parmi ces cinq gains, les deux qui vous "
                 . "rapporteront le plus dès le premier trimestre. Nous ne vendons rien pendant cet échange.";
require dirname(__DIR__) . '/partials/diagnostic.php';
?>
