# EA-SERVICES — site public ea-services.net

Site vitrine d'EA-SERVICES. **Ce n'est pas un prototype** : le domaine est en
production et connu de Google (Googlebot passe tous les jours).

**Audience — ne pas se fier à `bot = 0`** (constaté le 2026-11-04) : des robots
qui imitent un vrai navigateur passent ce filtre (≈ 20 000 lignes « humaines »
pour 1 282 navigateurs différents, aucune visite réellement venue de Google).
Le chiffre fiable est `humain = 1` : posé par `ea-v2.js` seulement après un
défilement, un toucher ou un clic (`POST /__h`). L'IP n'est stockée qu'avec
consentement aux cookies — ne pas compter les visiteurs par IP.

**Refonte complète le 2026-08-06** : code entièrement réécrit, contenu réécrit,
identité alignée sur le logo (marine + or), couche SEO ajoutée. Les 12 URL
indexées sont préservées à l'identique et les anciennes adresses en `.html`
sont redirigées en 301.

## À lire avant de commencer

1. **`/opt/ea-services-heritage/PHILOSOPHIE-ET-CONTENU.md`** — la philosophie,
   le contenu validé des 6 pages, les 6 articles, les témoignages réels, et la
   liste des URL à conserver. Le code est refait de zéro ; **le fond ne l'est
   pas**.
2. La skill **`ea-philosophie`** — la doctrine. Elle tranche en cas de doute.

## La doctrine en une phrase

**On ne vend pas des fonctionnalités, on vend des résultats mesurables.**

Chaque page part d'une perte que le client subit (temps, clients, visibilité,
argent, sérénité), puis montre le gain chiffré. Jamais l'outil technique.

Toute page finit sur le même appel à l'action : *diagnostic gratuit, 30 minutes,
sans engagement*.

## Skills du projet

| Skill | Quand |
|---|---|
| `ea-philosophie` | Avant tout contenu, toute offre, toute décision de fond |
| `ea-produit` | Dès qu'une fonctionnalité ou une page est proposée |
| `ea-design` | Avant d'écrire du HTML/CSS ou de concevoir une mise en page |
| `ea-contenu` | Avant de rédiger un texte destiné au visiteur |
| `ea-seo` | Avant de toucher à une URL, un slug, la navigation |

## Règles absolues

- **Mobile first** — vérifier à **390 px** avant de dire « terminé ». Le marché
  est ivoirien, donc massivement mobile.
- **Aucun emoji** sur le site public. Icônes SVG ou symboles typographiques.
- **Aucun jargon visible** : ni API, ni backend, ni CRM, ni dashboard.
- **Ne jamais inventer** un avis, un témoignage, un chiffre ou une photo
  attribuée à une entreprise réelle. En cas de preuve manquante : emplacement
  réservé honnête, et le signaler.
- **Ne jamais casser une URL indexée** sans redirection 301.

## Organisation du code

Aucune dépendance, aucun gestionnaire de paquets. Chargement automatique
maison (`src/bootstrap.php`), espace de noms `EA\`.

```
config/site.php     Coordonnées, cinq gains, navigation — SOURCE UNIQUE.
                    Un numéro ou une promesse chiffrée ne se recopie jamais
                    ailleurs.
src/Core/           Router, Controleur, Vue, Database, Auth, Csrf, Session,
                    Texte, Visites, Config
src/Controllers/    Page, Article, Contact, Seo, Auth, Admin
src/migration.php   Migration de base, rejouable sans dommage
views/              layouts/, partials/, pages/, blog/, admin/
public/             index.php, css/ea.css, js/ea.js, assets/
```

- **Les 6 pages sont des gabarits** (`views/pages/`), plus des blocs de HTML
  en base : une page d'accueil a une structure propre, la stocker dans une
  colonne empêchait de la faire évoluer.
- **Pages d'expertise** (`/pages/creation-site-web-abidjan`, `/pages/chatbot-whatsapp-entreprise`…) :
  une page par besoin que les gens tapent dans Google. Contenu dans
  `config/expertises.php`, gabarit unique `views/pages/expertise.php`, servies
  par `PageController::afficher()`. Ajouter une entrée au fichier suffit :
  sitemap, pied de page, accueil et données structurées (Service + FAQPage)
  suivent tout seuls. Le titre reprend la requête ; le corps garde la doctrine.
  Raison : aucun titre visible des pages historiques ne contenait un mot
  recherché — elles convainquent, elles ne font pas venir.
- **Les articles restent en base** : ils sont rédigés en administration.
  Le contenu est du texte brut, mis en forme par `Texte::enHtml()` qui
  **échappe avant de baliser**.
- **Le slug d'un article ne change jamais** après publication : c'est
  l'adresse connue de Google.

## Infrastructure

Le site est **autonome depuis le 2026-08-06** : plus aucune dépendance à SFB.

```
Navigateur → Apache LAMPP :443 → /opt/ea-services/public/index.php
                                  (module PHP de LAMPP, PHP 8.2)
