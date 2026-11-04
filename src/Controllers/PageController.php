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
            // Bascule sur la direction v2 (2026-08-13). L'ancienne vue reste sur
            // le disque et dans l'historique Git : revenir en arriere ne demande
            // que de retirer ces deux lignes.
            'vue'         => 'pages/accueil-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/',
            'titre'       => "Agence de développement web et de logiciel sur mesure à Abidjan | EA-SERVICES",
            'description' => "Agence digitale à Abidjan : développement web, développement de logiciel sur mesure, automatisation et IA pour entreprises. Récupérez 420 à 720 heures par an. Diagnostic gratuit.",
        ],
        'services' => [
            // Portée sur la direction v2 (2026-08-13). L'ancienne vue reste sur
            // le disque et dans Git : revenir = retirer ces deux lignes.
            'vue'         => 'pages/services-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/services',
            'titre'       => "Automatisation, chatbot WhatsApp, prospection : nos services à Abidjan | EA-SERVICES",
            'description' => "Automatisation des tâches, chatbot WhatsApp, référencement, gestion commerciale, maintenance informatique : cinq pertes traitées, un chiffre en face de chacune.",
        ],
        'produits' => [
            'vue'         => 'pages/produits-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/produits',
            'titre'       => "Solutions : site internet, prospection automatisée, recrutement | EA-SERVICES",
            'description' => "Création de site internet, prospection commerciale automatisée et recrutement simplifié : trois solutions pour entreprises ivoiriennes, pensées pour fonctionner ensemble.",
        ],
        // Application mobile (ajoutee 2026-11-04). Nouvelle adresse, aucune URL existante touchee.
        'sonnera' => [
            'vue'         => 'pages/sonnera',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/sonnera',
            'titre'       => "Sonnera : application de rappels pour équipes | EA-SERVICES",
            'description' => "Une alarme qui sonne même téléphone verrouillé, des tâches réparties entre collègues et un responsable prévenu si rien n'est fait. Application Android.",
        ],
        'prestations' => [
            'vue'         => 'pages/prestations-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/prestations',
            'titre'       => "Développement de logiciel sur mesure, site web, IA à Abidjan | EA-SERVICES",
            'description' => "Développement de logiciel sur mesure, application web ou mobile, site vitrine, boutique en ligne, automatisation, formation informatique et IA : nos prestations, une par une.",
        ],
        'realisations' => [
            'vue'         => 'pages/realisations-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/realisations',
            'titre'       => "Nos réalisations : sites web et résultats clients à Abidjan | EA-SERVICES",
            'description' => "Exemples réels de sites web et applications créés pour des entreprises ivoiriennes, avec les chiffres avant/après : placements, prospects, heures récupérées.",
        ],
        'blog' => [
            'vue'         => 'pages/blog-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/blog',
            'titre'       => "Blog — automatisation, IA, création de site web pour PME | EA-SERVICES",
            'description' => "Chatbot WhatsApp, agent IA, création de site web, recrutement : nos articles répondent à ce que les entreprises ivoiriennes cherchent vraiment sur Google.",
        ],
        'a-propos' => [
            'vue'         => 'pages/a-propos-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/a-propos',
            'titre'       => "Notre agence web à Abidjan — pourquoi EA-SERVICES existe",
            'description' => "Il n'existe pas d'achat, il n'existe que des investissements. Notre principe, notre méthode en quatre étapes et nos engagements. Agence basée à Marcory, Abidjan.",
        ],
        'contact' => [
            // Portee sur la direction v2 (2026-08-13). Formulaire identique :
            // memes champs, meme CSRF, meme action POST, repli sans JavaScript.
            'vue'         => 'pages/contact-v2',
            'gabarit'     => 'layouts/public-v2',
            'canonical'   => '/pages/contact',
            'titre'       => "Contact agence web Abidjan — diagnostic gratuit de 30 minutes | EA-SERVICES",
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
        ], $p['gabarit'] ?? 'layouts/public-v2');
    }

    private function articlesRecents(int $limite): array
    {
        return Database::tous(
            'SELECT title, slug, excerpt, category_label, image_url, read_time, created_at
             FROM articles WHERE published = 1 ORDER BY datetime(created_at) DESC LIMIT ?',
            [$limite]
        );
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
        $html = Vue::rendre('pages/introuvable-v2', [
            'articles' => $this->articlesRecents(3),
        ], 'layouts/public-v2');
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
    /** Balise appelee par ea-v2.js apres une interaction reelle (defilement, toucher, clic). */
    public function humain(): string
    {
        \EA\Core\Visites::confirmer((string)($_POST['p'] ?? ''));
        http_response_code(204);
        return '';
    }

    public function disparue(): string
    {
        http_response_code(410);
        Vue::meta([
            'titre'       => 'Page supprimée — EA-SERVICES',
            'description' => "Cette adresse n'existe plus.",
            'canonical'   => '/',
            'robots'      => 'noindex, follow',
        ]);
        echo Vue::rendre('pages/introuvable-v2', [
            'articles' => $this->articlesRecents(3),
            'disparue' => true,
        ], 'layouts/public-v2');
        return '';
    }
}
