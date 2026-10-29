/* EA-SERVICES — le strict nécessaire, chargé en defer.
   Rien ici ne conditionne la lecture du site : sans JavaScript, toutes les
   pages restent lisibles et le formulaire de contact fonctionne (il s'envoie
   en POST classique). */
(function () {
  'use strict';

  /* --- Thème -------------------------------------------------------------
     La pose du thème se fait dans le <head> (voir le layout), sinon la page
     clignote en clair avant de passer en sombre. Ici on ne gère que la
     bascule. */
  var racine = document.documentElement;
  var bascule = document.querySelector('[data-action="theme"]');

  function appliquer(theme) {
    if (theme === 'sombre') racine.setAttribute('data-theme', 'sombre');
    else racine.removeAttribute('data-theme');
    if (bascule) {
      var sombre = theme === 'sombre';
      bascule.setAttribute('aria-label', sombre ? 'Passer en thème clair' : 'Passer en thème sombre');
      var usage = bascule.querySelector('use');
      if (usage) usage.setAttribute('href', sombre ? '/assets/icones.svg#soleil' : '/assets/icones.svg#lune');
    }
  }

  if (bascule) {
    appliquer(racine.getAttribute('data-theme') === 'sombre' ? 'sombre' : 'clair');
    bascule.addEventListener('click', function () {
      var suivant = racine.getAttribute('data-theme') === 'sombre' ? 'clair' : 'sombre';
      appliquer(suivant);
      try { localStorage.setItem('ea_theme', suivant); } catch (e) {}
    });
  }

  /* --- Menu mobile -------------------------------------------------------
     Un panneau qui s'ouvre au clic, jamais au survol : le survol n'existe
     pas au doigt. */
  var ouvreur = document.querySelector('[data-action="menu"]');
  var panneau = document.getElementById('menu-mobile');

  if (ouvreur && panneau) {
    ouvreur.addEventListener('click', function () {
      var ouvert = panneau.getAttribute('data-ouvert') === 'oui';
      panneau.setAttribute('data-ouvert', ouvert ? 'non' : 'oui');
      ouvreur.setAttribute('aria-expanded', String(!ouvert));
      var usage = ouvreur.querySelector('use');
      if (usage) usage.setAttribute('href', ouvert ? '/assets/icones.svg#menu' : '/assets/icones.svg#fermer');
    });
    document.addEventListener('keydown', function (ev) {
      if (ev.key === 'Escape' && panneau.getAttribute('data-ouvert') === 'oui') ouvreur.click();
    });
  }

  /* --- Bandeau cookies ---------------------------------------------------
     Le choix conditionne l'enregistrement de l'adresse IP dans les
     statistiques de visite (voir EA\Core\Visites). */
  var bandeau = document.getElementById('cookies');
  if (bandeau) {
    var deja = document.cookie.indexOf('ea_consent=') !== -1;
    if (!deja) bandeau.setAttribute('data-visible', 'oui');

    bandeau.addEventListener('click', function (ev) {
      var choix = ev.target.closest('[data-consent]');
      if (!choix) return;
      var valeur = choix.getAttribute('data-consent');
      var unAn = new Date(Date.now() + 31536000000).toUTCString();
      document.cookie = 'ea_consent=' + valeur + '; expires=' + unAn + '; path=/; SameSite=Lax';
      bandeau.removeAttribute('data-visible');
    });
  }

  /* --- Formulaire de contact --------------------------------------------
     Envoi sans rechargement quand JavaScript est là ; sinon le POST normal
     du formulaire prend le relais. */
  var formulaire = document.getElementById('formulaire-contact');
  if (formulaire) {
    formulaire.addEventListener('submit', function (ev) {
      ev.preventDefault();
      var retour = document.getElementById('retour-contact');
      var envoi = formulaire.querySelector('button[type="submit"]');
      var libelle = envoi ? envoi.textContent : '';
      if (envoi) { envoi.disabled = true; envoi.textContent = 'Envoi en cours…'; }

      fetch(formulaire.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: new FormData(formulaire)
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (!retour) return;
          retour.className = 'alerte ' + (data.ok ? 'alerte--ok' : 'alerte--erreur');
          retour.textContent = data.message;
          retour.hidden = false;
          if (data.ok) formulaire.reset();
          retour.scrollIntoView({ block: 'center' });
        })
        .catch(function () {
          if (!retour) return;
          retour.className = 'alerte alerte--erreur';
          retour.textContent = "L'envoi a échoué. Écrivez-nous directement à " + (formulaire.dataset.courriel || '');
          retour.hidden = false;
        })
        .finally(function () {
          if (envoi) { envoi.disabled = false; envoi.textContent = libelle; }
        });
    });
  }

  var reduit = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* --- Révélation au défilement -------------------------------------------
     Les cartes de bénéfice, étapes et vignettes apparaissent en douceur
     quand elles entrent dans l'écran, au lieu d'être toutes plaquées d'un
     coup à l'ouverture de la page. La classe `.reveal` n'existe qu'ici :
     sans JavaScript le contenu reste pleinement visible dès le chargement
     (voir la règle par défaut dans ea.css). */
  if ('IntersectionObserver' in window && !reduit) {
    // Le bandeau d'accueil (hero__preuve) est déjà dans l'écran au chargement :
    // lui appliquer un fondu produit un flash de contenu invisible sur les
    // connexions lentes, sans aucun bénéfice puisqu'il n'y a rien à « découvrir »
    // en défilant. Seul le contenu réellement sous la ligne de flottaison
    // mérite cette révélation.
    var cibles = document.querySelectorAll('.carte, .gain, .etape, .vignette');
    // Les titres de section (sur-titre + h2 groupés dans .entete-section)
    // montent ensemble, avec un mouvement plus ample que les cartes — "les
    // titres doivent être animés" : ce n'est pas le même traitement que le
    // contenu qu'ils annoncent, sinon toute la page bouge d'un seul bloc.
    var titres = document.querySelectorAll('.entete-section');
    if (cibles.length || titres.length) {
      cibles.forEach(function (el, i) {
        el.classList.add('reveal');
        el.style.transitionDelay = (Math.min(i % 4, 3) * 70) + 'ms';
      });
      titres.forEach(function (el) { el.classList.add('reveal', 'reveal--titre'); });

      var observateur = new IntersectionObserver(function (entrees) {
        entrees.forEach(function (entree) {
          if (!entree.isIntersecting) return;
          entree.target.classList.add('reveal--visible');
          observateur.unobserve(entree.target);
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      cibles.forEach(function (el) { observateur.observe(el); });
      titres.forEach(function (el) { observateur.observe(el); });

      // Filet de sécurité : si l'observateur ne se déclenche jamais (fenêtre
      // déjà scrollée, bogue de navigateur…), tout redevient visible plutôt
      // que de rester caché indéfiniment.
      setTimeout(function () {
        document.querySelectorAll('.reveal:not(.reveal--visible)').forEach(function (el) {
          el.classList.add('reveal--visible');
        });
      }, 4000);
    }
  }
})();
