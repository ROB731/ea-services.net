<?php
declare(strict_types=1);

namespace EA\Core;

/**
 * Comptage d'audience.
 *
 * L'ancien compteur additionnait tout ce qui frappait le serveur : sur les
 * 4133 lignes héritées, environ 1700 sont des scanners (`/wp-admin/install.php`
 * 154 fois, `/.env` 40, `/.git/config` 28). Le chiffre affiché en
 * administration n'était donc pas l'audience.
 *
 * Ici chaque visite est enregistrée MAIS classée : `bot = 1` pour les
 * scanners et les robots déclarés. L'administration compte les humains, sans
 * perdre l'historique brut.
 *
 * Best-effort absolu : un problème de comptage ne doit jamais casser une page.
 */
final class Visites
{
    /** Chemins jamais comptés : administration, points d'appel interne, fichiers. */
    private const IGNORES = ['#^/admin#', '#^/__#', '#\.(css|js|jpe?g|png|svg|webp|ico|xml|txt|map|woff2?)$#'];

    /** Signatures de scanners d'exploitation — jamais un visiteur réel. */
    private const SCANNERS = '#(wp-admin|wp-login|wp-json|wp-content|xmlrpc|\.env|\.git|phpmyadmin|/vendor/|eval-stdin|/cgi-bin/|\.aws|/config\.|/backup)#i';

    private const ROBOTS = '#(bot|crawl|spider|slurp|curl|wget|python-requests|scrapy|headless|monitoring|semrush|ahrefs|mj12|dotbot|petalbot)#i';

    public static function enregistrer(string $chemin, ?string $referrer = null, ?string $userAgent = null): void
    {
        foreach (self::IGNORES as $motif) {
            if (preg_match($motif, $chemin)) return;
        }

        $ua  = $userAgent ?? ($_SERVER['HTTP_USER_AGENT'] ?? '');
        $bot = preg_match(self::SCANNERS, $chemin) || ($ua !== '' && preg_match(self::ROBOTS, $ua)) ? 1 : 0;

        try {
            // L'IP n'est conservée que si le visiteur a accepté le dépôt de
            // cookies — sans consentement la visite compte quand même, mais
            // de façon anonyme.
            $consent = ($_COOKIE['ea_consent'] ?? '') === 'accepte';
            Database::executer(
                'INSERT INTO visits (path, ip, user_agent, referrer, bot, created_at) VALUES (?, ?, ?, ?, ?, ?)',
                [
                    substr($chemin, 0, 255),
                    $consent ? self::ip() : null,
                    substr($ua, 0, 255) ?: null,
                    substr($referrer ?? ($_SERVER['HTTP_REFERER'] ?? ''), 0, 255) ?: null,
                    $bot,
                    date('Y-m-d H:i:s'),
                ]
            );
        } catch (\Throwable) {
            // silence volontaire
        }
    }

    /** X-Forwarded-For d'abord : Apache peut être derrière un proxy. */
    public static function ip(): ?string
    {
        $transmise = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        if ($transmise !== '') {
            return trim(explode(',', $transmise)[0]) ?: null;
        }
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }
}
