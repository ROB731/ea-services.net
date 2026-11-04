<?php
/**
 * Sonnera — application mobile Android d'EA-SERVICES.
 *
 * Contenu tiré de la présentation fournie par le dirigeant (Sonnera-presentation.pdf).
 * Aucun chiffre ajouté : le seul chiffre est un fait du produit (relance du
 * responsable après 30 minutes, réglable). Les six situations sont des
 * exemples d'usage, pas des témoignages — le dire est une obligation.
 *
 * À COMPLÉTER PAR LE DIRIGEANT : lien de téléchargement (Play Store ou fichier),
 * captures d'écran réelles, éventuels retours d'utilisateurs réels.
 */
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Sonnera</span>
      <span class="etiquette-section__texte">Application Android · rappels et suivi d'équipe</span>
    </p>
    <h1 class="mesure titre-machine">Ce qui doit être fait sonne<em>jusqu'à ce que ce soit fait.</em></h1>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Une alarme que l'on entend vraiment, des tâches réparties entre
      collègues, et un responsable prévenu quand quelque chose traîne.
      Même téléphone verrouillé.
    </p>
    <div class="diagnostic__actions" style="margin-top:1.5rem">
      <a class="bouton bouton--safran" href="/diagnostic"><?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?></a>
      <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
        <?= icone('whatsapp') ?> Demander une démonstration
      </a>
    </div>
  </div>
</section>

<?php /* ------------------------------------------------- Les trois pertes */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Ce que vous perdez</span>
      <span class="etiquette-section__texte">Une notification silencieuse, on ne la voit pas</span>
    </p>
    <h2 class="mesure">Les choses importantes se perdent<span class="suite">toujours de la même façon.</span></h2>

    <div class="grille grille--3" style="margin-top:1.5rem">
      <article class="carte">
        <h3>On oublie</h3>
        <p class="doux">Le téléphone vibre dans la poche, le message passe inaperçu, et le
           médicament, l'appel ou la livraison est raté.</p>
      </article>
      <article class="carte">
        <h3>On ne sait pas si c'est fait</h3>
        <p class="doux">Une consigne est donnée dans un groupe de discussion. Personne ne
           confirme, et le responsable doit relancer à la main.</p>
      </article>
      <article class="carte">
        <h3>Tout se mélange</h3>
        <p class="doux">Les tâches, les photos, les vocaux et les demandes sont éparpillés
           entre plusieurs applications.</p>
      </article>
    </div>
  </div>
</section>

<?php /* ---------------------------------------------- Comment ça marche */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Comment ça marche</span>
      <span class="etiquette-section__texte">Trois temps, du plus simple au plus utile</span>
    </p>
    <h2 class="mesure">Personne n'est laissé seul<span class="suite">avec une tâche à retenir.</span></h2>

    <ol class="etapes" style="max-width:44rem">
      <li class="etape">
        <div>
          <h3>On note en quelques secondes</h3>
          <p class="doux">Un bouton pour un rappel, une note ou une demande à un collègue.
             Pour les pressés : une photo, et le rappel est prêt pour dans une heure ;
             ou un message vocal, même résultat.</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>L'alarme ne se laisse pas oublier</h3>
          <p class="doux">À l'heure prévue, le téléphone sonne même verrouillé, avec le son
             choisi. Elle continue tant que vous n'avez pas répondu :
             « C'est fait » ou « Plus tard ».</p>
        </div>
      </li>
      <li class="etape">
        <div>
          <h3>Le responsable est prévenu</h3>
          <p class="doux">Si une tâche d'équipe n'est pas faite, la personne est relancée,
             puis son responsable est prévenu. Tout reste visible dans l'historique.</p>
        </div>
      </li>
    </ol>

    <?php /* Illustration, pas une capture : l'écran réel n'est pas encore fourni. */ ?>
    <figure class="carte" style="margin:2rem 0 0;max-width:22rem">
      <span class="chapeau">Illustration</span>
      <p class="doux" style="font-size:.875rem;margin:0">Lundi · 07:30</p>
      <h3 style="margin:.5rem 0">Ouvrir la caisse et compter le fond</h3>
      <p class="doux" style="font-size:.875rem">Tâche assignée par la gérante</p>
      <p style="margin-top:1rem;display:flex;gap:.75rem;flex-wrap:wrap">
        <span class="bouton bouton--marine" aria-hidden="true">C'est fait</span>
        <span class="bouton bouton--contour" aria-hidden="true">Plus tard</span>
      </p>
      <figcaption class="doux" style="font-size:.75rem;margin-top:.75rem">
        Schéma de principe de l'alarme, pas une capture d'écran.
      </figcaption>
    </figure>
  </div>
