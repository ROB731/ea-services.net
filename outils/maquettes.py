#!/usr/bin/env python3
"""
Génère les maquettes SVG des pages d'expertise (public/assets/expertises/).

Pourquoi des maquettes plutôt que des photos de banque d'images : elles montrent
au visiteur CE QU'IL OBTIENT (sa conversation WhatsApp qui répond seule, son site
sur un téléphone, son alarme d'équipe), dans les couleurs du site. Ce sont des
illustrations : aucune ne prétend être la capture d'un client réel — les noms
affichés restent génériques (« Votre entreprise »).

Relancer après modification :  python3 outils/maquettes.py
Aucune dépendance. Palette = jetons de public/css/ea-v2.css.
"""
from pathlib import Path
from html import escape

SORTIE = Path(__file__).resolve().parent.parent / 'public' / 'assets' / 'expertises'

ENCRE, ENCRE_FOND, ENCRE_DOUCE = '#112849', '#091a32', '#294365'
IVOIRE, PAPIER, SABLE = '#f7f4ec', '#fffdf8', '#ebe5d8'
SAFRAN, SAFRAN_ENCRE = '#f2b62b', '#7d5605'
VERT, VERT_CLAIR = '#128c4a', '#dcf8c6'
GRIS, GRIS_CLAIR, TRAIT = '#5a6577', '#e9edf3', '#d6dbe4'
ROUGE = '#c0392b'
POLICE = "DM Sans, Segoe UI, Roboto, Arial, sans-serif"
W, H = 640, 520


def t(x, y, texte, taille=14, couleur=ENCRE, poids=400, ancre='start', opacite=1):
    return (f'<text x="{x}" y="{y}" font-family="{POLICE}" font-size="{taille}" '
            f'font-weight="{poids}" fill="{couleur}" text-anchor="{ancre}" '
            f'opacity="{opacite}">{escape(texte)}</text>')


def r(x, y, w, h, couleur, rx=0, extra=''):
    return f'<rect x="{x}" y="{y}" width="{w}" height="{h}" rx="{rx}" fill="{couleur}" {extra}/>'


def ligne(x, y, w, couleur=GRIS_CLAIR, h=8):
    return r(x, y, w, h, couleur, h / 2)


def coche(cx, cy, couleur=VERT, rayon=9):
    return (f'<circle cx="{cx}" cy="{cy}" r="{rayon}" fill="{couleur}"/>'
            f'<path d="M{cx-4} {cy} l3 3 l5 -6" stroke="#fff" stroke-width="2.2" '
            f'fill="none" stroke-linecap="round" stroke-linejoin="round"/>')


def fond(titre_alt):
    """Fond commun : marine profond, halo safran discret, grille de points."""
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" role="img" aria-label="{escape(titre_alt)}">
<defs>
  <radialGradient id="halo" cx="70%" cy="20%" r="80%">
    <stop offset="0%" stop-color="{ENCRE_DOUCE}"/><stop offset="100%" stop-color="{ENCRE_FOND}"/>
  </radialGradient>
  <pattern id="points" width="22" height="22" patternUnits="userSpaceOnUse">
    <circle cx="2" cy="2" r="1.2" fill="#ffffff" opacity=".07"/>
  </pattern>
  <filter id="ombre" x="-20%" y="-20%" width="140%" height="150%">
    <feDropShadow dx="0" dy="14" stdDeviation="16" flood-color="#000" flood-opacity=".38"/>
  </filter>
  <filter id="ombre-douce" x="-20%" y="-20%" width="140%" height="160%">
    <feDropShadow dx="0" dy="6" stdDeviation="8" flood-color="#000" flood-opacity=".28"/>
  </filter>
