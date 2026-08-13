<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Config;
use EA\Core\Controleur;
use EA\Core\Database;
use EA\Core\Vue;

/**
 * Les six pages du site.
 *
 * Elles ne sont plus stockées en base : ce sont des gabarits versionnés.
 * Une page d'accueil n'est pas un article — elle a une structure propre
 * (bandeau, cartes de gain, preuves), et la stocker comme un bloc de HTML
 * dans une colonne empêchait de la faire évoluer sans réécrire le bloc.
 * Les articles, eux, restent en base : ils sont rédigés en administration.
 */
final class PageController extends Controleur
{
    /** Métadonnées SEO par page. Une page, une adresse, un signal. */
    private const PAGES = [
        'accueil' => [
            'vue'         => 'pages/accueil',
            'canonical'   => '/',
            'titre'       => "Augmentez vos résultats sans augmenter vos coûts — EA-SERVICES",
            'description' => "Récupérez 420 à 720 heures par an, répondez à vos clients en moins de 2 minutes et gagnez en visibilité. Diagnostic gratuit de 30 minutes à Abidjan.",
        ],
        'services' => [
            'vue'         => 'pages/services',
            'canonical'   => '/pages/services',
            'titre'       => "Nos services — cinq pertes, cinq façons de les arrêter | EA-SERVICES",
            'description' => "Temps, clients, visibilité, chiffre d'affaires, sérénité : comment nous traitons vos cinq plus grosses pertes, avec un chiffre en face de chacune.",
        ],
        'produits' => [
            'vue'         => 'pages/produits',
            'canonical'   => '/pages/produits',
            'titre'       => "Nos solutions — visibilité, prospection, recrutement | EA-SERVICES",
            'description' => "Trois ensembles qui se renforcent : présence en ligne complète, prospection commerciale autonome et recrutement simplifié pour les entreprises ivoiriennes.",
        ],
        'blog' => [
            'vue'         => 'pages/blog',
            'canonical'   => '/pages/blog',
            'titre'       => "Résultats clients — cas réels et chiffres | EA-SERVICES",
            'description' => "De 10 à 30 placements par mois, 3 heures récupérées par jour, 15 heures par semaine rendues à un dirigeant : trois cas clients détaillés, chiffres à l'appui.",
        ],
        'a-propos' => [
            'vue'         => 'pages/a-propos',
            'canonical'   => '/pages/a-propos',
            'titre'       => "À propos — pourquoi EA-SERVICES existe | Abidjan",
            'description' => "Il n'existe pas d'achat, il n'existe que des investissements. Notre principe, notre méthode en quatre étapes et nos engagements. Équipe basée à Abidjan.",
        ],
        'contact' => [
            'vue'         => 'pages/contact',
            'canonical'   => '/pages/contact',
            'titre'       => "Contact — diagnostic gratuit de 30 minutes | EA-SERVICES",
            'description' => "WhatsApp, téléphone ou formulaire : réservez votre diagnostic gratuit de 30 minutes. Réponse sous 2 heures. EA-SERVICES, Marcory Biétry, Abidjan.",
        ],
    ];

    public function accueil(): string
    {
        return $this->rendre('accueil', [
            'temoignages' => Database::tous('SELECT name, comment, rating FROM testimonials ORDER BY id DESC LIMIT 3'),
            'articles'    => $this->articlesRecents(3),
        ]);
    }

    /** /pages/{slug} — les slugs sont figés, un slug inconnu part en 404. */
    public function afficher(string $slug): string
    {
        $slug = strtolower(preg_replace('/[^a-z0-9-]/i', '', $slug) ?? '');
        if ($slug === 'accueil' || $slug === 'index') {
            header('Location: /', true, 301);
            exit;
        }
        if (!isset(self::PAGES[$slug]) || $slug === 'accueil') {
            return $this->introuvable();
        }
        $donnees = $slug === 'blog' ? ['articles' => $this->articlesRecents(12)] : [];
        return $this->rendre($slug, $donnees);
    }

    private function rendre(string $cle, array $donnees = []): string
    {
        $p = self::PAGES[$cle];
        return $this->page($p['vue'], $donnees, [
            'titre'       => $p['titre'],
            'description' => $p['description'],
            'canonical'   => $p['canonical'],
            'json_ld'     => Seo::blocsCommuns($cle),
        ]);
    }

    private function articlesRecents(int $limite): array
    {
        return Database::tous(
            'SELECT title, slug, excerpt, category_label, image_url, read_time, created_at
             FROM articles WHERE published = 1 ORDER BY datetime(created_at) DESC LIMIT ?',
            [$limite]
        );
    }

    /**
     * `/apercu` — prototype de la nouvelle direction artistique.
     *
     * Vit à côté de la production, jamais à sa place : aucune page en ligne
     * n'est modifiée, l'adresse n'est ni dans la navigation, ni dans le
     * sitemap, et elle est explicitement désindexée. À supprimer le jour où
     * la v2 remplace la v1 (ou si elle est abandonnée).
     */
    public function apercu(): string
    {
        header('X-Robots-Tag: noindex, nofollow');

        Vue::meta([
            'titre'       => "Aperçu de la nouvelle direction — EA-SERVICES",
            'description' => "Prototype interne. Cette adresse n'est pas publiée.",
            'canonical'   => '/apercu',
            'robots'      => 'noindex, nofollow',
        ]);

        return Vue::rendre('pages/accueil-v2', [
            'temoignages' => Database::tous('SELECT name, comment, rating FROM testimonials ORDER BY id DESC LIMIT 3'),
            'articles'    => $this->articlesRecents(3),
        ], 'layouts/public-v2');
    }

    /** 404 habillée : elle garde le visiteur sur le site au lieu de le perdre. */
    public function introuvable(): string
    {
        http_response_code(404);
        Vue::meta([
            'titre'       => 'Page introuvable — EA-SERVICES',
            'description' => "Cette page n'existe pas ou a été déplacée.",
            'canonical'   => '/',
            'robots'      => 'noindex, follow',
        ]);
        $html = Vue::rendre('pages/introuvable', [
            'articles' => $this->articlesRecents(3),
        ], 'layouts/public');
        echo $html;
        return '';
    }

    /**
     * `/ea-services-404.html` : page d'erreur du site statique précédent,
     * frappée 620 fois et présente dans l'index. Elle ne redirige pas (ce
     * serait mentir sur son contenu) : elle déclare que la ressource a
     * définitivement disparu, ce qui la fait sortir de l'index plus vite
     * qu'un simple 404.
     */
    public function disparue(): string
    {
        http_response_code(410);
        Vue::meta([
            'titre'       => 'Page supprimée — EA-SERVICES',
            'description' => "Cette adresse n'existe plus.",
            'canonical'   => '/',
            'robots'      => 'noindex, follow',
        ]);
        echo Vue::rendre('pages/introuvable', [
            'articles' => $this->articlesRecents(3),
            'disparue' => true,
        ], 'layouts/public');
        return '';
    }
}
