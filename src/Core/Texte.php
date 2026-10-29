<?php
declare(strict_types=1);

namespace EA\Core;

final class Texte
{
    /**
     * Met en forme le texte d'un article.
     *
     * Le contenu stocké est du texte brut : les paragraphes sont séparés par
     * une ligne vide, les listes commencent par un tiret. Il est ÉCHAPPÉ puis
     * balisé — jamais rendu tel quel. L'administration est protégée par mot
     * de passe, mais un contenu de base ne doit pas pouvoir injecter de script
     * dans une page publique : c'est la dernière barrière, elle reste en place.
     */
    public static function enHtml(string $brut): string
    {
        $brut = str_replace("\r\n", "\n", trim($brut));
        if ($brut === '') return '';

        $html = '';
        foreach (preg_split("/\n{2,}/", $brut) ?: [] as $bloc) {
            $bloc = trim($bloc);
            if ($bloc === '') continue;

            $lignes = explode("\n", $bloc);
            $puces  = array_filter($lignes, static fn($l) => (bool)preg_match('/^\s*[-–•*]\s+/u', $l));

            if (count($puces) === count($lignes)) {
                $html .= '<ul>';
                foreach ($lignes as $ligne) {
                    $html .= '<li>' . self::enrichir(preg_replace('/^\s*[-–•*]\s+/u', '', $ligne) ?? '') . '</li>';
                }
                $html .= '</ul>';
                continue;
            }

            // Une ligne courte terminée sans ponctuation : un intertitre.
            if (count($lignes) === 1 && mb_strlen($bloc) < 80 && !preg_match('/[.!?:;]$/u', $bloc)) {
                $html .= '<h2>' . self::enrichir($bloc) . '</h2>';
                continue;
            }

            $html .= '<p>' . implode('<br>', array_map([self::class, 'enrichir'], $lignes)) . '</p>';
        }
        return $html;
    }

    /** Échappe, puis rétablit le gras **ainsi** et les liens. */
    private static function enrichir(string $ligne): string
    {
        $s = htmlspecialchars(trim($ligne), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $s = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $s) ?? $s;
        return preg_replace(
            '#(?<!\w)(https?://[^\s<]+[^\s<.,;:!?)])#u',
            '<a href="$1" rel="noopener">$1</a>',
            $s
        ) ?? $s;
    }

    /** Résumé propre pour une meta description (150-160 caractères visés). */
    public static function extrait(string $texte, int $max = 158): string
    {
        $t = trim(preg_replace('/\s+/u', ' ', strip_tags($texte)) ?? '');
        if (mb_strlen($t) <= $max) return $t;
        $coupe = mb_substr($t, 0, $max - 1);
        $espace = mb_strrpos($coupe, ' ');
        return rtrim($espace !== false ? mb_substr($coupe, 0, $espace) : $coupe, " ,;:.") . '…';
    }

    /** Slug d'URL : minuscules, sans accent, tirets. */
    public static function slug(string $texte): string
    {
        $s = \Transliterator::create('Any-Latin; Latin-ASCII; Lower()')?->transliterate($texte)
             ?? strtolower($texte);
        $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
        return trim($s, '-') ?: 'article';
    }

    /** Durée de lecture affichée, calculée sur 200 mots par minute. */
    public static function dureeLecture(string $texte): string
    {
        $mots = max(1, str_word_count(strip_tags($texte), 0, 'àâäéèêëïîôöùûüçÀÂÄÉÈÊËÏÎÔÖÙÛÜÇ'));
        return max(1, (int)ceil($mots / 200)) . ' min';
    }

    /**
     * Adresse d'intégration (iframe) à partir d'un lien YouTube ou Vimeo
     * collé en administration. On ne fait JAMAIS confiance à l'URL saisie
     * telle quelle dans un `src` d'iframe : seul l'identifiant de vidéo,
     * extrait par expression régulière, sert à reconstruire une adresse
     * d'intégration connue — tout autre lien (autre domaine, script) est
     * ignoré plutôt qu'intégré.
     */
    public static function urlIntegrationVideo(?string $url): ?string
    {
        $url = trim((string)$url);
        if ($url === '') return null;

        if (preg_match('#youtu(?:be\.com/watch\?v=|be\.com/shorts/|\.be/)([\w-]{6,})#', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/' . $m[1];
        }
        if (preg_match('#vimeo\.com/(\d+)#', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }
        return null;
    }
}