</section>

<?php /* ----------------------------------------------------- Le suivi */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Pour les responsables</span>
      <span class="etiquette-section__texte">Le suivi se fait tout seul</span>
    </p>
    <h2 class="mesure">Plus besoin de relancer<span class="suite">à la main.</span></h2>
    <p class="mesure-large doux" style="margin-top:1rem">
      Quand une tâche n'est pas faite à l'heure, Sonnera n'attend pas qu'un
      responsable s'en aperçoive. Les notifications arrivent même
      application fermée.
    </p>

    <div class="grille grille--2" style="margin-top:1.5rem">
      <article class="carte">
        <span class="chapeau">À l'heure</span>
        <h3>La tâche est due</h3>
        <p class="doux">L'alarme sonne chez la personne désignée.</p>
      </article>
      <article class="carte">
        <span class="chapeau">Sans réponse</span>
        <h3>Un rappel est envoyé</h3>
        <p class="doux">La personne est relancée, avec le son de son choix.</p>
      </article>
      <article class="carte">
        <span class="chapeau">Après 30 minutes</span>
        <h3>Le responsable est prévenu</h3>
        <p class="doux">Il ouvre la tâche d'un appui et décide de relancer ou d'aider.
           Le délai se règle ; 30 minutes par défaut.</p>
      </article>
      <article class="carte">
        <span class="chapeau">Toujours</span>
        <h3>Tout est gardé</h3>
        <p class="doux">L'historique montre ce qui a été fait, reporté ou annulé.</p>
      </article>
    </div>
    <span class="investissement" style="margin-top:1.5rem;display:inline-block">
      Impact : plus aucune consigne sans réponse, et plus de relance à faire à la main
    </span>
  </div>
</section>

<?php /* -------------------------------------------------- Les fonctions */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Les fonctions</span>
      <span class="etiquette-section__texte">Tout ce qu'il faut pour ne rien laisser passer</span>
    </p>
    <h2 class="mesure">Une seule application<span class="suite">au lieu de quatre.</span></h2>

    <div class="grille grille--2" style="margin-top:1.5rem">
      <article class="carte">
        <h3>Rappels qui sonnent vraiment</h3>
        <p class="doux">Une alarme complète, pas une simple notification, même téléphone verrouillé.</p>
      </article>
      <article class="carte">
        <h3>Répétitions</h3>
        <p class="doux">Tous les jours, toutes les semaines, certains jours seulement. On crée une fois, Sonnera s'occupe du reste.</p>
      </article>
      <article class="carte">
        <h3>Notes, photos, vocaux</h3>
        <p class="doux">On joint une photo ou un message vocal à une tâche, et on peut le réécouter avant d'envoyer.</p>
      </article>
      <article class="carte">
        <h3>Demander à un collègue</h3>
        <p class="doux">Qui, quoi, pour quand. On peut dicter la demande plutôt que l'écrire.</p>
      </article>
      <article class="carte">
        <h3>Messagerie et messages urgents</h3>
        <p class="doux">Discussions de groupe dans l'application. Un message urgent fait sonner le téléphone du destinataire.</p>
      </article>
      <article class="carte">
        <h3>Suivi de l'équipe</h3>
        <p class="doux">Voir qui a répondu, qui est en retard, relancer et prévenir les responsables sans les appeler un par un.</p>
      </article>
      <article class="carte">
        <h3>Départements</h3>
        <p class="doux">Des groupes et sous-groupes : la caisse, la livraison, la cuisine, l'entretien.</p>
      </article>
      <article class="carte">
        <h3>Mode discret</h3>
        <p class="doux">Pour les lieux où il faut rester silencieux : vibration et notifications douces.</p>
      </article>
      <article class="carte">
        <h3>Sons à écouter avant de choisir</h3>
        <p class="doux">Alarmes, voix et vocaux se prévisualisent, ou on prend un son déjà présent sur le téléphone.</p>
      </article>
      <article class="carte">
        <h3>Historique et bilan</h3>
        <p class="doux">Ce qui a été fait, annulé ou reporté : où en est l'équipe, et ce qui revient souvent.</p>
      </article>
    </div>
  </div>
</section>

