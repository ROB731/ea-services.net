<?php
declare(strict_types=1);

/**
 * Fonctions disponibles dans toutes les vues (espace de noms global : un
 * fichier de vue inclus ne reprend pas l'espace de noms de l'appelant).
 */

use EA\Core\Config;

/** Échappement HTML. Règle : tout ce qui vient de la base passe par ici. */
function e(?string $valeur): string
{
    return htmlspecialchars((string)$valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Valeur de configuration : cfg('contact.email'). */
function cfg(string $chemin, mixed $defaut = null): mixed
{
    return Config::get($chemin, $defaut);
}

/** Lien WhatsApp pré-rempli. */
function whatsapp(): string
{
    return Config::whatsapp();
}

/**
 * Icône du sprite SVG. Une icône, jamais un emoji (règle absolue du projet) :
 * un emoji change de dessin selon le téléphone et affaiblit le sérieux.
 *
 * BUG RÉEL CORRIGÉ (2026-08-15) : contrairement à ea.css/ea-v2.css, cette
 * référence n'était jamais versionnée. Ajouter un symbole au sprite (le
 * chat, ici) ne servait donc à rien pour un visiteur dont le navigateur
 * avait déjà mis en cache l'ancienne version du fichier — icône absente,
 * alors qu'elle existe bien sur le serveur. `?v=filemtime` force une
 * nouvelle requête dès que le sprite change, comme pour les feuilles de style.
 */
function icone(string $nom, string $classe = 'ico'): string
{
    static $version = null;
    if ($version === null) {
        $version = @filemtime(dirname(__DIR__) . '/public/assets/icones.svg') ?: 1;
    }
    $nom = preg_replace('/[^a-z0-9-]/', '', $nom) ?? '';
    return '<svg class="' . e($classe) . '" aria-hidden="true" focusable="false">'
         . '<use href="/assets/icones.svg?v=' . $version . '#' . $nom . '"></use></svg>';
}

/** Date lisible en français, sans dépendre de la locale du serveur. */
function dateFr(?string $iso): string
{
    if (!$iso) return '';
    $t = strtotime($iso);
    if ($t === false) return '';
    $mois = ['', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
             'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
    return (int)date('j', $t) . ' ' . $mois[(int)date('n', $t)] . ' ' . date('Y', $t);
}
