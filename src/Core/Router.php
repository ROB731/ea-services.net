<?php
declare(strict_types=1);

namespace EA\Core;

/**
 * Routeur.
 *
 * Ordre de traitement, volontairement dans cet ordre :
 *   1. normalisation de l'URL (barre finale, casse) → 301 si elle change
 *   2. redirections héritées (.html du site statique) → 301
 *   3. routes exactes, puis routes à segments {slug}
 *   4. 404 habillée
 *
 * Le 301 passe avant tout le reste parce que le site a 4133 visites déjà
 * indexées : une URL héritée qui tombe en 404 est de l'indexation perdue,
 * et elle met des mois à revenir (cf. skill ea-seo).
 */
final class Router
{
    /** @var array<string,array<int,array{0:string,1:callable|array}>> */
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $chemin, array $action): void  { $this->routes['GET'][]  = [$chemin, $action]; }
    public function post(string $chemin, array $action): void { $this->routes['POST'][] = [$chemin, $action]; }

    public function dispatch(string $methode, string $uri): void
    {
        $chemin = parse_url($uri, PHP_URL_PATH) ?: '/';
        $chemin = rawurldecode($chemin);

        if ($methode === 'GET') {
            $cible = self::normaliser($chemin);
            if ($cible !== null && $cible !== $chemin) { self::rediriger($cible, $uri); }

            $cible = self::heritee($chemin);
            if ($cible !== null) { self::rediriger($cible, $uri); }
        }

        Visites::enregistrer($chemin);

        foreach ($this->routes[$methode] ?? [] as [$motif, $action]) {
            if ($motif === $chemin) { $this->appeler($action, []); return; }
        }
        foreach ($this->routes[$methode] ?? [] as [$motif, $action]) {
            if (!str_contains($motif, '{')) continue;
            if (preg_match(self::regex($motif), $chemin, $capture)) {
                array_shift($capture);
                $this->appeler($action, array_map('rawurldecode', $capture));
                return;
            }
        }

        (new \EA\Controllers\PageController())->introuvable();
    }

    /**
     * Barre finale et majuscules : deux adresses pour une même page, donc du
     * contenu dupliqué aux yeux de Google. Une page, une adresse, un signal.
     * `/` reste `/`, et les URL d'assets ne passent pas ici (Apache les sert).
     */
    private static function normaliser(string $chemin): ?string
    {
        $propre = preg_replace('#/{2,}#', '/', $chemin) ?? $chemin;
        if ($propre !== '/' && str_ends_with($propre, '/')) $propre = rtrim($propre, '/');
        if ($propre === '') $propre = '/';
        if (preg_match('#[A-Z]#', $propre)) $propre = strtolower($propre);
        return $propre === $chemin ? null : $propre;
    }

    /**
     * URL du site statique précédent, encore présentes dans l'index Google et
     * dans les liens partagés. Mesuré dans la table `visits` : 1807 visites
     * sur des adresses en .html, dont /pages/services.html (79),
     * /pages/investissement-temps.html (56), /pages/blog.html (56).
     */
    private static function heritee(string $chemin): ?string
    {
        if ($chemin === '/index.html' || $chemin === '/accueil.html') return '/';

        // La page « investissement temps » n'existe plus : son sujet est
        // traité par le gain Temps de la page Services.
        if (preg_match('#^/pages/investissement-temps(\.html)?$#', $chemin)) return '/pages/services';

        if (preg_match('#^/(pages|article)/([a-z0-9-]+)\.html$#', $chemin, $m)) {
            return '/' . $m[1] . '/' . $m[2];
        }
        // Anciens chemins sans préfixe : /services.html, /contact…
        if (preg_match('#^/(services|produits|blog|a-propos|contact)(\.html)?$#', $chemin, $m)) {
            return '/pages/' . $m[1];
        }
        return null;
    }

    /** 301 en conservant la chaîne de requête (utm_source et compagnie). */
    private static function rediriger(string $cible, string $uriOrigine): never
    {
        $query = parse_url($uriOrigine, PHP_URL_QUERY);
        header('Location: ' . $cible . ($query ? '?' . $query : ''), true, 301);
        exit;
    }

    private static function regex(string $motif): string
    {
        $parties = preg_split('/(\{[a-z0-9_]+\})/i', $motif, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [];
        $regex = '';
        foreach ($parties as $partie) {
            $regex .= preg_match('/^\{[a-z0-9_]+\}$/i', $partie) ? '([^/]+)' : preg_quote($partie, '#');
        }
        return '#^' . $regex . '$#';
    }

    private function appeler(array $action, array $params): void
    {
        [$classe, $methode] = $action;
        $retour = (new $classe())->$methode(...$params);
        if (is_string($retour)) echo $retour;
    }
}