<?php /* ----------------------------------------------------- Cas d'usage */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Cas concrets</span>
      <span class="etiquette-section__texte">À quoi ça ressemble, un jour normal</span>
    </p>
    <h2 class="mesure">Avant, avec Sonnera.<span class="suite">Quatre situations.</span></h2>
    <p class="doux" style="margin-top:.75rem">Ce sont des exemples d'usage, pas des témoignages de clients.</p>

    <div class="grille grille--2" style="margin-top:1.5rem">
      <article class="carte">
        <h3>Boutique et commerce</h3>
        <p><strong>Avant.</strong> La gérante envoie les consignes du matin dans un groupe. Parfois personne ne répond et la caisse ouvre en retard.</p>
        <p style="margin-top:.5rem"><strong>Avec Sonnera.</strong> Chaque matin, « Ouvrir la caisse » sonne chez l'employé désigné. S'il ne répond pas, il est relancé, puis la gérante est prévenue.</p>
      </article>
      <article class="carte">
        <h3>Pharmacie ou clinique</h3>
        <p><strong>Avant.</strong> Les rondes, les contrôles de stock et les prises de médicaments reposent sur la mémoire de chacun.</p>
        <p style="margin-top:.5rem"><strong>Avec Sonnera.</strong> Les rappels se répètent aux bonnes heures. Chaque « C'est fait » est gardé dans l'historique, ce qui sert de preuve.</p>
      </article>
      <article class="carte">
        <h3>Chantier ou entretien</h3>
        <p><strong>Avant.</strong> Un problème repéré sur le terrain est décrit de vive voix, puis oublié en rentrant.</p>
        <p style="margin-top:.5rem"><strong>Avec Sonnera.</strong> Un appui sur le bouton photo ou vocal, et le constat est enregistré avec un rappel pour s'en occuper une heure plus tard.</p>
      </article>
      <article class="carte">
        <h3>Équipe et direction</h3>
        <p><strong>Avant.</strong> Demander un document à un collègue prend trois messages, et on ne sait jamais s'il l'a vu.</p>
        <p style="margin-top:.5rem"><strong>Avec Sonnera.</strong> Une demande en quelques champs, dictée si on préfère. Le collègue répond, accepte ou reporte, et la demande reste suivie.</p>
      </article>
    </div>
  </div>
</section>

<?php /* ---------------------------------------------------------- Offres */ ?>
<section class="section section--papier">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Les offres</span>
      <span class="etiquette-section__texte">L'abonnement appartient à la personne</span>
    </p>
    <h2 class="mesure">Essayez avec votre équipe<span class="suite">pendant 14 jours.</span></h2>
    <p class="mesure-large doux" style="margin-top:1rem">
      Un client s'inscrit, crée ses organisations et invite ses collègues. Son
      offre fixe le nombre d'organisations, de personnes invitées et de
      départements. Les prix sont communiqués sur demande.
    </p>

    <div class="grille grille--3" style="margin-top:1.5rem">
      <article class="carte">
        <span class="chapeau">Essai · 14 jours</span>
        <h3>Pour découvrir</h3>
        <ul class="liste-cochee">
          <li>1 organisation</li>
          <li>Jusqu'à 5 personnes invitées</li>
          <li>Jusqu'à 3 départements</li>
          <li>Toutes les fonctions pour tout tester</li>
        </ul>
      </article>
      <article class="carte">
        <span class="chapeau">Standard</span>
        <h3>Pour une petite structure</h3>
        <ul class="liste-cochee">
          <li>Jusqu'à 3 organisations</li>
          <li>Jusqu'à 25 personnes invitées</li>
          <li>Jusqu'à 10 départements</li>
          <li>Suivi d'équipe, messagerie, vocaux et photos</li>
        </ul>
      </article>
      <article class="carte">
        <span class="chapeau">Premium</span>
        <h3>Pour plusieurs sites ou une grande équipe</h3>
        <ul class="liste-cochee">
          <li>Jusqu'à 10 organisations</li>
          <li>Jusqu'à 100 personnes invitées</li>
          <li>Jusqu'à 50 départements</li>
          <li>Toutes les fonctions</li>
        </ul>
      </article>
    </div>
    <p class="doux" style="margin-top:1rem">Sonnera fonctionne sur téléphone Android.</p>
  </div>
</section>

<?php /* --------------------------------------------------- Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Combien de consignes<span class="suite">se perdent chez vous ?</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Trente minutes pour mesurer ce que les oublis et les relances vous
        coûtent, et voir si Sonnera est la bonne réponse.
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
