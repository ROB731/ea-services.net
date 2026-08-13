<?php
declare(strict_types=1);

namespace EA\Core;

/**
 * Rendu des gabarits.
 *
 * Une vue reçoit ses variables, produit du HTML, et le layout l'enveloppe.
 * `e()` échappe : dans les vues on écrit `<?= e($titre) ?>` par défaut, et
 * `<?= $html ?>` seulement pour du contenu déjà connu comme sûr.
 */
final class Vue
{
    /** @var array<string,mixed> Métadonnées de la page en cours (titre, description, canonical…). */
    private static array $meta = [];

    public static function meta(array $meta): void
    {
        self::$meta = array_merge(self::$meta, $meta);
    }

    public static function lireMeta(string $cle, mixed $defaut = null): mixed
    {
        return self::$meta[$cle] ?? $defaut;
    }

    public static function rendre(string $vue, array $donnees = [], ?string $layout = 'layouts/public'): string
    {
        $contenu = self::capturer($vue, $donnees);
        if ($layout === null) return $contenu;
        return self::capturer($layout, $donnees + ['contenu' => $contenu]);
    }

    private static function capturer(string $vue, array $donnees): string
    {
        $chemin = dirname(__DIR__, 2) . '/views/' . $vue . '.php';
        if (!is_file($chemin)) {
            throw new \RuntimeException("Vue introuvable : $vue");
        }
        extract($donnees, EXTR_SKIP);
        ob_start();
        require $chemin;
        return (string)ob_get_clean();
    }
}
