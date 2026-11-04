---
name: ea-seo
description: Référencement d'ea-services.net — préserver les URL déjà indexées (4106 visites réelles), canonical, sitemap, redirections 301 lors de la refonte. À charger avant de changer une URL, une structure de navigation, un slug, ou de mettre en ligne une nouvelle page. Déclencheurs — "change l'URL", "renomme la page", "nouvelle page", "slug", "sitemap", "robots", "canonical", "redirection", "indexation", "Google".
---

# SEO EA-SERVICES

## Le fait qui commande tout

**Le site a 4106 visites enregistrées.** Ce n'est pas un prototype : du trafic
réel arrive sur des URL réelles, déjà connues de Google.

**Toute URL existante doit être conservée à l'identique, ou redirigée en 301.**
Une URL cassée lors d'une refonte, c'est de l'indexation acquise perdue — et
elle met des mois à revenir.

## URL à préserver

Structure actuelle, à conserver telle quelle :

```
/                        accueil
/pages/services
/pages/produits
/pages/blog
/pages/a-propos
/pages/contact
/article/{slug}          articles publiés (voir la table articles)
/pages/sonnera           application Android (2026-11-04)
/pages/{expertise}       9 pages d'expertise, une par requête (2026-11-04) :
                         la liste fait foi dans config/expertises.php
```

La liste exhaustive des slugs d'articles est en fin de
`/opt/ea-services-heritage/PHILOSOPHIE-ET-CONTENU.md`.

Si une URL doit vraiment changer : **redirection 301 permanente**, jamais 302,
jamais de suppression sèche. Et le dire à l'utilisateur avant de le faire.

## Pièges déjà rencontrés sur ce domaine

Ces erreurs ont réellement coûté de l'indexation ici. Ne pas les refaire.

- **Canonical contradictoire.** Le sitemap annonçait `/pages/services.html`
  pendant que la page déclarait `/pages/services` en canonical. Les deux
  répondaient 200 avec un contenu identique : face à deux signaux opposés,
  Google n'en indexe aucune. **Une page, une adresse, un signal.**
- **www et sans-www servant le même contenu en 200.** Deux URL pour une page =
  contenu dupliqué. Résolu par une redirection 301 de `www` vers le domaine nu.
  Cette règle est dans le VirtualHost — ne pas la retirer.
- **Sitemap figé.** Un `sitemap.xml` écrit une fois à la main n'inclut jamais
  les pages ajoutées ensuite. Le générer **dynamiquement** depuis la base.
- **Sitemap trop lent.** Un sitemap qui met plus de 6 secondes à répondre est
  récupéré tronqué par Google. Le garder rapide.
- **Mauvais domaine dans la canonical.** Vérifier que canonical et sitemap
  pointent bien vers `https://ea-services.net`, jamais vers un domaine interne.

## À produire pour chaque page

```html
<link rel="canonical" href="https://ea-services.net/CHEMIN-EXACT">
<meta name="robots" content="index, follow, max-image-preview:large">
<title>Promesse — EA-SERVICES</title>
<meta name="description" content="150-160 caractères, un bénéfice concret">
<meta property="og:title" ...>
<meta property="og:description" ...>
<meta property="og:image" content="https://ea-services.net/assets/logo-ea-services.jpeg">
```

Le partage WhatsApp est un canal réel sur ce marché : les balises `og:` ne sont
pas optionnelles.

## Sitemap et robots

- `sitemap.xml` **généré depuis la base** — pages publiées + articles publiés.
- Chaque entrée porte sa `lastmod` réelle, pas la date du jour.
- Accueil en priorité `1.0`, le reste `0.8`, articles `0.7`.
- `robots.txt` autorise tout et déclare le sitemap :
  `Sitemap: https://ea-services.net/sitemap.xml`

## Ce qui manque encore — à ne pas oublier

Un audit antérieur l'a établi : **aucun site généré n'était réellement indexé**,
faute d'inscription à la Search Console. Un sitemap correct ne suffit pas — il
faut déclarer le domaine à Google Search Console et y soumettre le sitemap.

C'est une action manuelle de l'utilisateur, à lui rappeler lors de la mise en
ligne de la refonte.

## Contenu et référencement

Le meilleur levier reste le fond : les articles partent de **vraies requêtes
que les gens tapent**, pas de sujets qui arrangent la marque. Voir `ea-contenu`.
