---
name: ea-design
description: Système de design d'EA-SERVICES — jetons de couleur, typographie, composants, mobile first à 390 px, thème clair/sombre, accessibilité, zéro emoji. À charger avant d'écrire du HTML, du CSS, ou de concevoir une page, une section, un composant ou une mise en page. Déclencheurs — "crée la page", "mise en page", "design", "CSS", "responsive", "mobile", "thème", "couleurs", "composant", "bouton", "carte", "en-tête", "navigation".
---

# Système de design EA-SERVICES

Le design sert la doctrine : faire comprendre un gain en cinq secondes.
Tout ce qui ralentit cette compréhension est un défaut, quelle que soit son
élégance. Lire `ea-philosophie` d'abord.

## Règle absolue : mobile first, vérifié à 390 px

Le marché est ivoirien, donc massivement mobile. L'utilisateur travaille
lui-même depuis un téléphone.

**Un écran correct seulement en 1280 px n'est pas terminé, il est à moitié
fait.** Vérifier à **390 px de large avant** d'annoncer que c'est fini.

- Aucun débordement horizontal : le corps de page ne défile jamais latéralement.
- Tableaux, blocs de code, diagrammes larges : dans un conteneur
  `overflow-x: auto` qui défile **seul**.
- **Le survol seul est inutilisable au tactile.** Toute action masquée derrière
  un `:hover` doit être visible en permanence sur mobile :
  `display: flex` par défaut, masquée seulement à partir de `md`.
- Les panneaux flottants s'ouvrent dans l'espace disponible — un panneau rogné
  par son conteneur devient visible mais inatteignable.
- Cibles tactiles : **44 × 44 px minimum**.

## Jetons de couleur

**Refonte du 2026-08-06** : le bleu générique a été remplacé par le marine et
l'or **du logo**, sur base claire. Le logo cessait d'être un corps étranger, et
une base claire se lit mieux en plein soleil — usage mobile réel du marché.

La source de vérité est `public/css/ea.css`. Ne pas la dupliquer : la lire.

```css
:root {
  /* Marque, relevée sur le logo */
  --marine-900: #0d1b38;  --marine-800: #14274e;  --marine-700: #1c3566;
  --marine-600: #274a8a;  --marine-100: #e8eef7;  --marine-050: #f4f7fc;
  --or-600: #a8790f;      /* or LISIBLE en texte sur fond clair (4,6:1) */
  --or-500: #d8a22a;      /* or du logo — aplats, bordures, boutons */
  --or-400: #e8be5f;      /* or du thème sombre */

  /* Surfaces — thème clair par défaut, sombre via [data-theme="sombre"] */
  --fond: #ffffff;  --fond-alt: #f4f7fc;  --surface: #ffffff;
  --bordure: #dde5f0;  --texte: #101a2f;  --texte-doux: #4a5875;
}
```

**L'or ne s'écrit jamais en texte sur fond clair.** `--or-500` sur blanc plafonne
à 2:1. Pour du texte, `--or-600`. Pour un bouton, or en fond avec du marine
dessus (4,8:1).

**La couleur porte du sens, elle ne décore pas.** Un gain garde sa teinte
partout, en clair comme en sombre (`--gain-*` et `--gain-*-fond`) :

| `--perte` | `--gain-visi` | `--gain-conv` | `--gain-temps` | `--gain-ca` | `--gain-seren` |
|---|---|---|---|---|---|
| la perte | visibilité | conversion | temps | chiffre d'affaires | sérénité |

### Piège de spécificité vérifié — coûte deux fois

`:root[data-theme="sombre"] a` (0,1,1) **l'emporte** sur `.bouton--or` (0,1,0).
Sans exclusion, le texte des boutons repasse en or sur fond or : illisible.
Même chose pour `.pied a` et `a.saut-contenu`. La règle :

```css
a:not(.bouton)                        { color: var(--marine-600); }
:root[data-theme="sombre"] a:not(.bouton) { color: var(--or-400); }
.pied a:not(.bouton)                  { color: rgba(255,255,255,.78); }
```

Ces trois cas ont réellement été introduits puis corrigés le 2026-08-06,
détectés en **mesurant** le contraste dans un navigateur, pas en relisant le CSS.

## Thème clair et sombre

Le sombre est le défaut. Le clair doit exister et être **réellement testé**,
pas bricolé.

- Bascule via `data-theme="light"` sur `<html>`, persistée en `localStorage`.
- Le script de thème doit s'exécuter **avant le rendu** (dans le `<head>`),
  sinon la page clignote en sombre puis passe en clair.
- **Jamais de couleur de texte codée en dur** (`color: #fff`, classe
  `text-white`). Toujours une variable — sinon le texte devient invisible dans
  l'autre thème. C'est le bug le plus fréquent sur ce genre de bascule.

## Typographie

- Famille : **Inter**, 300 à 900, avec `display=swap`.
- Corps : `1.05rem`, interligne `1.8` — on lit sur mobile, souvent au soleil.
- Titres : `h1` 2 à 2,5 rem ; `h2` 1,5 rem ; `h3` 1,25 rem.
- Un seul `h1` par page, et c'est la promesse principale.
- Largeur de lecture : `max-width: 1200px`, texte courant autour de 70 caractères.

## Zéro emoji

**Aucun emoji sur le site public** — règle actée et appliquée dans tout le dépôt.

À la place : icônes SVG inline (le sprite `assets/icons.svg` existe déjà), ou
symboles typographiques (`→`, `·`, `—`). Un emoji casse le rendu selon la
plateforme et affaiblit le sérieux du positionnement.

## Composants — le motif dominant

Le site repose sur des **cartes de bénéfice**, structure toujours identique :

```
┌────────────────────────────────┐
│ ▎ Titre du gain                │  ← barre latérale colorée = le gain
│                                │
│ Le problème, avec son chiffre  │
│ en gras.                       │
│                                │
│ Impact : +30 % de conversion   │  ← toujours présent, toujours en dernier
└────────────────────────────────┘
```

- Bordure gauche de 4 px, couleur du gain concerné.
- Fond : la couleur du gain à 10 % d'opacité.
- La ligne `Impact :` en gras, texte atténué — c'est la promesse chiffrée.
- Grille : `repeat(auto-fit, minmax(250px, 1fr))` — une colonne sur mobile,
  sans media query.

## Accessibilité — non négociable

- Contraste **4,5:1 minimum** pour le texte, vérifié dans les **deux** thèmes.
- La couleur ne porte jamais l'information seule : un gain se lit aussi dans le
  texte, pas uniquement dans sa teinte.
- Tout élément interactif est atteignable au clavier, avec un focus visible.
- Images : `alt` décrivant le contenu réel. Décoratives : `alt=""`.
- `prefers-reduced-motion` respecté : pas d'animation imposée.

## Performance — ce qui a déjà été gagné, à ne pas perdre

- CSS critique préchargé, polices en `preconnect` + `display=swap`.
- Scripts en `defer`, jamais bloquants.
- Images `loading="lazy"` sauf celle visible au premier écran.
- Cache HTTP : `public, max-age=3600, s-maxage=86400` + `ETag`.
- **Ne pas activer la compression gzip côté PHP** : Apache s'en charge, et le
  doublon produit une « erreur d'encodage de contenu » dans le navigateur.
  Ce bug a déjà été rencontré.

Cible : page d'accueil sous 100 ms, réponse actuelle mesurée à ~60 ms.
