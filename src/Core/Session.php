<?php
declare(strict_types=1);

namespace EA\Core;

/**
 * Session.
 *
 * Démarrée seulement quand elle sert (formulaire, administration) : une page
 * publique qui ouvre une session émet un cookie et un en-tête `Cache-Control:
 * private`, ce qui annule le cache HTTP de toutes les pages du site.
 */
final class Session
{
    public static function demarrer(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;

        $repertoire = dirname(__DIR__, 2) . '/storage/sessions';
        if (!is_dir($repertoire)) @mkdir($repertoire, 0775, true);
        if (is_dir($repertoire) && is_writable($repertoire)) session_save_path($repertoire);

        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_name('ea_session');
        session_start();
    }
}
