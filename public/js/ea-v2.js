/* EA-SERVICES — v2. Le strict nécessaire, chargé en defer.
   Sans JavaScript, la page reste entièrement lisible : rien n'est caché par
   défaut, le menu mobile est le seul élément qui en dépend. */
(function () {
  'use strict';

  var racine = document.documentElement;
  var reduit = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* --- Thème ------------------------------------------------------------ */
  var bascule = document.querySelector('[data-action="theme"]');
  function appliquer(theme) {
    if (theme === 'sombre') racine.setAttribute('data-theme', 'sombre');
    else racine.removeAttribute('data-theme');
    if (!bascule) return;
    var sombre = theme === 'sombre';
    bascule.setAttribute('aria-label', sombre ? 'Passer en thème clair' : 'Passer en thème sombre');
    var usage = bascule.querySelector('use');
    if (usage) usage.setAttribute('href', sombre ? '/assets/icones.svg#soleil' : '/assets/icones.svg#lune');
  }
  if (bascule) {
    appliquer(racine.getAttribute('data-theme') === 'sombre' ? 'sombre' : 'clair');
    bascule.addEventListener('click', function () {
      var suivant = racine.getAttribute('data-theme') === 'sombre' ? 'clair' : 'sombre';
      appliquer(suivant);
      try { localStorage.setItem('ea_theme', suivant); } catch (e) {}
    });
  }

  /* --- Menu mobile ------------------------------------------------------ */
  var ouvreur = document.querySelector('[data-action="menu"]');
  var panneau = document.getElementById('menu-mobile');
  if (ouvreur && panneau) {
    ouvreur.addEventListener('click', function () {
      var ouvert = panneau.getAttribute('data-ouvert') === 'oui';
      panneau.setAttribute('data-ouvert', ouvert ? 'non' : 'oui');
      ouvreur.setAttribute('aria-expanded', String(!ouvert));
      ouvreur.setAttribute('aria-label', ouvert ? 'Ouvrir le menu' : 'Fermer le menu');
      var usage = ouvreur.querySelector('use');
      if (usage) usage.setAttribute('href', ouvert ? '/assets/icones.svg#menu' : '/assets/icones.svg#fermer');
    });
    document.addEventListener('keydown', function (ev) {
      if (ev.key === 'Escape' && panneau.getAttribute('data-ouvert') === 'oui') ouvreur.click();
    });
  }

  /* --- Bandeau cookies -------------------------------------------------- */
  var bandeau = document.getElementById('cookies');
  if (bandeau) {
    if (document.cookie.indexOf('ea_consent=') === -1) bandeau.setAttribute('data-visible', 'oui');
    bandeau.addEventListener('click', function (ev) {
      var choix = ev.target.closest('[data-consent]');
      if (!choix) return;
      var unAn = new Date(Date.now() + 31536000000).toUTCString();
      document.cookie = 'ea_consent=' + choix.getAttribute('data-consent') +
                        '; expires=' + unAn + '; path=/; SameSite=Lax';
      bandeau.removeAttribute('data-visible');
    });
  }

  /* --- Le seul mouvement du site ----------------------------------------
     Les chiffres se posent quand ils entrent dans l'écran. Un seul geste,
     réservé aux chiffres — c'est ce qui en fait une signature plutôt qu'un
     effet. La v1 appliquait le même fondu à toutes les cartes, ce que tout
     le monde reconnaît maintenant comme un gabarit rempli.

     Le bandeau d'accueil est exclu : il est déjà à l'écran au chargement,
     l'animer ne fait que retarder la lecture du premier chiffre. */
  if ('IntersectionObserver' in window && !reduit) {
    var chiffres = document.querySelectorAll(
      '.releve__chiffre, .manifeste__impact, .bascule strong'
    );
    if (chiffres.length) {
      chiffres.forEach(function (el) { el.classList.add('pose'); });

      var observateur = new IntersectionObserver(function (entrees) {
        entrees.forEach(function (entree) {
          if (!entree.isIntersecting) return;
          entree.target.classList.add('pose--visible');
          observateur.unobserve(entree.target);
        });
      }, { threshold: 0.5, rootMargin: '0px 0px -30px 0px' });

      chiffres.forEach(function (el) { observateur.observe(el); });

      /* Filet de sécurité : si l'observateur ne se déclenche jamais, tout
         redevient visible plutôt que de rester caché. */
      setTimeout(function () {
        document.querySelectorAll('.pose:not(.pose--visible)').forEach(function (el) {
          el.classList.add('pose--visible');
        });
      }, 3000);
    }
  }
})();
