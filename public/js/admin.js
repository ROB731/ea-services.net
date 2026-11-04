/* EA-SERVICES — administration.
   Actions courantes (supprimer, publier, marquer comme lu, valider) sans
   rechargement de page. Chaque formulaire reste un VRAI formulaire : sans
   JavaScript, l'action passe toujours par la soumission classique et la
   redirection déjà en place côté serveur (voir AdminController). */
(function () {
  'use strict';

  function toast(message, estErreur) {
    var zone = document.getElementById('admin-toast');
    if (!zone) {
      zone = document.createElement('div');
      zone.id = 'admin-toast';
      zone.setAttribute('role', 'status');
      zone.setAttribute('aria-live', 'polite');
      zone.style.cssText = 'position:fixed;left:50%;bottom:1.5rem;transform:translateX(-50%);'
        + 'z-index:80;display:flex;flex-direction:column;gap:.5rem;align-items:center;pointer-events:none';
      document.body.appendChild(zone);
    }
    var bulle = document.createElement('div');
    bulle.textContent = message;
    bulle.style.cssText = 'padding:.75rem 1.25rem;border-radius:999px;font-size:.9375rem;font-weight:600;'
      + 'box-shadow:0 10px 30px rgba(0,0,0,.25);color:#fff;background:'
      + (estErreur ? 'var(--perte,#b42318)' : 'var(--marine-800,#14274e)');
    zone.appendChild(bulle);
    setTimeout(function () {
      bulle.style.transition = 'opacity .3s';
      bulle.style.opacity = '0';
      setTimeout(function () { bulle.remove(); }, 300);
    }, 2200);
  }

  if (!window.fetch) return; // pas de repli à construire : les formulaires marchent déjà seuls

  document.addEventListener('submit', function (ev) {
    var form = ev.target.closest('form[data-async]');
    if (!form) return;

    var type = form.dataset.async;
    var confirmation = form.dataset.confirmer;
    if (confirmation && !window.confirm(confirmation)) { ev.preventDefault(); return; }

    ev.preventDefault();
    var bouton = form.querySelector('button[type="submit"]');
    if (bouton) bouton.disabled = true;

    fetch(form.action, {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      credentials: 'same-origin',
      body: new FormData(form)
    })
      .then(function (r) { return r.json().then(function (d) { return { statut: r.status, corps: d }; }); })
      .then(function (r) {
        if (!r.corps || !r.corps.ok) {
          toast((r.corps && r.corps.erreur) || 'Une erreur est survenue.', true);
          if (bouton) bouton.disabled = false;
          return;
        }
        appliquer(type, form, r.corps);
      })
      .catch(function () {
        toast('La connexion a échoué. Réessayez.', true);
        if (bouton) bouton.disabled = false;
      });
  });

  function appliquer(type, form, reponse) {
    var ligne = form.closest('[data-ligne]');

    if (type === 'supprimer') {
      if (ligne) {
        ligne.style.transition = 'opacity .25s, transform .25s';
        ligne.style.opacity = '0';
        ligne.style.transform = 'translateX(-.5rem)';
        setTimeout(function () {
          ligne.remove();
          verifierListeVide();
          mettreAJourCompteTemoignages();
        }, 250);
      }
      toast('Supprimé.');
      return;
    }

    if (type === 'lue') {
      if (ligne) {
        ligne.classList.remove('carte--a-traiter');
        var badge = ligne.querySelector('.etiquette');
        if (badge) badge.remove();
      }
      form.remove(); // le bouton "marquer comme traitée" n'a plus lieu d'être
      toast('Marquée comme traitée.');
      return;
    }

    if (type === 'valider') {
      if (ligne) {
        ligne.classList.remove('carte--a-traiter');
        var attente = ligne.querySelector('[data-badge-attente]');
        if (attente) attente.remove();
      }
      form.remove();
      toast('Commentaire publié.');
      return;
    }

    if (type === 'basculer') {
      var etat = ligne ? ligne.querySelector('[data-etat-publication]') : null;
      var badge = etat ? etat.querySelector('.badge-etat') : null;
      if (badge) {
        badge.textContent = reponse.publie ? 'Publié' : 'Brouillon';
        badge.className = 'badge-etat badge-etat--' + (reponse.publie ? 'publie' : 'brouillon');
      }
      if (ligne) ligne.dataset.etatLigne = reponse.publie ? 'publie' : 'brouillon';
      var boutonBascule = form.querySelector('button[type="submit"]');
      if (boutonBascule) boutonBascule.textContent = reponse.publie ? 'Masquer' : 'Publier';
      toast(reponse.publie ? 'Article publié.' : 'Article masqué.');
      return;
    }

    if (type === 'ajouter-temoignage') {
      var liste = document.getElementById('liste-temoignages');
      if (liste && reponse.temoignage) {
        var jeton = document.querySelector('input[name="csrf"]');
        liste.insertAdjacentHTML('afterbegin', gabaritTemoignage(reponse.temoignage, jeton ? jeton.value : ''));
        mettreAJourCompteTemoignages();
      }
      form.reset();
      toast('Témoignage ajouté.');
      return;
    }
  }

  function verifierListeVide() {
    document.querySelectorAll('[data-liste-vide]').forEach(function (conteneur) {
      var reste = conteneur.querySelectorAll('[data-ligne]').length;
      var message = conteneur.querySelector('[data-message-vide]');
      if (reste === 0 && message) message.hidden = false;
    });
  }

  function mettreAJourCompteTemoignages() {
    var titre = document.getElementById('compte-temoignages');
    var liste = document.getElementById('liste-temoignages');
    if (!titre || !liste) return;
    var n = liste.querySelectorAll('[data-ligne]').length;
    titre.textContent = n + ' témoignage' + (n > 1 ? 's' : '');
  }

  function echapper(texte) {
    var d = document.createElement('div');
    d.textContent = texte;
    return d.innerHTML;
  }

  // Doit correspondre EXACTEMENT au HTML rendu côté serveur dans
  // views/admin/temoignages.php — même structure, même style, même
  // attribut data-ligne, sinon la carte fraîchement ajoutée ne réagirait
  // pas comme les autres (compteur, suppression, liste vide).
  function gabaritTemoignage(t, csrf) {
    var etoiles = '★'.repeat(Math.max(0, Math.min(5, t.rating)));
    return '<div class="ligne-temoignage" data-ligne>'
      + '<p style="margin-bottom:.25rem">« ' + echapper(t.comment) + ' »</p>'
      + '<p class="doux" style="font-size:.875rem;margin-bottom:.5rem">'
      + '<strong>' + echapper(t.name) + '</strong> · <span style="color:var(--or-600)">' + etoiles + '</span></p>'
      + '<div class="rangee" style="flex-wrap:nowrap">'
      + '<a class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" '
      + 'href="/admin/temoignages/' + t.id + '">Modifier</a>'
      + '<form method="post" action="/admin/temoignages/supprimer" data-async="supprimer" '
      + 'data-confirmer="Supprimer ce témoignage ?">'
      + '<input type="hidden" name="csrf" value="' + echapper(csrf) + '">'
      + '<input type="hidden" name="id" value="' + t.id + '">'
      + '<button class="bouton bouton--contour" style="min-height:2.25rem;padding:.25rem .625rem" type="submit">Supprimer</button>'
      + '</form></div></div>';
  }

  // --- Assistant : brouillon d'article -------------------------------------
  // Remplit le formulaire, ne l'envoie jamais tout seul : le dirigeant relit,
  // corrige, choisit Publié/Brouillon puis enregistre lui-même.
  var boutonArticle = document.getElementById('assistant-generer-article');
  if (boutonArticle) {
    boutonArticle.addEventListener('click', function () {
      var sujet = (document.getElementById('assistant-sujet') || {}).value || '';
      var points = (document.getElementById('assistant-points') || {}).value || '';
      var etat = document.getElementById('assistant-article-etat');
      var jeton = document.querySelector('input[name="csrf"]');
      if (!sujet.trim()) {
        if (etat) etat.textContent = "Indiquez d'abord un sujet.";
        return;
      }
      boutonArticle.disabled = true;
      if (etat) etat.textContent = 'Rédaction en cours…';

      var donnees = new FormData();
      donnees.append('sujet', sujet);
      donnees.append('points', points);
      donnees.append('csrf', jeton ? jeton.value : '');

      fetch('/admin/assistant/article', {
        method: 'POST', headers: { Accept: 'application/json' },
        credentials: 'same-origin', body: donnees
      })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (!d.ok) {
            if (etat) etat.textContent = d.erreur || "L'assistant n'a pas pu répondre.";
            return;
          }
          var champTitre = document.getElementById('titre');
          var champCategorie = document.getElementById('categorie');
          var champExtrait = document.getElementById('extrait');
          var champContenu = document.getElementById('contenu');
          var champPublie = document.getElementById('publie');
          if (champTitre && d.article.titre) champTitre.value = d.article.titre;
          if (champCategorie && d.article.categorie) champCategorie.value = d.article.categorie;
          if (champExtrait && d.article.extrait) champExtrait.value = d.article.extrait;

          // L'assistant découpe sa proposition en sections (une par idée) :
          // une carte par section est ajoutée, prête à recevoir une vraie
          // photo. Il ne fournit jamais l'image elle-même — seulement un
          // prompt prêt à coller dans un générateur d'images, affiché en
          // dessous (jamais dans le champ URL, qui doit rester vide tant
          // qu'une vraie image n'a pas été choisie ou générée).
          // Le champ "Contenu" simple reçoit TOUJOURS une copie du texte
          // complet, même quand des sections sont créées : c'est un filet de
          // sécurité si les sections sont supprimées plus tard, et ça évite
          // qu'il paraisse vide après une génération.
          var nbSections = 0;
          var texteComplet = [];
          if (d.article.sections && d.article.sections.length) {
            d.article.sections.forEach(function (s) {
              var carte = ajouterSectionVide();
              if (!carte) return;
              var champHeading = carte.querySelector('input[name*="[heading]"]');
              var champBody = carte.querySelector('textarea[name*="[body]"]');
              var blocPrompt = carte.querySelector('[data-section-bloc-prompt]');
              var champPrompt = carte.querySelector('[data-section-prompt-image]');
              var indiceVideo = carte.querySelector('[data-section-suggestion-video]');
              if (champHeading && s.heading) champHeading.value = s.heading;
              if (champBody && s.body) champBody.value = s.body;
              if (champPrompt && s.image_prompt) {
                champPrompt.value = s.image_prompt;
                if (blocPrompt) blocPrompt.hidden = false;
              }
              if (indiceVideo && s.video_suggestion) indiceVideo.textContent = 'Suggestion de l\'assistant : ' + s.video_suggestion;
              texteComplet.push((s.heading ? s.heading + '\n\n' : '') + (s.body || ''));
              nbSections++;
            });
          } else if (d.article.contenu) {
            texteComplet.push(d.article.contenu);
          }
          if (champContenu && texteComplet.length) champContenu.value = texteComplet.join('\n\n');

          // Toujours repasser en brouillon après une génération : une
          // relecture est obligatoire avant toute mise en ligne.
          if (champPublie) champPublie.value = '0';
          if (etat) {
            etat.textContent = nbSections
              ? nbSections + ' section(s) ajoutées — relisez chacune, complétez les exemples chiffrés, et collez le prompt image dans ChatGPT pour l\'illustrer.'
              : 'Brouillon inséré — relisez et complétez les exemples chiffrés avant de publier.';
          }
          toast('Brouillon proposé par l\'assistant.');
        })
        .catch(function () {
          if (etat) etat.textContent = 'Connexion impossible. Réessayez.';
        })
        .finally(function () { boutonArticle.disabled = false; });
    });
  }

  // --- Assistant : orthographe d'un témoignage réel ------------------------
  // Ne corrige que la forme d'un texte déjà collé par le dirigeant — ne
  // génère jamais de contenu à partir de rien (voir AdminController).
  var boutonAvis = document.getElementById('assistant-corriger-avis');
  if (boutonAvis) {
    boutonAvis.addEventListener('click', function () {
      var champAvis = document.getElementById('avis');
      var jeton = document.querySelector('input[name="csrf"]');
      if (!champAvis || !champAvis.value.trim()) {
        toast("Collez d'abord le texte du client dans le champ.", true);
        return;
      }
      boutonAvis.disabled = true;
      var texteOriginal = boutonAvis.textContent;
      boutonAvis.textContent = 'Correction…';

      var donnees = new FormData();
      donnees.append('texte', champAvis.value);
      donnees.append('csrf', jeton ? jeton.value : '');

      fetch('/admin/assistant/temoignage', {
        method: 'POST', headers: { Accept: 'application/json' },
        credentials: 'same-origin', body: donnees
      })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (!d.ok) { toast(d.erreur || "L'assistant n'a pas pu répondre.", true); return; }
          champAvis.value = d.texte;
          toast('Orthographe corrigée — relisez avant d\'enregistrer.');
        })
        .catch(function () { toast('Connexion impossible. Réessayez.', true); })
        .finally(function () {
          boutonAvis.disabled = false;
          boutonAvis.textContent = texteOriginal;
        });
    });
  }

  // --- Téléversement d'image (couverture d'article, photo de section) -----
  // Un seul bouton "couverture" (data-cible/data-apercu pointent vers des id
  // fixes) ; un bouton par section (le champ et l'aperçu sont dans la même
  // carte, retrouvés par data-section-image / data-section-apercu). Utilisée
  // aussi bien au chargement que sur une section ajoutée dynamiquement.
  function activerTeleversement(bouton) {
    var entree = bouton.querySelector('input[type="file"]');
    if (!entree || entree.dataset.televersementActif) return;
    entree.dataset.televersementActif = '1';

    entree.addEventListener('change', function () {
      var fichier = entree.files[0];
      if (!fichier) return;
      var jeton = document.querySelector('input[name="csrf"]');
      var libelle = bouton.firstChild;
      var texteOriginal = libelle ? libelle.textContent : '';
      if (libelle) libelle.textContent = 'Envoi…';
      entree.disabled = true;

      var donnees = new FormData();
      donnees.append('fichier', fichier);
      donnees.append('csrf', jeton ? jeton.value : '');

      fetch('/admin/articles/televerser', {
        method: 'POST', headers: { Accept: 'application/json' },
        credentials: 'same-origin', body: donnees
      })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (!d.ok) { toast(d.erreur || "Échec de l'envoi.", true); return; }

          var idCible = bouton.dataset.cible;
          if (idCible) {
            var champ = document.getElementById(idCible);
            if (champ) champ.value = d.url;
            var apercu = bouton.dataset.apercu ? document.getElementById(bouton.dataset.apercu) : null;
            if (apercu) { apercu.src = d.url; apercu.style.display = 'block'; }
          } else {
            var carte = bouton.closest('[data-section]');
            if (carte) {
              var champUrl = carte.querySelector('[data-section-image]');
              var apercuImg = carte.querySelector('[data-section-apercu]');
              if (champUrl) champUrl.value = d.url;
              if (apercuImg) { apercuImg.src = d.url; apercuImg.style.display = 'block'; }
            }
          }
          toast('Photo envoyée.');
        })
        .catch(function () { toast('Connexion impossible. Réessayez.', true); })
        .finally(function () {
          if (libelle) libelle.textContent = texteOriginal;
          entree.disabled = false;
          entree.value = '';
        });
    });
  }
  document.querySelectorAll('[data-televerser-image]').forEach(activerTeleversement);

  // --- Copier le prompt image d'une section --------------------------------
  // Délégué sur le document : les sections ajoutées après coup (assistant ou
  // bouton "+ Ajouter une section") doivent pouvoir copier aussi.
  document.addEventListener('click', function (ev) {
    var bouton = ev.target.closest('[data-copier-prompt]');
    if (!bouton) return;
    var carte = bouton.closest('[data-section]');
    var champ = carte ? carte.querySelector('[data-section-prompt-image]') : null;
    if (!champ || !champ.value) return;
    var texteOriginal = bouton.textContent;
    var confirmer = function () {
      bouton.textContent = 'Copié !';
      setTimeout(function () { bouton.textContent = texteOriginal; }, 1500);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(champ.value).then(confirmer, function () {
        champ.select();
        document.execCommand('copy');
        confirmer();
      });
    } else {
      champ.select();
      document.execCommand('copy');
      confirmer();
    }
  });

  // --- Sections d'article : ajout / suppression dynamique ------------------
  // Le gabarit <template> contient "__INDEX__" à la place d'un vrai index :
  // remplacé par un compteur qui ne décroît jamais, même après suppression,
  // pour ne jamais réutiliser un index déjà envoyé.
  var listeSections = document.getElementById('sections-liste');
  var modeleSection = document.getElementById('modele-section');
  var boutonAjouterSection = document.getElementById('ajouter-section');

  function activerLigneSection(racine) {
    racine.querySelectorAll('[data-televerser-image]').forEach(activerTeleversement);
    racine.querySelectorAll('[data-supprimer-section]').forEach(function (bouton) {
      bouton.addEventListener('click', function () {
        var carte = bouton.closest('[data-section]');
        if (carte) carte.remove();
      });
    });
  }

  var compteurSection = 0;
  // Exposée hors du bloc "if" ci-dessous pour que l'assistant (plus loin)
  // puisse ajouter des sections même si le bouton "+" n'a pas encore été
  // cliqué une seule fois — la logique d'ajout est la même dans les deux cas.
  function ajouterSectionVide() {
    if (!listeSections || !modeleSection) return null;
    var html = modeleSection.innerHTML.split('__INDEX__').join(String(compteurSection));
    compteurSection++;
    var enveloppe = document.createElement('div');
    enveloppe.innerHTML = html.trim();
    var carte = enveloppe.firstElementChild;
    if (!carte) return null;
    listeSections.appendChild(carte);
    activerLigneSection(carte);
    return carte;
  }

  if (listeSections && modeleSection && boutonAjouterSection) {
    activerLigneSection(listeSections);
    compteurSection = listeSections.querySelectorAll('[data-section]').length;

    boutonAjouterSection.addEventListener('click', function () {
      ajouterSectionVide();
    });
  }

  // --- Filtrer / rechercher dans la liste des articles ---------------------
  var champRecherche = document.getElementById('filtre-articles-recherche');
  var champEtat = document.getElementById('filtre-articles-etat');
  if (champRecherche && champEtat) {
    var appliquerFiltre = function () {
      var terme = champRecherche.value.trim().toLowerCase();
      var etatVoulu = champEtat.value;
      var visibles = 0;
      document.querySelectorAll('tr[data-ligne][data-recherche]').forEach(function (ligne) {
        var correspondTexte = !terme || ligne.dataset.recherche.indexOf(terme) !== -1;
        var correspondEtat = !etatVoulu || ligne.dataset.etatLigne === etatVoulu;
        var visible = correspondTexte && correspondEtat;
        ligne.style.display = visible ? '' : 'none';
        if (visible) visibles++;
      });
      var messageVide = document.getElementById('filtre-articles-vide');
      if (messageVide) messageVide.style.display = visibles === 0 ? '' : 'none';
    };
    champRecherche.addEventListener('input', appliquerFiltre);
    champEtat.addEventListener('change', appliquerFiltre);
  }

  // --- Brouillon automatique (localStorage) ---------------------------------
  // Filet de sécurité : si la page se recharge par erreur, si la session
  // expire ou si une erreur quelconque survient AVANT que "Enregistrer" soit
  // cliqué, le travail de l'assistant ou de la saisie manuelle n'est pas
  // perdu — chaque frappe est copiée en local, et une restauration est
  // proposée si un brouillon existe déjà à l'arrivée sur la page.
  var formArticle = document.querySelector('form[action="/admin/articles/enregistrer"]');
  if (formArticle) {
    var champIdArticle = formArticle.querySelector('input[name="id"]');
    var cleBrouillon = 'ea_admin_article_brouillon_' + (champIdArticle ? champIdArticle.value : '0');

    var lireBrouillonForm = function () {
      var sections = [];
      formArticle.querySelectorAll('[data-section]').forEach(function (carte) {
        sections.push({
          heading: (carte.querySelector('input[name*="[heading]"]') || {}).value || '',
          body: (carte.querySelector('textarea[name*="[body]"]') || {}).value || '',
          image: (carte.querySelector('[data-section-image]') || {}).value || '',
          video: (carte.querySelector('[data-section-video]') || {}).value || '',
          prompt: (carte.querySelector('[data-section-prompt-image]') || {}).value || ''
        });
      });
      return {
        titre: (document.getElementById('titre') || {}).value || '',
        categorie: (document.getElementById('categorie') || {}).value || '',
        extrait: (document.getElementById('extrait') || {}).value || '',
        image: (document.getElementById('image') || {}).value || '',
        contenu: (document.getElementById('contenu') || {}).value || '',
        publie: (document.getElementById('publie') || {}).value || '1',
        sections: sections,
        enregistre_le: Date.now()
      };
    };

    var brouillonEstVide = function (b) {
      return !b.titre && !b.extrait && !b.contenu && !b.image &&
        (!b.sections || !b.sections.length || b.sections.every(function (s) {
          return !s.heading && !s.body && !s.image && !s.video;
        }));
    };

    var restaurerBrouillon = function (b) {
      if (document.getElementById('titre') && b.titre) document.getElementById('titre').value = b.titre;
      if (document.getElementById('categorie') && b.categorie) document.getElementById('categorie').value = b.categorie;
      if (document.getElementById('extrait') && b.extrait) document.getElementById('extrait').value = b.extrait;
      if (document.getElementById('image') && b.image) {
        document.getElementById('image').value = b.image;
        var apercu = document.getElementById('apercu-image');
        if (apercu) { apercu.src = b.image; apercu.style.display = 'block'; }
      }
      if (document.getElementById('contenu') && b.contenu) document.getElementById('contenu').value = b.contenu;
      if (document.getElementById('publie') && b.publie) document.getElementById('publie').value = b.publie;

      var sectionsUtiles = b.sections ? b.sections.filter(function (s) {
        return s.heading || s.body || s.image || s.video;
      }) : [];
      if (sectionsUtiles.length && listeSections) {
        // Le brouillon REMPLACE les sections déjà affichées (venues de la
        // base pour un article existant) au lieu de s'ajouter à côté —
        // sinon une restauration automatique dupliquerait chaque section.
        listeSections.querySelectorAll('[data-section]').forEach(function (carte) { carte.remove(); });
        sectionsUtiles.forEach(function (s) {
          var carte = ajouterSectionVide();
          if (!carte) return;
          var champHeading = carte.querySelector('input[name*="[heading]"]');
          var champBody = carte.querySelector('textarea[name*="[body]"]');
          var champImage = carte.querySelector('[data-section-image]');
          var champVideo = carte.querySelector('[data-section-video]');
          var champPrompt = carte.querySelector('[data-section-prompt-image]');
          var blocPrompt = carte.querySelector('[data-section-bloc-prompt]');
          if (champHeading) champHeading.value = s.heading || '';
          if (champBody) champBody.value = s.body || '';
          if (champImage && s.image) {
            champImage.value = s.image;
            var apercuSection = carte.querySelector('[data-section-apercu]');
            if (apercuSection) { apercuSection.src = s.image; apercuSection.style.display = 'block'; }
          }
          if (champVideo) champVideo.value = s.video || '';
          if (champPrompt && s.prompt) {
            champPrompt.value = s.prompt;
            if (blocPrompt) blocPrompt.hidden = false;
          }
        });
      }
    };

    var minuteurBrouillon = null;
    formArticle.addEventListener('input', function () {
      clearTimeout(minuteurBrouillon);
      minuteurBrouillon = setTimeout(function () {
        var b = lireBrouillonForm();
        try {
          if (brouillonEstVide(b)) localStorage.removeItem(cleBrouillon);
          else localStorage.setItem(cleBrouillon, JSON.stringify(b));
        } catch (e) {}
      }, 800);
    });

    // Au clic sur "Enregistrer" (pas "Prévisualiser") : la vraie sauvegarde
    // va avoir lieu côté serveur, le filet local n'a plus lieu d'être.
    formArticle.addEventListener('submit', function (ev) {
      var soumetteur = ev.submitter;
      if (soumetteur && soumetteur.getAttribute('formaction') &&
          soumetteur.getAttribute('formaction').indexOf('previsualiser') !== -1) return;
      try { localStorage.removeItem(cleBrouillon); } catch (e) {}
    });

    try {
      var brut = localStorage.getItem(cleBrouillon);
      if (brut) {
        var b = JSON.parse(brut);
        if (!brouillonEstVide(b)) {
          // Restauration AUTOMATIQUE, pas sur demande : recharger la page doit
          // redonner exactement l'état laissé, sans clic supplémentaire. Un
          // bouton reste disponible pour repartir d'une page vraiment vide si
          // ce brouillon ne convient pas (ex. après avoir déjà publié ailleurs).
          restaurerBrouillon(b);

          var etatBrouillon = document.getElementById('brouillon-etat');
          if (etatBrouillon) {
            var quand = new Date(b.enregistre_le || Date.now());
            var heure = quand.toLocaleString('fr-FR', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' });

            var texte = document.createElement('span');
            texte.textContent = 'Brouillon non enregistré du ' + heure + ' restauré automatiquement. ';

            var boutonIgnorer = document.createElement('button');
            boutonIgnorer.type = 'button';
            boutonIgnorer.className = 'bouton bouton--contour';
            boutonIgnorer.style.cssText = 'min-height:2rem;padding:.15rem .5rem;font-size:.8125rem';
            boutonIgnorer.textContent = 'Effacer ce brouillon et repartir de zéro';
            boutonIgnorer.addEventListener('click', function () {
              try { localStorage.removeItem(cleBrouillon); } catch (e) {}
              window.location.reload();
            });

            etatBrouillon.appendChild(texte);
            etatBrouillon.appendChild(boutonIgnorer);
          }
        }
      }
    } catch (e) {}
  }
})();
