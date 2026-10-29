<?php
declare(strict_types=1);

namespace EA\Core;

abstract class Controleur
{
    /**
     * Rend une page publique et pose les en-têtes de cache.
     *
     * $seo : titre, description, canonical, image, robots, type.
     * Le canonical est le chemin EXACT de la page, jamais REQUEST_URI —
     * sinon `?utm_source=facebook` crée une adresse canonique de plus pour
     * la même page (erreur déjà commise sur ce domaine).
     */
    protected function page(string $vue, array $donnees = [], array $seo = [], ?string $gabarit = 'layouts/public-v2'): string
    {
        Vue::meta($seo);
        $html = Vue::rendre($vue, $donnees, $gabarit);
        // Un fragment (gabarit null, destiné à la modale) n'a pas de sens à
        // mettre en cache HTTP page entière : ETag et Cache-Control publics
        // n'ont d'intérêt que pour une vraie page.
        if ($gabarit !== null) $this->cachePublic($html);
        return $html;
    }

    protected function admin(string $vue, array $donnees = []): string
    {
        header('Cache-Control: no-store, private');
        return Vue::rendre($vue, $donnees, 'layouts/admin');
    }

    /**
     * Cache navigateur 1 h, cache intermédiaire 24 h, plus revalidation par
     * ETag. Pas de compression ici : Apache s'en charge, et le doublon
     * provoque une « erreur d'encodage de contenu » (déjà rencontré).
     */
    private function cachePublic(string $html): void
    {
        if (headers_sent() || session_status() === PHP_SESSION_ACTIVE) return;
        $etag = '"' . md5($html) . '"';
        header('Cache-Control: public, max-age=3600, s-maxage=86400');
        header('ETag: ' . $etag);
        header('Vary: Accept-Encoding');
        if (($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') === $etag) {
            http_response_code(304);
            exit;
        }
    }

    /**
     * Vrai quand la page est demandée pour être injectée dans la modale
     * diagnostic (voir ea-v2.js) plutôt qu'affichée en page complète — le
     * contrôleur peut alors répondre avec `gabarit: null` (fragment seul,
     * sans <html>/<head>/pied de page) au lieu de la page entière.
     */
    protected function estRequeteModale(): bool
    {
        return ($_SERVER['HTTP_X_MODALE'] ?? '') === '1';
    }

    /**
     * Vrai quand l'appelant (JavaScript, via fetch) attend du JSON plutôt
     * qu'une redirection de page entière — utilisé par l'administration pour
     * agir sans rechargement (supprimer, publier, marquer comme lu…) tout en
     * gardant un formulaire classique fonctionnel sans JavaScript.
     */
    protected function veutJson(): bool
    {
        return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
    }

    protected function rediriger(string $chemin, int $code = 303): never
    {
        header('Location: ' . $chemin, true, $code);
        exit;
    }

    protected function json(array $donnees, int $code = 200): string
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        return (string)json_encode($donnees, JSON_UNESCAPED_UNICODE);
    }

    /** Champ de formulaire ; accepte aussi un corps JSON (envois en fetch). */
    protected function champ(string $cle, string $defaut = ''): string
    {
        if (array_key_exists($cle, $_POST)) return trim((string)$_POST[$cle]);
        static $json = null;
        if ($json === null) {
            $json = [];
            if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
                $decode = json_decode((string)file_get_contents('php://input'), true);
                if (is_array($decode)) $json = $decode;
            }
        }
        return array_key_exists($cle, $json) ? trim((string)$json[$cle]) : $defaut;
    }
}
