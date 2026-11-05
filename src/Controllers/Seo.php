<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Config;
use EA\Core\Controleur;
use EA\Core\Database;

/**
 * Référencement : données structurées, sitemap, robots.
 *
 * Le constat de départ : ni sitemap.xml ni robots.txt n'existaient (404 tous
 * les deux), et aucune donnée structurée n'était publiée. Pour une entreprise
 * locale, les données structurées sont ce qui permet à Google d'afficher
 * l'adresse, le téléphone et les horaires directement dans les résultats.
 */
final class Seo extends Controleur
{
    /**
     * Blocs JSON-LD présents sur toutes les pages : l'organisation, le fil
     * d'Ariane, et le service local. Un seul objet Organization pour tout le
     * site, avec le même @id partout — sinon Google voit plusieurs entreprises.
     */
    public static function blocsCommuns(string $page = 'accueil'): array
    {
        $c = (array)Config::get('contact');
        $idOrg = Config::url('/#organisation');

        $organisation = [
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfessionalService',
            '@id'         => $idOrg,
            'name'        => 'EA-SERVICES',
            'url'         => Config::url('/'),
            'logo'        => Config::url('/assets/logo-ea-services.jpeg'),
            'image'       => Config::url('/assets/logo-ea-services.jpeg'),
            'description' => "Création de sites web, d'applications mobiles et de chatbots WhatsApp, "
                           . "automatisation des tâches et formation à l'IA pour les entreprises d'Abidjan.",
            'telephone'   => $c['telephone_e164'],
            'email'       => $c['email'],
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $c['quartier'],
                'addressLocality' => $c['ville'],
                'addressCountry'  => $c['pays_code'],
            ],
            'areaServed'  => [
                ['@type' => 'City',    'name' => 'Abidjan'],
                ['@type' => 'Country', 'name' => "Côte d'Ivoire"],
            ],
            'priceRange'  => 'FCFA',
            'knowsLanguage' => 'fr',
            // Les vrais profils sociaux, jamais un lien générique ou deviné :
            // c'est ce qui permet à Google de relier ces comptes à CETTE
            // entreprise (le même @id) plutôt que de les traiter à part.
            'sameAs'      => array_values((array)Config::get('reseaux', [])),
        ];

        $blocs = [$organisation];

        // Application Sonnera : donnees structurees d'une application. Aucune
        // note ni avis (on n'en a aucun de verifiable), aucun prix (sur demande).
        if ($page === 'sonnera') {
            $blocs[] = [
                '@context'            => 'https://schema.org',
                '@type'               => 'SoftwareApplication',
                'name'                => 'Sonnera',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Android, Web',
                'description'         => "Application de rappels et de suivi d'équipe : une alarme qui sonne même téléphone verrouillé, des tâches réparties entre collègues, et un responsable prévenu quand rien n'est fait.",
                'url'                 => Config::url('/pages/sonnera'),
                'inLanguage'          => 'fr',
                'publisher'           => ['@id' => $idOrg],
            ];
        }

        if ($page !== 'accueil') {
            $blocs[] = self::filAriane($page);
        }

        if ($page === 'contact') {
            $blocs[] = [
                '@context' => 'https://schema.org',
                '@type'    => 'ContactPage',
                'url'      => Config::url('/pages/contact'),
                'about'    => ['@id' => $idOrg],
            ];
        }

        // Le contenu structuré FAQPage doit correspondre à du texte RÉELLEMENT
        // affiché sur la même page (règle Google) — la FAQ visible vit sur
        // /pages/contact (views/pages/contact-v2.php), donc c'est la seule page
        // qui porte ce bloc.
        if ($page === 'contact') {
            $blocs[] = self::questionsFrequentes();
        }

