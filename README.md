# EA-SERVICES — ea-services.net

Site vitrine d'EA-SERVICES (Abidjan). En **production** : ne pas le traiter comme
un prototype. Doctrine : *on ne vend pas des fonctionnalités, on vend des
résultats mesurables* ; chaque page se termine sur le même appel à l'action —
diagnostic gratuit, 30 minutes, sans engagement.

Les règles de travail détaillées (doctrine, design, SEO, infrastructure) sont
dans [CLAUDE.md](CLAUDE.md). Ce fichier est le point d'entrée pour démarrer.

## Pile technique

- PHP 8.2 (celui de LAMPP), **aucune dépendance**, aucun gestionnaire de paquets
- Chargement automatique maison : `src/bootstrap.php`, espace de noms `EA\`
- SQLite : `data/site.sqlite` (non versionné)
- CSS/JS maison : `public/css/ea.css`, `public/js/ea.js`

## Démarrage rapide

```bash
# Serveur local, sans toucher à la production
/opt/lampp/bin/php -S 127.0.0.1:8899 -t public public/index.php

# Créer / mettre à jour la base (rejouable, ne détruit rien)
/opt/lampp/bin/php src/migration.php

# Vérifier la syntaxe d'un fichier
/opt/lampp/bin/php -l src/Controllers/PageController.php
```

Avant de dire qu'une page est terminée : la vérifier à **390 px** (mobile first).

### Secrets

`config/secrets.php` (clé d'API de l'assistant, non versionné) doit exister en
local pour que l'assistant de discussion et les aides à la rédaction de
l'administration fonctionnent. Ne jamais le committer ni exposer son contenu
côté client.

## Structure

```
config/site.php      Coordonnées, gains, navigation — SOURCE UNIQUE
config/secrets.php   Clés d'API (hors dépôt)
src/Core/            Router, Vue, Database, Auth, Csrf, Session, Texte, Visites…
src/Controllers/     Page, Article, Contact, Diagnostic, Chat, Seo, Auth, Admin
src/migration.php    Migration de la base
views/               layouts/, partials/, pages/, blog/, admin/
public/              index.php (point d'entrée), css/, js/, assets/, uploads/
data/                Base SQLite
storage/             Journaux, sessions, cache
```

## Routes principales

Déclarées dans [public/index.php](public/index.php).

| Zone | Routes |
|---|---|
| Pages | `/`, `/pages/{slug}` (services, prestations, produits, réalisations, à propos, blog, contact) |
| Blog | `/article/{slug}`, commentaires modérés |
| Diagnostic | `/diagnostic` (formulaire et résultat) |
| Assistant | `/chat/message`, `/chat/historique` |
| SEO | `/sitemap.xml`, `/robots.txt`, redirections 301 des anciennes URL `.html` |
| Administration | `/admin` : demandes, articles, commentaires, témoignages, audience |

## Règles à ne pas oublier

- **Aucun emoji**, aucun jargon visible (API, CRM, dashboard…).
- **Ne jamais inventer** un avis, un chiffre ou une photo attribuée à une
  entreprise réelle ; sinon, emplacement réservé et le signaler.
- **Ne jamais casser une URL indexée** sans redirection 301. Le slug d'un
  article ne change plus après publication.
- Un numéro de téléphone ou une promesse chiffrée ne s'écrit que dans
  `config/site.php`.
- Ne pas activer gzip côté PHP : Apache s'en charge.

## Exploitation

```
Navigateur → Apache LAMPP :443 → /opt/ea-services/public/index.php
```

- DocumentRoot : `/opt/ea-services/public`, routage par `FallbackResource /index.php`
- Propriétaire `daemon:daemon` ; `data/` et `storage/` en 775
- Config Apache : `/opt/lampp/etc/extra/httpd-ssl.conf` (VirtualHost `ea-services.net`)
- Ce VirtualHost sert aussi des applications sous `/opt/lampp/htdocs`
  (`/emploi.ea/`, `/dashboard/`, `/cvmakeria/`, `/sites/`) via des `Alias` :
  toute nouvelle application doit y être ajoutée, sinon 404

```bash
sudo /opt/lampp/bin/apachectl configtest      # vérifier avant de redémarrer
sudo /opt/lampp/lampp restart apache
tail -f /opt/lampp/logs/ea-services-ssl-error_log
tail -f storage/php-error.log                 # exceptions PHP attrapées
```

Le certificat Let's Encrypt est en renouvellement **manuel** : il ne se
renouvelle pas tout seul.

## Reste à faire côté dirigeant

- Déclarer le domaine à la Search Console et soumettre `https://ea-services.net/sitemap.xml`
- Confirmer (ou retirer) les trois cas clients chiffrés du blog
- Renouveler le certificat avant son expiration