```

Exactement le même schéma qu'`emploi.ea`. Deux étapes, ~60 ms de réponse.

- **Racine du site** : `/opt/ea-services/public` (DocumentRoot)
- **Routage** : `FallbackResource /index.php` — pas de RewriteRule (les
  anciennes `[P]` provoquaient des boucles `AH00124`)
- **Base** : SQLite, `/opt/ea-services/data/site.sqlite`
- **Propriétaire** : `daemon:daemon` (Apache LAMPP tourne en `daemon`, pas
  `www-data`). `data/` et `storage/` en 775.
- **Config Apache** : `/opt/lampp/etc/extra/httpd-ssl.conf`, VirtualHost
  `ServerName ea-services.net`

### Pièges d'infrastructure vérifiés

- Le VirtualHost `ea-services.net` sert **aussi** de porte d'entrée à de vraies
  applications sous `/opt/lampp/htdocs` : `/emploi.ea/` (produit EMPLOI.EA,
  client réel), `/dashboard/`, `/cvmakeria/`, `/sites/`. Elles sont rattachées
  par des `Alias` explicites. **Toute nouvelle app sous htdocs devra y être
  ajoutée** — sinon elle tombe en 404.
- **Ne pas activer gzip côté PHP** : Apache s'en charge. Le doublon provoque une
  « erreur d'encodage de contenu » dans le navigateur.
- Certificat Let's Encrypt en renouvellement **`manual`** : il ne se renouvelle
  pas tout seul. ACME reste servi par le VirtualHost `:80`.

## Commandes

```bash
# Redémarrer Apache
sudo /opt/lampp/lampp restart apache

# Vérifier la config avant de redémarrer
sudo /opt/lampp/bin/apachectl configtest

# Lint PHP (le PHP de LAMPP est en 8.2, pas 8.3)
/opt/lampp/bin/php -l fichier.php

# Journal d'erreurs du site
tail -f /opt/lampp/logs/ea-services-ssl-error_log

# Journal applicatif (exceptions PHP attrapées)
tail -f /opt/ea-services/storage/php-error.log

# Migration de base (rejouable, ne détruit rien)
/opt/lampp/bin/php /opt/ea-services/src/migration.php

# Serveur local pour tester sans toucher à la production
/opt/lampp/bin/php -S 127.0.0.1:8899 -t public public/index.php
```

## Ce qui reste à faire par le dirigeant

- **Déclarer le domaine à la Search Console de Google** et y soumettre
  `https://ea-services.net/sitemap.xml`. Sans cette étape, le sitemap ne sert
  à rien : un audit antérieur avait établi qu'aucun site généré n'était
  réellement indexé, faute d'inscription.
- **Confirmer les trois cas clients chiffrés** de `/pages/blog` (cabinet de
  recrutement, agent commercial, entreprise de services). Ils proviennent du
  contenu archivé ; s'ils ne sont pas vérifiables, ils doivent être retirés.
- Le certificat Let's Encrypt est en renouvellement **manuel** (expire le 2027-01-14).
- **Créer la fiche Google Business Profile** d'EA-SERVICES (Marcory Biétry) :
  levier le plus rapide pour les recherches locales « … à Abidjan ».
- **Valider les engagements** écrits dans `config/expertises.php` (rubriques
  « Pourquoi nous » et FAQ) : ils décrivent des pratiques, pas des chiffres,
  mais le dirigeant doit pouvoir les tenir.
- **Sonnera** : fournir le lien de téléchargement et de vraies captures.