        return $blocs;
    }

    private static function filAriane(string $page): array
    {
        $libelles = [
            'services' => 'Services', 'produits' => 'Solutions', 'prestations' => 'Prestations',
            'realisations' => 'Réalisations', 'sonnera' => 'Sonnera', 'blog' => 'Blog',
            'a-propos' => 'À propos', 'contact' => 'Contact',
        ];
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => Config::url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $libelles[$page] ?? $page,
                 'item' => Config::url('/pages/' . $page)],
            ],
        ];
    }

    /**
     * Questions réellement posées pendant les premiers échanges commerciaux.
     * Elles peuvent apparaître directement dans les résultats de recherche —
     * et elles lèvent les objections avant même la visite.
     */
    /**
     * Lit config/site.php ('faq') plutôt qu'une liste dupliquée ici : le
     * contenu structuré doit dire exactement ce que la page contact affiche,
     * jamais autre chose (Google pénalise un schéma FAQPage qui ne
     * correspond pas au contenu réellement visible).
     */
    private static function questionsFrequentes(): array
    {
        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static fn(array $x) => [
                '@type'          => 'Question',
                'name'           => $x['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $x['reponse']],
            ], (array)Config::get('faq', [])),
        ];
    }

    /**
     * Données structurées d'une page d'expertise : l'organisation, le service
     * proposé, le fil d'Ariane (Accueil › Prestations › Expertise) et la FAQ
     * EXACTEMENT telle qu'affichée sur la page.
     */
    public static function blocsExpertise(string $slug, array $x): array
    {
        $idOrg = Config::url('/#organisation');
        $url   = Config::url('/pages/' . $slug);
        $blocs = [self::blocsCommuns('expertise')[0]];

        $blocs[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $x['h1'],
            'serviceType' => $x['service'],
            'description' => $x['description'],
            'url'         => $url,
            'provider'    => ['@id' => $idOrg],
            'areaServed'  => [
                ['@type' => 'City',    'name' => 'Abidjan'],
                ['@type' => 'Country', 'name' => "Côte d'Ivoire"],
            ],
            'inLanguage'  => 'fr',
        ];
        $blocs[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil',     'item' => Config::url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Prestations', 'item' => Config::url('/pages/prestations')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $x['libelle'], 'item' => $url],
            ],
        ];
        $blocs[] = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static fn(array $qr) => [
                '@type'          => 'Question',
                'name'           => $qr[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $qr[1]],
            ], $x['faq']),
        ];
        return $blocs;
    }

    /** Données structurées d'un article. */
    public static function blocsArticle(array $article): array
    {
        return [
            [
                '@context'         => 'https://schema.org',
                '@type'            => 'BlogPosting',
                'headline'         => $article['title'],
                'description'      => $article['excerpt'],
                'image'            => $article['image_url'] ?: Config::url('/assets/logo-ea-services.jpeg'),
                'datePublished'    => date('c', strtotime((string)$article['created_at']) ?: time()),
                'dateModified'     => date('c', strtotime((string)$article['created_at']) ?: time()),
                'inLanguage'       => 'fr',
                'author'           => ['@type' => 'Organization', 'name' => 'EA-SERVICES', '@id' => Config::url('/#organisation')],
                'publisher'        => ['@id' => Config::url('/#organisation')],
                'mainEntityOfPage' => Config::url('/article/' . $article['slug']),
            ],
            [
                '@context' => 'https://schema.org',
                '@type'    => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil',   'item' => Config::url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => Config::url('/pages/blog')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $article['title'],
                     'item' => Config::url('/article/' . $article['slug'])],
                ],
            ],
        ];
    }

    /**
     * Sitemap généré depuis la base : un sitemap écrit à la main n'inclut
     * jamais les articles ajoutés après. `lastmod` porte la date réelle, pas
     * celle du jour — annoncer que tout a changé aujourd'hui fait perdre
     * toute valeur au signal.
     */
    public function sitemap(): string
    {
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=3600');

        $pages = [
            ['/',                   '1.0', 'weekly'],
            ['/pages/services',     '0.9', 'monthly'],
            ['/pages/produits',     '0.9', 'monthly'],
            ['/pages/prestations',  '0.9', 'monthly'],
            ['/pages/sonnera',      '0.8', 'monthly'],
            ['/pages/realisations', '0.8', 'monthly'],
            ['/pages/blog',         '0.8', 'weekly'],
            ['/pages/a-propos',     '0.7', 'monthly'],
            ['/pages/contact',      '0.8', 'monthly'],
        ];

        // Date du dernier déploiement des gabarits : c'est la vraie date de
        // modification des six pages, elles ne sont plus en base.
        $modifPages = date('Y-m-d', (int)(@filemtime(dirname(__DIR__, 2) . '/views/pages/accueil-v2.php') ?: time()));

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($pages as [$chemin, $priorite, $frequence]) {
            $this->entree($xml, Config::url($chemin), $modifPages, $frequence, $priorite);
        }

        // Pages d'expertise : date réelle = dernière modification de leur contenu.
        $modifExpertises = date('Y-m-d', (int)(@filemtime(dirname(__DIR__, 2) . '/config/expertises.php') ?: time()));
        foreach (array_keys(Config::expertises()) as $slug) {
            $this->entree($xml, Config::url('/pages/' . $slug), $modifExpertises, 'monthly', '0.9');
        }

        foreach (Database::tous(
            'SELECT slug, created_at FROM articles WHERE published = 1 ORDER BY datetime(created_at) DESC'
        ) as $a) {
            $this->entree(
                $xml,
                Config::url('/article/' . $a['slug']),
                date('Y-m-d', strtotime((string)$a['created_at']) ?: time()),
                'yearly',
                '0.7'
            );
        }

        $xml->endElement();
        $xml->endDocument();
        return $xml->outputMemory();
    }

    private function entree(\XMLWriter $xml, string $url, string $modif, string $frequence, string $priorite): void
    {
        $xml->startElement('url');
        $xml->writeElement('loc', $url);
        $xml->writeElement('lastmod', $modif);
        $xml->writeElement('changefreq', $frequence);
        $xml->writeElement('priority', $priorite);
        $xml->endElement();
    }

    public function robots(): string
    {
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: public, max-age=86400');

        return "User-agent: *\n"
             . "Allow: /\n"
             . "Disallow: /admin\n"
             . "Disallow: /__\n\n"
             . "Sitemap: " . Config::url('/sitemap.xml') . "\n";
    }
}