</defs>
{r(0, 0, W, H, 'url(#halo)')}
{r(0, 0, W, H, 'url(#points)')}
<circle cx="560" cy="70" r="150" fill="{SAFRAN}" opacity=".08"/>
<circle cx="560" cy="70" r="90" fill="none" stroke="{SAFRAN}" stroke-opacity=".25"/>
'''


def telephone(x, y, w=230, h=440, contenu='', ecran=PAPIER):
    """Cadre de téléphone ; `contenu` est dessiné dans le repère de l'écran (0,0)."""
    bord = 10
    ew, eh = w - 2 * bord, h - 2 * bord
    return f'''<g transform="translate({x},{y})" filter="url(#ombre)">
  {r(0, 0, w, h, '#05101f', 34)}
  {r(2, 2, w - 4, h - 4, '#1b2c47', 32)}
  <g transform="translate({bord},{bord})">
    <clipPath id="ecran{x}{y}"><rect width="{ew}" height="{eh}" rx="26"/></clipPath>
    <g clip-path="url(#ecran{x}{y})">
      {r(0, 0, ew, eh, ecran)}
      {contenu}
    </g>
  </g>
  {r(w / 2 - 34, 16, 68, 16, '#05101f', 8)}
</g>'''


def barre_etat(largeur, couleur=ENCRE, heure='09:41'):
    return (t(22, 30, heure, 11, couleur, 700) +
            r(largeur - 56, 21, 18, 9, couleur, 2, 'opacity=".75"') +
            r(largeur - 34, 21, 12, 9, couleur, 2, 'opacity=".75"'))


def navigateur(x, y, w, h, adresse, contenu):
    return f'''<g transform="translate({x},{y})" filter="url(#ombre)">
  {r(0, 0, w, h, PAPIER, 14)}
  {r(0, 0, w, 38, SABLE, 14)}{r(0, 24, w, 14, SABLE)}
  <circle cx="20" cy="19" r="5" fill="{ROUGE}" opacity=".7"/><circle cx="36" cy="19" r="5" fill="{SAFRAN}"/><circle cx="52" cy="19" r="5" fill="{VERT}" opacity=".8"/>
  {r(72, 10, w - 92, 18, PAPIER, 9)}
  <path d="M84 15 v8 h7 v-8 z M85.5 15 v-2.5 a2 2 0 0 1 4 0 V15" fill="none" stroke="{VERT}" stroke-width="1.4"/>
  {t(98, 23, adresse, 10.5, GRIS)}
  <g transform="translate(0,38)">{contenu}</g>
