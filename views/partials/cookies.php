<?php
/**
 * Bandeau de consentement.
 *
 * Le seul enjeu réel ici est l'adresse IP dans les statistiques de visite :
 * elle n'est enregistrée qu'après acceptation (voir EA\Core\Visites). Sans
 * acceptation, la visite est comptée de façon anonyme. Le texte le dit
 * exactement, sans formule creuse.
 */
?>
<div class="cookies" id="cookies" role="region" aria-label="Consentement à la mesure d'audience">
  <p>Nous comptons les pages consultées pour savoir ce qui vous est utile.
     Votre adresse de connexion n'est conservée que si vous l'acceptez.</p>
  <div class="rangee">
    <button type="button" class="bouton bouton--contour" data-consent="refuse">Refuser</button>
    <button type="button" class="bouton bouton--marine" data-consent="accepte">Accepter</button>
  </div>
</div>
