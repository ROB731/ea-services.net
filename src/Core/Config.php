<?php
declare(strict_types=1);

namespace EA\Core;

/**
 * Accès en lecture seule à config/site.php, chargé une seule fois.
 * `Config::get('contact.whatsapp')` plutôt qu'un tableau baladé de vue en vue.
 */
final class Config
{
    private static ?array $data = null;

    public static function all(): array
    {
        if (self::$data === null) {
            self::$data = require dirname(__DIR__, 2) . '/config/site.php';
        }
        return self::$data;
    }

    /** @return mixed Chemin pointé : 'contact.email'. $defaut si absent. */
    public static function get(string $chemin, mixed $defaut = null): mixed
    {
        $valeur = self::all();
        foreach (explode('.', $chemin) as $cle) {
            if (!is_array($valeur) || !array_key_exists($cle, $valeur)) return $defaut;
            $valeur = $valeur[$cle];
        }
        return $valeur;
    }

    /** URL absolue sur le domaine canonique — pour les balises SEO et le sitemap. */
    public static function url(string $chemin = '/'): string
    {
        return rtrim((string)self::get('domaine'), '/') . '/' . ltrim($chemin, '/');
    }

    /** Lien WhatsApp pré-rempli avec le message de diagnostic. */
    public static function whatsapp(): string
    {
        return 'https://wa.me/' . self::get('contact.whatsapp')
             . '?text=' . rawurlencode((string)self::get('contact.whatsapp_message'));
    }
}