</g>'''


def bulle(x, y, w, lignes, couleur, heure, droite=False, couleur_texte=ENCRE):
    h = 18 + 17 * len(lignes) + 12
    s = r(x, y, w, h, couleur, 12, 'filter="url(#ombre-douce)"' if not droite else '')
    for i, l in enumerate(lignes):
        s += t(x + 12, y + 22 + 17 * i, l, 12.5, couleur_texte)
    s += t(x + w - 10, y + h - 8, heure, 9.5, GRIS, ancre='end')
    if droite:
        s += f'<path d="M{x+w-56} {y+h-12} l3 3 l5 -6 M{x+w-51} {y+h-12} l3 3 l5 -6" stroke="#34b7f1" stroke-width="1.5" fill="none"/>'
    return s, h


def ecrire(nom, contenu):
    SORTIE.mkdir(parents=True, exist_ok=True)
    (SORTIE / f'{nom}.svg').write_text(contenu + '\n</svg>\n', encoding='utf-8')
    print(f'  {nom}.svg  {len(contenu) // 1024} Ko')


# --------------------------------------------------------------- Chatbot WhatsApp
def chatbot():
    ew = 210
    c = r(0, 0, ew, 420, '#efe7dd')
    c += r(0, 0, ew, 92, '#075e54') + barre_etat(ew, '#fff')
    c += '<circle cx="34" cy="64" r="15" fill="#fff" opacity=".9"/>' + t(34, 69, 'VE', 11, '#075e54', 700, 'middle')
    c += t(58, 61, 'Votre entreprise', 13, '#fff', 700) + t(58, 77, 'répond en quelques secondes', 9.5, '#fff', 400, opacite=.85)
    y = 108
    b, h = bulle(12, y, 160, ['Bonsoir, vous livrez', 'à Yopougon ce soir ?'], '#fff', '21:47'); c += b; y += h + 10
    b, h = bulle(36, y, 162, ['Bonsoir ! Oui, nous', 'livrons à Yopougon.', 'Que souhaitez-vous', 'commander ?'], VERT_CLAIR, '21:47', True); c += b; y += h + 10
    for i, choix in enumerate(['Voir le catalogue', 'Connaître les prix', 'Parler à un conseiller']):
        c += r(36, y + i * 34, 162, 28, '#fff', 14) + t(117, y + 18 + i * 34, choix, 11.5, '#075e54', 700, 'middle')
    c += r(0, 384, ew, 36, '#f0f0f0') + r(10, 392, 150, 22, '#fff', 11) + t(22, 407, 'Message', 11, GRIS)
    c += '<circle cx="186" cy="403" r="13" fill="#128c4a"/>'
    s = fond("Illustration : un client écrit le soir sur WhatsApp et reçoit une réponse immédiate")
    s += telephone(60, 40, 230, 440, c)
    # carte de résultat à droite
    s += f'<g transform="translate(330,120)" filter="url(#ombre)">{r(0, 0, 270, 150, PAPIER, 16)}'
    s += t(22, 36, 'Délai de réponse', 13, GRIS, 600) + t(22, 78, 'moins de 2 min', 30, ENCRE, 800)
    s += t(22, 106, 'de jour comme de nuit', 12.5, GRIS) + ligne(22, 124, 226, SABLE, 6) + ligne(22, 124, 210, SAFRAN, 6) + '</g>'
    s += f'<g transform="translate(330,296)" filter="url(#ombre)">{r(0, 0, 270, 96, PAPIER, 16)}'
    s += coche(36, 34) + t(56, 39, 'Demande sérieuse', 13, ENCRE, 700) + t(56, 58, 'transmise au conseiller', 12, GRIS)
    s += t(56, 78, 'avec le nom et le besoin', 12, GRIS) + '</g>'
    ecrire('chatbot-whatsapp', s)


# --------------------------------------------------------------- Site web
def site_web():
    s = fond("Illustration : un site d'entreprise affiché sur ordinateur et sur téléphone, trouvé depuis une recherche")
    page = r(0, 0, 400, 262, PAPIER)
    page += r(0, 0, 400, 44, ENCRE) + t(22, 28, 'Votre entreprise', 13, '#fff', 700)
    for i, m in enumerate(['Services', 'Réalisations', 'Contact']):
        page += t(200 + i * 66, 28, m, 10.5, '#fff', 500, opacite=.8)
    page += r(0, 44, 400, 120, '#16325a')
    page += t(22, 84, 'Votre métier,', 20, '#fff', 800) + t(22, 108, 'expliqué en 5 secondes.', 20, SAFRAN, 800)
    page += ligne(22, 124, 200, '#ffffff', 7).replace('fill="#ffffff"', 'fill="#ffffff" opacity=".35"')
    page += r(22, 138, 128, 16, VERT, 8) + t(86, 150, 'Écrire sur WhatsApp', 9.5, '#fff', 700, 'middle')
    for i in range(3):
        x = 22 + i * 124
        page += r(x, 180, 110, 66, IVOIRE, 8) + r(x + 10, 192, 22, 22, SAFRAN, 6) + ligne(x + 10, 222, 80) + ligne(x + 10, 234, 56)
    s += navigateur(40, 90, 400, 300, 'votre-entreprise.ci', page)
    # téléphone
    c = barre_etat(150) + r(0, 40, 150, 34, ENCRE) + t(12, 62, 'Votre entreprise', 10.5, '#fff', 700)
    c += r(0, 74, 150, 110, '#16325a') + t(12, 104, 'Votre métier,', 13, '#fff', 800) + t(12, 122, 'en 5 secondes.', 13, SAFRAN, 800)
    c += r(12, 138, 112, 26, VERT, 13) + t(68, 155, 'WhatsApp', 10.5, '#fff', 700, 'middle')
    for i in range(3):
        c += r(12, 198 + i * 50, 126, 40, IVOIRE, 8) + r(22, 207 + i * 50, 20, 20, SAFRAN, 5) + ligne(50, 210 + i * 50, 70) + ligne(50, 222 + i * 50, 48)
    s += telephone(430, 150, 170, 330, c)
    # barre de recherche
    s += f'<g transform="translate(40,34)" filter="url(#ombre-douce)">{r(0, 0, 330, 40, PAPIER, 20)}'
    s += f'<circle cx="24" cy="20" r="7" fill="none" stroke="{GRIS}" stroke-width="2"/><path d="M29 25 l6 6" stroke="{GRIS}" stroke-width="2" stroke-linecap="round"/>'
    s += t(44, 25, 'réparation climatiseur Cocody', 13.5, ENCRE, 500) + '</g>'
    ecrire('site-web', s)


# --------------------------------------------------------------- Boutique
def boutique():
    s = fond("Illustration : une boutique en ligne sur téléphone, avec commande envoyée sur WhatsApp")
    c = barre_etat(210) + t(16, 64, 'Votre boutique', 15, ENCRE, 800) + t(16, 82, 'Livraison 24 à 48 h · Abidjan', 10, GRIS)
    for i, (cat, cx, cw) in enumerate([('Parfums', 16, 56), ('Sacs', 78, 40), ('Chaussures', 124, 70)]):
        couleur = ENCRE if i == 0 else IVOIRE
        c += r(cx, 94, cw, 22, couleur, 11) + t(cx + cw / 2, 109, cat, 9.5, '#fff' if i == 0 else ENCRE, 600, 'middle')
    produits = [('Parfum 50 ml', '15 000 FCFA', '#e8c9a0'), ('Sac en cuir', '25 000 FCFA', '#b98b63'),
                ('Escarpins', '18 000 FCFA', '#294365'), ('Montre', '30 000 FCFA', '#d9b45a')]
    for i, (nom, prix, teinte) in enumerate(produits):
        x, y = 16 + (i % 2) * 96, 128 + (i // 2) * 128
        c += r(x, y, 86, 118, '#fff', 10, f'stroke="{TRAIT}"') + r(x + 8, y + 8, 70, 58, teinte, 8, 'opacity=".9"')
        c += t(x + 8, y + 82, nom, 10, ENCRE, 600) + t(x + 8, y + 97, prix, 10, SAFRAN_ENCRE, 700)
        c += r(x + 8, y + 103, 70, 9, VERT, 4.5, 'opacity=".18"')
    c += r(16, 386, 180, 30, VERT, 15) + t(106, 405, 'Commander sur WhatsApp', 11, '#fff', 700, 'middle')
    s += telephone(70, 40, 230, 440, c)
    s += f'<g transform="translate(330,110)" filter="url(#ombre)">{r(0, 0, 270, 168, PAPIER, 16)}'
    s += f'<circle cx="34" cy="36" r="16" fill="{VERT}"/>' + t(34, 41, 'W', 13, '#fff', 800, 'middle')
    s += t(60, 32, 'Nouvelle commande', 13, ENCRE, 800) + t(60, 50, 'reçue à 22 h 14', 11.5, GRIS)
    s += ligne(22, 70, 226, SABLE, 1)
    for i, l in enumerate(['1 × Parfum 50 ml', '1 × Sac en cuir', 'Livraison : Cocody']):
        s += t(22, 96 + i * 21, l, 12.5, ENCRE)
    s += '</g>'
    s += f'<g transform="translate(330,304)" filter="url(#ombre)">{r(0, 0, 270, 78, PAPIER, 16)}'
    s += coche(34, 39) + t(56, 35, 'Paiement à la livraison', 13, ENCRE, 700) + t(56, 54, 'ou Mobile Money', 12, GRIS) + '</g>'
    ecrire('boutique-en-ligne', s)


# --------------------------------------------------------------- Application mobile
def application_mobile():
    s = fond("Illustration : une application d'équipe, avec une alarme de tâche et le suivi des réponses")
    a = r(0, 0, 210, 420, ENCRE) + barre_etat(210, '#fff', '07:30')
    a += t(105, 92, 'Lundi', 13, '#fff', 500, 'middle', .7) + t(105, 146, '07:30', 50, '#fff', 800, 'middle')
    for k, rr in enumerate([70, 52, 34]):
        a += f'<circle cx="105" cy="236" r="{rr}" fill="none" stroke="{SAFRAN}" stroke-opacity="{.15 + k * .2}" stroke-width="2"/>'
    a += f'<circle cx="105" cy="236" r="22" fill="{SAFRAN}"/>'
    a += f'<path d="M97 230 a8 8 0 0 1 16 0 v7 l3 4 h-22 l3 -4z" fill="{ENCRE}"/>'
    a += r(16, 302, 178, 52, '#fff', 12, 'opacity=".08"') + t(28, 324, 'Ouvrir la caisse', 13, '#fff', 700) + t(28, 341, 'assignée par la gérante', 10.5, '#fff', 400, opacite=.7)
    a += r(16, 366, 86, 36, VERT, 18) + t(59, 389, "C'est fait", 11.5, '#fff', 700, 'middle')
    a += r(108, 366, 86, 36, '#ffffff', 18, 'opacity=".14"') + t(151, 389, 'Plus tard', 11.5, '#fff', 700, 'middle')
    s += telephone(50, 40, 230, 440, a, ENCRE)
    b = barre_etat(170) + t(14, 62, "Suivi de l'équipe", 13, ENCRE, 800) + t(14, 79, "Aujourd'hui", 10, GRIS)
    taches = [("Ouvrir la caisse", 'Fait', VERT), ('Contrôle du stock', 'Fait', VERT),
              ('Livraison Plateau', 'En retard', ROUGE), ('Nettoyage', 'À 14 h', GRIS)]
    for i, (nom, etat, couleur) in enumerate(taches):
        y = 90 + i * 52
        b += r(10, y, 150, 46, IVOIRE, 10) + t(20, y + 19, nom, 10.5, ENCRE, 700)
        b += r(20, y + 26, 58, 14, couleur, 7, 'opacity=".15"') + t(49, y + 36, etat, 8.5, couleur, 700, 'middle')
    b += r(10, 302, 150, 36, SAFRAN, 10, 'opacity=".22"') + t(20, 318, 'Responsable prévenu', 9.5, SAFRAN_ENCRE, 700) + t(20, 330, 'après 30 min sans réponse', 8.5, SAFRAN_ENCRE)
    s += telephone(320, 110, 190, 370, b)
    s += f'<g transform="translate(470,60)" filter="url(#ombre-douce)">{r(0, 0, 140, 40, PAPIER, 20)}'
    s += f'<circle cx="22" cy="20" r="7" fill="{VERT}"/>' + t(38, 25, 'Android', 13, ENCRE, 700) + '</g>'
    ecrire('application-mobile', s)


# --------------------------------------------------------------- Logiciel sur mesure
def logiciel():
    s = fond("Illustration : un logiciel de gestion sur ordinateur, avec le suivi des commandes au même endroit")
    w, h = 520, 330
    x0, y0 = 60, 60
    s += f'<g transform="translate({x0},{y0})" filter="url(#ombre)">'
    s += r(0, 0, w, h, '#05101f', 16) + r(10, 10, w - 20, h - 20, PAPIER, 8)
    s += r(10, 10, 110, h - 20, ENCRE, 8) + r(110, 10, 10, h - 20, ENCRE)
    s += t(26, 40, 'Votre outil', 12, '#fff', 800)
    for i, m in enumerate(['Commandes', 'Clients', 'Livraisons', 'Rapports']):
        if i == 0:
            s += r(18, 56, 94, 26, '#ffffff', 6, 'opacity=".12"')
        s += t(28, 74 + i * 32, m, 11, '#fff', 600 if i == 0 else 400, opacite=1 if i == 0 else .7)
    s += t(140, 44, 'Commandes du jour', 15, ENCRE, 800)
    for i, (val, lib) in enumerate([('48', 'reçues'), ('41', 'livrées'), ('7', 'en cours')]):
        s += r(140 + i * 118, 58, 108, 56, IVOIRE, 10) + t(152 + i * 118, 86, val, 20, ENCRE, 800) + t(152 + i * 118, 104, lib, 10.5, GRIS)
    s += r(140, 128, 344, 26, SABLE, 6)
    for i, col in enumerate(['N°', 'Client', 'Quartier', 'Statut']):
        s += t(150 + [0, 46, 150, 250][i], 145, col, 10, GRIS, 700)
    lignes = [('1042', 'Client A', 'Cocody', 'Livrée', VERT), ('1043', 'Client B', 'Marcory', 'En route', SAFRAN_ENCRE),
              ('1044', 'Client C', 'Plateau', 'Livrée', VERT), ('1045', 'Client D', 'Yopougon', 'Préparée', ENCRE_DOUCE),
              ('1046', 'Client E', 'Treichville', 'Livrée', VERT)]
    for i, (n, cl, q, st, coul) in enumerate(lignes):
        y = 174 + i * 26
        s += t(150, y, n, 10.5, ENCRE, 600) + t(196, y, cl, 10.5, ENCRE) + t(300, y, q, 10.5, GRIS)
        s += r(396, y - 12, 66, 17, coul, 8.5, 'opacity=".14"') + t(429, y, st, 9.5, coul, 700, 'middle')
    s += '</g>'
    s += r(x0 - 30, y0 + h, w + 60, 14, '#1b2c47', 7) + r(x0 + w / 2 - 50, y0 + h, 100, 6, '#05101f', 3)
    s += f'<g transform="translate(400,410)" filter="url(#ombre-douce)">{r(0, 0, 210, 56, PAPIER, 14)}'
    s += coche(26, 28) + t(44, 24, 'Une seule saisie', 12.5, ENCRE, 700) + t(44, 41, 'au lieu de trois', 11.5, GRIS) + '</g>'
    ecrire('logiciel-sur-mesure', s)


# --------------------------------------------------------------- Automatisation
def automatisation():
    s = fond("Illustration : une suite de relances automatiques, de la demande reçue jusqu'au rappel du commercial")
    etapes = [('Demande reçue', 'Lundi 9 h 02', 'Réponse envoyée aussitôt'),
              ('Relance à 3 jours', 'Jeudi 9 h 00', 'Message personnalisé'),
              ('Relance à 7 jours', 'Lundi 9 h 00', 'Dernier rappel'),
              ('À rappeler', "Aujourd'hui", 'Le prospect a répondu')]
    for i, (titre, quand, detail) in enumerate(etapes):
        y = 54 + i * 106
        if i < len(etapes) - 1:
            s += f'<path d="M118 {y + 66} v40" stroke="{SAFRAN}" stroke-width="3" stroke-dasharray="2 7" stroke-linecap="round"/>'
        fait = i < 3
        s += f'<g transform="translate(70,{y})" filter="url(#ombre-douce)">{r(0, 0, 330, 70, PAPIER, 14)}'
        s += coche(48, 35, VERT if fait else SAFRAN, 14)
        s += t(76, 30, titre, 14, ENCRE, 800) + t(76, 50, detail, 11.5, GRIS)
        s += t(312, 30, quand, 10.5, SAFRAN_ENCRE, 700, 'end') + '</g>'
    s += f'<g transform="translate(430,150)" filter="url(#ombre)">{r(0, 0, 180, 210, ENCRE, 18)}'
    s += t(90, 44, 'Ce mois-ci', 12, '#fff', 500, 'middle', .7)
    s += t(90, 100, '0', 52, SAFRAN, 800, 'middle') + t(90, 126, 'relance oubliée', 12.5, '#fff', 600, 'middle')
    s += ligne(28, 150, 124, '#ffffff', 1).replace('fill="#ffffff"', 'fill="#ffffff" opacity=".2"')
    s += t(90, 178, 'Tout part au bon', 11.5, '#fff', 400, 'middle', .8) + t(90, 194, 'moment, sans vous', 11.5, '#fff', 400, 'middle', .8) + '</g>'
    ecrire('automatisation', s)


# --------------------------------------------------------------- Référencement
def referencement():
    s = fond("Illustration : une page de résultats de recherche où l'entreprise apparaît sur la carte et en tête des résultats")
    page = r(0, 0, 520, 330, PAPIER)
    page += r(20, 16, 340, 32, IVOIRE, 16, f'stroke="{TRAIT}"') + t(40, 37, 'réparation climatiseur Cocody', 13, ENCRE, 500)
    page += f'<circle cx="340" cy="32" r="6" fill="none" stroke="{GRIS}" stroke-width="1.8"/>'
    # carte
    page += r(20, 62, 230, 150, '#dfe8d8', 10)
    for d in ['M20 120 Q90 90 160 130 T250 110', 'M80 62 L120 212', 'M20 180 L250 160']:
        page += f'<path d="{d}" stroke="#fff" stroke-width="6" fill="none"/>'
    page += f'<path d="M200 62 q20 60 50 80 v70 h-80 z" fill="#b9d7ea"/>'
    for (px, py, principal) in [(118, 120, True), (70, 170, False), (190, 175, False)]:
        couleur = ROUGE if principal else GRIS
        page += f'<path d="M{px} {py} c-9 -12 -9 -24 0 -26 c9 2 9 14 0 26z" transform="translate(0,-4)" fill="{couleur}"/><circle cx="{px}" cy="{py - 19}" r="3.5" fill="#fff"/>'
    page += r(80, 76, 120, 26, PAPIER, 6, 'filter="url(#ombre-douce)"') + t(140, 93, 'Votre entreprise', 10.5, ENCRE, 800, 'middle')
    # fiche
    page += r(264, 62, 236, 150, '#fff', 10, f'stroke="{TRAIT}"')
    page += t(280, 88, 'Votre entreprise', 14, ENCRE, 800) + t(280, 106, 'Climatisation · Cocody, Abidjan', 10.5, GRIS)
    page += t(280, 124, 'Ouvert · ferme à 18 h', 10.5, VERT, 600)
    for i, b in enumerate(['Appeler', 'Itinéraire', 'Site web']):
        page += r(280 + i * 72, 140, 64, 26, IVOIRE, 13) + t(312 + i * 72, 157, b, 9.5, ENCRE_DOUCE, 700, 'middle')
    page += ligne(280, 184, 200) + ligne(280, 196, 150)
    # résultats
    for i in range(2):
        y = 230 + i * 48
        page += t(20, y, 'votre-entreprise.ci › reparation' if i == 0 else 'votre-entreprise.ci › tarifs', 10, GRIS)
        page += t(20, y + 18, 'Réparation de climatiseur à Cocody' if i == 0 else 'Entretien de climatiseur : prix et délais', 14, '#1a4fb4', 600)
        page += ligne(20, y + 28, 380 - i * 60, GRIS_CLAIR, 6)
    s += navigateur(60, 70, 520, 368, 'recherche', page)
    s += f'<g transform="translate(430,30)" filter="url(#ombre-douce)">{r(0, 0, 180, 40, SAFRAN, 20)}'
    s += t(90, 25, 'Fiche complète', 12.5, ENCRE, 800, 'middle') + '</g>'
    ecrire('referencement', s)


# --------------------------------------------------------------- Maintenance
def maintenance():
    s = fond("Illustration : un tableau de surveillance montrant la sauvegarde du jour réussie et les services en marche")
    s += f'<g transform="translate(60,60)" filter="url(#ombre)">{r(0, 0, 330, 400, PAPIER, 18)}'
    s += t(26, 44, 'Surveillance', 16, ENCRE, 800) + t(26, 64, 'Mise à jour il y a 1 min', 11, GRIS)
    s += r(26, 82, 278, 64, '#e3f4ea', 12) + coche(54, 114, VERT, 14) + t(80, 110, 'Tout fonctionne', 14, VERT, 800) + t(80, 128, 'site, messagerie, logiciel', 11.5, GRIS)
    services = [('Site internet', 'en ligne'), ('Messagerie', 'en ligne'), ('Logiciel de gestion', 'en ligne')]
    for i, (nom, etat) in enumerate(services):
        y = 172 + i * 44
        s += t(26, y, nom, 12.5, ENCRE, 600) + t(304, y, etat, 11, VERT, 700, 'end')
        for k in range(28):
            s += r(26 + k * 10, y + 10, 7, 14, VERT, 2, f'opacity="{.55 + (k % 3) * .15}"')
    s += ligne(26, 314, 278, SABLE, 1)
    s += t(26, 342, 'Sauvegarde du jour', 12.5, ENCRE, 700) + t(304, 342, '02 h 00', 11, GRIS, 600, 'end')
    s += coche(36, 368, VERT, 9) + t(52, 373, 'Copie 1 : réussie', 11.5, ENCRE) + coche(180, 368, VERT, 9) + t(196, 373, 'Copie 2 : réussie', 11.5, ENCRE)
    s += '</g>'
    for i, (lieu, y) in enumerate([('Copie 1', 110), ('Copie 2', 300)]):
        s += f'<g transform="translate(450,{y})" filter="url(#ombre-douce)">{r(0, 0, 150, 110, ENCRE, 16)}'
        for k in range(3):
            s += r(24, 22 + k * 22, 102, 16, '#ffffff', 5, 'opacity=".12"') + f'<circle cx="112" cy="{30 + k * 22}" r="3" fill="{VERT}"/>'
        s += t(75, 98, lieu, 11.5, '#fff', 700, 'middle') + '</g>'
    s += f'<path d="M392 200 C420 200 420 165 450 165 M392 260 C420 260 420 355 450 355" stroke="{SAFRAN}" stroke-width="2.5" fill="none" stroke-dasharray="3 6" stroke-linecap="round"/>'
    ecrire('maintenance', s)


# --------------------------------------------------------------- Formation
def formation():
    s = fond("Illustration : une formation à l'intelligence artificielle sur ordinateur, appliquée à un vrai document de travail")
    w, h = 520, 320
    x0, y0 = 60, 56
    s += f'<g transform="translate({x0},{y0})" filter="url(#ombre)">'
    s += r(0, 0, w, h, '#05101f', 16) + r(10, 10, w - 20, h - 20, PAPIER, 8)
    s += r(10, 10, w - 20, 38, IVOIRE, 8) + r(10, 40, w - 20, 8, IVOIRE)
    s += t(26, 34, 'Module 3 · Résumer et vérifier', 12.5, ENCRE, 800) + r(380, 22, 110, 14, SABLE, 7) + r(380, 22, 74, 14, SAFRAN, 7)
    s += r(26, 64, 220, 230, '#fff', 10, f'stroke="{TRAIT}"') + t(40, 88, 'Votre document', 11, GRIS, 700)
    for k in range(9):
        s += ligne(40, 102 + k * 18, 190 - (k % 3) * 28, GRIS_CLAIR, 7)
    s += r(40, 262, 120, 16, SAFRAN, 8, 'opacity=".25"')
    s += r(262, 64, 232, 230, ENCRE, 10)
    s += r(276, 80, 170, 46, '#ffffff', 10, 'opacity=".12"') + t(288, 99, 'Résume ce rapport en', 11, '#fff', 500) + t(288, 115, 'trois points clés.', 11, '#fff', 500)
    s += r(300, 138, 180, 92, PAPIER, 10)
    for k, l in enumerate(['1. Ventes en hausse', '2. Stock à revoir', '3. Deux relances dues']):
        s += t(312, 160 + k * 22, l, 11, ENCRE, 600)
    s += r(276, 244, 204, 36, SAFRAN, 10, 'opacity=".2"') + t(288, 260, 'Toujours vérifier les', 10.5, SAFRAN, 700) + t(288, 274, 'chiffres dans la source.', 10.5, SAFRAN, 700)
    s += '</g>'
    s += r(x0 - 30, y0 + h, w + 60, 14, '#1b2c47', 7)
    s += f'<g transform="translate(60,420)" filter="url(#ombre-douce)">{r(0, 0, 240, 56, PAPIER, 14)}'
    s += coche(26, 28) + t(44, 24, 'Exercices sur vos', 12.5, ENCRE, 700) + t(44, 41, 'propres documents', 11.5, GRIS) + '</g>'
    ecrire('formation', s)


if __name__ == '__main__':
    print(f'Maquettes → {SORTIE}')
    for f in (chatbot, site_web, boutique, application_mobile, logiciel, automatisation, referencement, maintenance, formation):
        f()
