/* EA-SERVICES — v2. Le strict nécessaire, chargé en defer.
   Sans JavaScript, la page reste entièrement lisible : rien n'est caché par
   défaut, le menu mobile est le seul élément qui en dépend. */
(function () {
  'use strict';

  var racine = document.documentElement;
  var reduit = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* --- Bandeau d'accueil : photos illustratives en fondu enchaîné -------
     Trois photos superposées (voir accueil-v2.php), une seule opaque à la
     fois. Sans JavaScript ou en mouvement réduit, la première reste
     affichée en continu (opacité fixée en CSS) : rien ne casse. */
  var photosHeros = document.querySelectorAll('.heros__fond img');
  if (photosHeros.length > 1 && !reduit) {
    var indexHerosActif = 0;
    setInterval(function () {
      photosHeros[indexHerosActif].classList.remove('est-visible');
      photosHeros[indexHerosActif].classList.add('est-cachee');
      indexHerosActif = (indexHerosActif + 1) % photosHeros.length;
      photosHeros[indexHerosActif].classList.remove('est-cachee');
      photosHeros[indexHerosActif].classList.add('est-visible');
    }, 6000);
  }

  /* --- Titres de hero : effet machine à écrire ---------------------------
     Le HTML garde toujours le texte complet (SEO, lecteurs d'écran, affichage
     sans JavaScript) : on pose aria-label AVANT de vider le titre, donc ce
     qu'annonce un lecteur d'écran ne dépend jamais du minutage de la frappe.
     Rien n'anime en mouvement réduit — le titre reste affiché tel quel.
     Le mouvement continue après la frappe (curseur qui clignote sans fin, comme
     un vrai curseur de texte) plutôt que de réeffacer et retaper la phrase en
     boucle : un titre qui se relit sans arrêt retarde la compréhension que la
     doctrine impose en cinq secondes, et devient vite un tic visuel agaçant.
     Réutilisable : appelée au chargement, puis pour chaque fragment injecté
     dans la modale diagnostic (voir chargerFragment plus bas). */
  function animerTitresMachine(racineRecherche) {
    if (reduit) return;
    racineRecherche.querySelectorAll('h1.titre-machine').forEach(function (h1) {
      if (h1.dataset.machineFaite) return;
      h1.dataset.machineFaite = '1';

      var em = h1.querySelector('em');
      var texteComplet = h1.textContent;
      var texteEm = em ? em.textContent : '';
      var texteLigne1 = em ? texteComplet.slice(0, texteComplet.length - texteEm.length) : texteComplet;

      h1.setAttribute('aria-label', texteComplet);
      h1.textContent = '';

      var ligne1 = document.createTextNode('');
      var curseur = document.createElement('span');
      curseur.className = 'titre-machine__curseur';
      curseur.setAttribute('aria-hidden', 'true');
      h1.appendChild(ligne1);
      h1.appendChild(curseur);

      var ligne2 = null;
      if (em) {
        ligne2 = document.createElement('em');
        h1.insertBefore(ligne2, curseur);
      }

      var i = 0, k = 0, vitesse = 30;
      (function pas() {
        if (i < texteLigne1.length) {
          i++;
          ligne1.textContent = texteLigne1.slice(0, i);
          setTimeout(pas, vitesse);
          return;
        }
        if (ligne2 && k < texteEm.length) {
          k++;
          ligne2.textContent = texteEm.slice(0, k);
          ligne2.appendChild(curseur);
          setTimeout(pas, vitesse);
          return;
        }
        // Fini : le curseur reste, il continue simplement de clignoter
        // (animation CSS déjà en boucle) — rien à faire ici.
      })();
    });
  }
  animerTitresMachine(document);

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

  /* --- Modale diagnostic --------------------------------------------------
     Uniquement /diagnostic : c'est le seul contrôleur qui sait répondre en
     fragment (en-tête X-Modale, voir DiagnosticController et
     Controleur::estRequeteModale). /pages/contact reste volontairement un
     vrai lien de page entière — le formulaire n'y est qu'un élément parmi
     trois canaux et une FAQ, bien plus qu'une modale ne devrait porter, et
     PageController ne sait pas répondre en fragment.
     Les liens vers /diagnostic restent de vrais liens : sans JavaScript (ou
     si <dialog> n'est pas supporté), ils naviguent normalement, en pleine
     page — rien ne change pour ce visiteur-là. */
  var modale = document.getElementById('modale-diagnostic');
  var corps  = document.getElementById('modale-diagnostic-corps');

  if (modale && corps && typeof modale.showModal === 'function' && window.fetch) {
    var declencheur = null;

    function chargerFragment(url, methode, corpsRequete) {
      corps.innerHTML = '<p class="modale__attente">Chargement…</p>';
      var options = {
        method: methode || 'GET',
        headers: { 'X-Modale': '1' },
        credentials: 'same-origin'
      };
      if (corpsRequete) options.body = corpsRequete;
      fetch(url, options)
        .then(function (reponse) { return reponse.text(); })
        .then(function (html) {
          corps.innerHTML = html;
          corps.scrollTop = 0;
          animerTitresMachine(corps);
        })
        .catch(function () {
          corps.innerHTML = '<div class="alerte alerte--erreur" style="margin:1.5rem">' +
            'Le chargement a échoué. <a href="' + url + '">Ouvrir la page complète</a> à la place.</div>';
        });
    }

    function ouvrir(url, depuis) {
      declencheur = depuis || null;
      modale.showModal();
      document.body.style.overflow = 'hidden';
      chargerFragment(url, 'GET');
    }

    /* Le nettoyage (défilement, focus) vit dans une fonction à part, appelée
       à la fois par fermer() ET par l'évènement natif "close" (déclenché par
       la touche Échap, gérée par le navigateur sans passer par fermer()).
       L'évènement "close" d'un <dialog> ne s'étant pas montré fiable ici sur
       un close() déclenché par script, ne pas en dépendre seul. */
    function nettoyer() {
      document.body.style.overflow = '';
      if (declencheur) declencheur.focus();
    }

    function fermer() {
      modale.close();
      nettoyer();
    }

    modale.addEventListener('close', nettoyer);

    // Clic sur le calque (::backdrop) : un clic sur <dialog> lui-même (pas un
    // de ses enfants) signifie qu'il a touché le calque, pas le contenu.
    modale.addEventListener('click', function (ev) {
      if (ev.target === modale) fermer();
    });

    document.querySelectorAll('[data-action="fermer-modale"]').forEach(function (bouton) {
      bouton.addEventListener('click', fermer);
    });

    // Délégation : le formulaire du diagnostic est injecté après coup, donc
    // écouté depuis le conteneur statique plutôt que directement sur lui.
    corps.addEventListener('submit', function (ev) {
      var form = ev.target.closest('form');
      if (!form) return;
      ev.preventDefault();
      chargerFragment(form.action, 'POST', new FormData(form));
    });

    document.querySelectorAll('a[href="/diagnostic"]').forEach(function (lien) {
      if (lien.target === '_blank') return;
      lien.addEventListener('click', function (ev) {
        ev.preventDefault();
        ouvrir(lien.getAttribute('href'), lien);
      });
    });
  }

  /* --- Agent de conversation ----------------------------------------------
     Le bouton reste [hidden] dans le HTML tant que ce bloc n'a pas confirmé
     que tout est disponible (dialog, fetch, localStorage) — plutôt qu'un
     bouton visible qui ne répondrait à rien sur un vieux navigateur. */
  var ouvreurChat = document.getElementById('chat-ouvrir');
  var fenetreChat = document.getElementById('chat-fenetre');
  var messagesChat = document.getElementById('chat-messages');
  var formChat = document.getElementById('chat-formulaire');
  var saisieChat = document.getElementById('chat-saisie');

  if (ouvreurChat && fenetreChat && messagesChat && formChat && saisieChat &&
      typeof fenetreChat.show === 'function' && window.fetch && window.localStorage) {

    ouvreurChat.hidden = false;

    // localStorage plutôt que sessionStorage : un visiteur qui ferme le
    // navigateur et revient trois jours plus tard retrouve sa conversation
    // — ea-services.net doit avoir l'air d'un vrai service, pas d'un
    // formulaire qui oublie tout à chaque visite. L'historique visible est
    // restauré depuis le serveur juste en dessous (restaurerHistorique).
    var conversationId = null;
    try {
      conversationId = localStorage.getItem('ea_chat_conversation');
      if (!conversationId) {
        conversationId = (window.crypto && crypto.randomUUID) ? crypto.randomUUID()
          : String(Date.now()) + Math.random().toString(16).slice(2);
        localStorage.setItem('ea_chat_conversation', conversationId);
      }
    } catch (e) {
      conversationId = String(Date.now());
    }

    // Même motif que ChatController::securiserChemins côté serveur : à ce
    // stade, tout chemin encore présent dans le texte a déjà été vérifié
    // contre la vraie liste des adresses du site (sinon toute la réponse a
    // été remplacée côté serveur) — le transformer en vrai lien cliquable
    // ici est donc sûr, jamais un lien mort dans la bouche d'EMTITÉ.
    var MOTIF_CHEMIN = /(?:^|(?<=\s))\/[a-zA-Z][a-zA-Z0-9/_-]{1,60}[.,;:!?)]*(?=\s|$)/g;

    function ajouterBulle(role, texte) {
      var p = document.createElement('p');
      p.className = 'chat-bulle-msg chat-bulle-msg--' + role;

      var dernier = 0;
      var correspondance;
      MOTIF_CHEMIN.lastIndex = 0;
      while ((correspondance = MOTIF_CHEMIN.exec(texte)) !== null) {
        var chemin = correspondance[0];
        var debut = correspondance.index;
        if (debut > dernier) p.appendChild(document.createTextNode(texte.slice(dernier, debut)));

        var propre = chemin.replace(/[.,;:!?)]+$/, '');
        var reste = chemin.slice(propre.length);
        var lien = document.createElement('a');
        lien.href = propre;
        lien.textContent = propre;
        p.appendChild(lien);
        if (reste) p.appendChild(document.createTextNode(reste));

        dernier = debut + chemin.length;
      }
      if (dernier < texte.length) p.appendChild(document.createTextNode(texte.slice(dernier)));

      messagesChat.appendChild(p);
      messagesChat.scrollTop = messagesChat.scrollHeight;
      return p;
    }

    function afficherAttente() {
      var conteneur = document.createElement('div');
      conteneur.className = 'chat-attente';
      conteneur.innerHTML = '<span></span><span></span><span></span>';
      messagesChat.appendChild(conteneur);
      messagesChat.scrollTop = messagesChat.scrollHeight;
      return conteneur;
    }

    /* Le serveur vérifie que le cookie client présenté correspond bien au
       propriétaire de cet identifiant de conversation (voir
       ChatController::historique) — sans ça, un identifiant récupéré ou
       deviné donnerait accès à la conversation de quelqu'un d'autre. Si rien
       n'est retourné (première visite, ou conversation trop ancienne), le
       message d'accueil statique reste affiché tel quel. */
    fetch('/chat/historique?conversation_id=' + encodeURIComponent(conversationId), {
      credentials: 'same-origin'
    })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (!d.ok || !d.messages || !d.messages.length) return;
        messagesChat.innerHTML = '';
        d.messages.forEach(function (m) {
          ajouterBulle(m.role === 'user' ? 'client' : 'agent', m.contenu);
        });
      })
      .catch(function () { /* l'accueil statique suffit si ça échoue */ });

    // La classe sur <body> masque les boutons flottants (WhatsApp, bulle de
    // chat) pendant que la fenêtre est ouverte — voir le commentaire dans
    // ea-v2.css sur dialog.chat-fenetre pour le bug réel que ça referme.
    function fermerChat() {
      fenetreChat.close();
      document.body.classList.remove('chat-ouverte');
    }

    var inviteActive = null;
    function retirerInvite() {
      if (inviteActive) { inviteActive.remove(); inviteActive = null; }
    }

    ouvreurChat.addEventListener('click', function () {
      fenetreChat.show();
      document.body.classList.add('chat-ouverte');
      saisieChat.focus();
      retirerInvite();
      try { sessionStorage.setItem('ea_chat_deja_ouvert', '1'); } catch (e) {}
    });

    /* Invitation à discuter : une fois par session (sessionStorage, pas
       localStorage) — elle revient si le visiteur ferme son navigateur et
       repasse un autre jour, mais ne harcèle pas d'une page à l'autre
       pendant la même visite. Le texte est fixe, jamais généré — rien à
       sécuriser ici, contrairement aux réponses d'EMTITÉ. */
    (function () {
      var dejaVue, dejaOuvert;
      try {
        dejaVue = sessionStorage.getItem('ea_chat_invite_vue');
        dejaOuvert = sessionStorage.getItem('ea_chat_deja_ouvert');
      } catch (e) { return; }
      if (dejaVue || dejaOuvert || reduit) return;

      setTimeout(function () {
        if (document.body.classList.contains('chat-ouverte')) return;

        var bulle = document.createElement('div');
        bulle.className = 'chat-invite';
        bulle.setAttribute('role', 'status');

        var texte = document.createElement('div');
        texte.className = 'chat-invite__texte';
        var titre = document.createElement('strong');
        titre.textContent = 'Une question ?';
        var corps = document.createElement('span');
        corps.textContent = 'EMTITÉ peut vous orienter vers le bon service en quelques secondes.';
        texte.appendChild(titre);
        texte.appendChild(corps);

        var fermer = document.createElement('button');
        fermer.type = 'button';
        fermer.className = 'chat-invite__fermer';
        fermer.setAttribute('aria-label', "Fermer l'invitation");
        fermer.innerHTML = '<svg class="ico" aria-hidden="true" focusable="false" style="width:1rem;height:1rem">'
          + '<use href="/assets/icones.svg#fermer"></use></svg>';

        bulle.appendChild(texte);
        bulle.appendChild(fermer);
        document.body.appendChild(bulle);
        inviteActive = bulle;

        try { sessionStorage.setItem('ea_chat_invite_vue', '1'); } catch (e) {}

        bulle.addEventListener('click', function (ev) {
          if (ev.target === fermer) { retirerInvite(); return; }
          retirerInvite();
          ouvreurChat.click();
        });

        setTimeout(retirerInvite, 10000);
      }, 9000);
    })();

    document.querySelectorAll('[data-action="fermer-chat"]').forEach(function (bouton) {
      bouton.addEventListener('click', fermerChat);
    });

    formChat.addEventListener('submit', function (ev) {
      ev.preventDefault();
      var texte = saisieChat.value.trim();
      if (!texte) return;

      ajouterBulle('client', texte);
      saisieChat.value = '';
      saisieChat.disabled = true;
      var bouton = formChat.querySelector('button');
      bouton.disabled = true;
      var attente = afficherAttente();

      fetch('/chat/message', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ conversation_id: conversationId, message: texte })
      })
        .then(function (reponse) { return reponse.json().then(function (d) { return { statut: reponse.status, corps: d }; }); })
        .then(function (r) {
          attente.remove();
          if (r.corps && r.corps.texte) {
            ajouterBulle(r.corps.ok ? 'agent' : 'systeme', r.corps.texte);
          } else {
            ajouterBulle('systeme', "Une erreur est survenue. Réessayez, ou écrivez-nous sur WhatsApp.");
          }
        })
        .catch(function () {
          attente.remove();
          ajouterBulle('systeme', "La connexion a échoué. Écrivez-nous sur WhatsApp, on vous répond directement.");
        })
        .finally(function () {
          saisieChat.disabled = false;
          bouton.disabled = false;
          saisieChat.focus();
        });
    });
  }

  /* --- Copier le lien d'un article (partage) ----------------------------- */
  document.addEventListener('click', function (ev) {
    var bouton = ev.target.closest('[data-copier-lien]');
    if (!bouton) return;
    var lien = bouton.dataset.lien;
    if (!lien) return;

    var confirmer = function () {
      var original = bouton.innerHTML;
      bouton.setAttribute('data-copie', '1');
      bouton.setAttribute('aria-label', 'Lien copié');
      setTimeout(function () {
        bouton.removeAttribute('data-copie');
        bouton.setAttribute('aria-label', 'Copier le lien');
      }, 1800);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(lien).then(confirmer, function () {});
    } else {
      var champ = document.createElement('textarea');
      champ.value = lien;
      champ.style.position = 'fixed';
      champ.style.opacity = '0';
      document.body.appendChild(champ);
      champ.select();
      try { document.execCommand('copy'); confirmer(); } catch (e) {}
      champ.remove();
    }
  });
  /* --- Confirmation de visite réelle ---------------------------------------
     Un robot charge la page mais ne touche rien. Au premier défilement,
     toucher ou clic, on prévient le serveur une seule fois : c'est ce qui
     permet de compter les vraies personnes. Aucune donnée personnelle. */
  (function () {
    var envoye = false;
    var evenements = ['scroll', 'touchstart', 'pointerdown', 'keydown'];
    function confirmer() {
      if (envoye) return;
      envoye = true;
      evenements.forEach(function (e) { window.removeEventListener(e, confirmer); });
      try {
        var corps = new URLSearchParams({ p: location.pathname });
        if (navigator.sendBeacon) { navigator.sendBeacon('/__h', corps); }
        else { fetch('/__h', { method: 'POST', body: corps, keepalive: true }); }
      } catch (e) {}
    }
    evenements.forEach(function (e) { window.addEventListener(e, confirmer, { passive: true }); });
  })();
})();
