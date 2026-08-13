<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Auth;
use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Database;
use EA\Core\Texte;

/**
 * Administration.
 *
 * Volontairement sobre : elle sert à répondre à une demande, publier un
 * article et vérifier l'audience. Tout le reste est du décor.
 */
final class AdminController extends Controleur
{
    public function __construct()
    {
        Auth::exiger();
        header('X-Robots-Tag: noindex, nofollow');
    }

    /** Toute action qui modifie quelque chose passe par ici d'abord. */
    private function verifierJeton(): void
    {
        if (!Csrf::valide($this->champ('csrf'))) {
            http_response_code(419);
            exit('Session expirée. Revenez en arrière et rechargez la page.');
        }
    }

    // ---------------------------------------------------------------- tableau

    public function tableau(): string
    {
        $depuis30j = date('Y-m-d H:i:s', strtotime('-30 days'));

        return $this->admin('admin/tableau', [
            'onglet'          => 'tableau',
            'visitesHumaines' => (int)Database::valeur('SELECT COUNT(*) FROM visits WHERE bot = 0'),
            'visites30j'      => (int)Database::valeur('SELECT COUNT(*) FROM visits WHERE bot = 0 AND created_at >= ?', [$depuis30j]),
            'demandesNonLues' => (int)Database::valeur('SELECT COUNT(*) FROM messages WHERE read = 0'),
            'articlesPublies' => (int)Database::valeur('SELECT COUNT(*) FROM articles WHERE published = 1'),
            'commentairesEnAttente' => (int)Database::valeur('SELECT COUNT(*) FROM article_comments WHERE published = 0'),
            'dernieresDemandes' => Database::tous('SELECT id, payload_json, read, created_at FROM messages ORDER BY id DESC LIMIT 5'),
            'pagesVues'       => Database::tous(
                'SELECT path, COUNT(*) n FROM visits WHERE bot = 0 AND created_at >= ?
                 GROUP BY path ORDER BY n DESC LIMIT 10', [$depuis30j]
            ),
        ]);
    }

    // --------------------------------------------------------------- demandes

    public function demandes(): string
    {
        $lignes = Database::tous('SELECT * FROM messages ORDER BY id DESC LIMIT 200');
        foreach ($lignes as &$l) {
            $l['donnees'] = json_decode((string)$l['payload_json'], true) ?: [];
        }
        return $this->admin('admin/demandes', ['onglet' => 'demandes', 'demandes' => $lignes]);
    }

    public function marquerLue(): string
    {
        $this->verifierJeton();
        Database::executer('UPDATE messages SET read = 1 WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/demandes');
    }

    public function supprimerDemande(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM messages WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/demandes');
    }

    // --------------------------------------------------------------- articles

    public function articles(): string
    {
        return $this->admin('admin/articles', [
            'onglet'   => 'articles',
            'articles' => Database::tous('SELECT id, title, slug, category_label, published, created_at FROM articles ORDER BY datetime(created_at) DESC'),
            'edite'    => null,
        ]);
    }

    public function editerArticle(string $id): string
    {
        return $this->admin('admin/articles', [
            'onglet'   => 'articles',
            'articles' => Database::tous('SELECT id, title, slug, category_label, published, created_at FROM articles ORDER BY datetime(created_at) DESC'),
            'edite'    => Database::un('SELECT * FROM articles WHERE id = ?', [(int)$id]),
        ]);
    }

    public function enregistrerArticle(): string
    {
        $this->verifierJeton();

        $id      = (int)$this->champ('id');
        $titre   = mb_substr($this->champ('titre'), 0, 200);
        $contenu = $this->champ('contenu');

        if ($titre === '' || $contenu === '') {
            $this->rediriger('/admin/articles');
        }

        $extrait  = $this->champ('extrait') ?: Texte::extrait($contenu);
        $etiquette= mb_substr($this->champ('categorie'), 0, 40) ?: 'ANALYSE';
        $image    = $this->champ('image');
        $duree    = Texte::dureeLecture($contenu);
        $publie   = $this->champ('publie') === '1' ? 1 : 0;

        if ($id > 0) {
            // Le slug n'est JAMAIS modifié après publication : c'est l'adresse
            // indexée par Google. Changer un titre ne doit pas casser une URL.
            Database::executer(
                'UPDATE articles SET title = ?, excerpt = ?, content = ?, category_label = ?,
                        image_url = ?, read_time = ?, published = ? WHERE id = ?',
                [$titre, $extrait, $contenu, $etiquette, $image, $duree, $publie, $id]
            );
        } else {
            $slug = $this->slugLibre(Texte::slug($titre));
            Database::executer(
                'INSERT INTO articles (title, slug, excerpt, content, category, category_label,
                                       image_url, read_time, published, generated_by_ai, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)',
                [$titre, $slug, $extrait, $contenu, strtolower($etiquette), $etiquette,
                 $image, $duree, $publie, date('Y-m-d H:i:s')]
            );
        }
        $this->rediriger('/admin/articles');
    }

    private function slugLibre(string $base): string
    {
        $slug = $base;
        $i = 2;
        while (Database::valeur('SELECT 1 FROM articles WHERE slug = ?', [$slug])) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function basculerArticle(): string
    {
        $this->verifierJeton();
        Database::executer('UPDATE articles SET published = 1 - published WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/articles');
    }

    public function supprimerArticle(): string
    {
        $this->verifierJeton();
        $id = (int)$this->champ('id');
        Database::executer('DELETE FROM article_comments WHERE article_id = ?', [$id]);
        Database::executer('DELETE FROM articles WHERE id = ?', [$id]);
        $this->rediriger('/admin/articles');
    }

    // ----------------------------------------------------------- commentaires

    public function commentaires(): string
    {
        return $this->admin('admin/commentaires', [
            'onglet' => 'commentaires',
            'commentaires' => Database::tous(
                'SELECT c.*, a.title, a.slug FROM article_comments c
                 JOIN articles a ON a.id = c.article_id
                 ORDER BY c.published ASC, datetime(c.created_at) DESC LIMIT 200'
            ),
        ]);
    }

    public function validerCommentaire(): string
    {
        $this->verifierJeton();
        Database::executer('UPDATE article_comments SET published = 1 WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/commentaires');
    }

    public function supprimerCommentaire(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM article_comments WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/commentaires');
    }

    // ------------------------------------------------------------ témoignages

    public function temoignages(): string
    {
        return $this->admin('admin/temoignages', [
            'onglet' => 'temoignages',
            'temoignages' => Database::tous('SELECT * FROM testimonials ORDER BY id DESC'),
        ]);
    }

    public function ajouterTemoignage(): string
    {
        $this->verifierJeton();
        $nom  = mb_substr($this->champ('nom'), 0, 120);
        $avis = mb_substr($this->champ('avis'), 0, 1000);
        $note = max(1, min(5, (int)$this->champ('note')));
        if ($nom !== '' && $avis !== '') {
            Database::executer(
                'INSERT INTO testimonials (name, comment, rating, created_at) VALUES (?, ?, ?, ?)',
                [$nom, $avis, $note, date('Y-m-d H:i:s')]
            );
        }
        $this->rediriger('/admin/temoignages');
    }

    public function supprimerTemoignage(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM testimonials WHERE id = ?', [(int)$this->champ('id')]);
        $this->rediriger('/admin/temoignages');
    }

    // --------------------------------------------------------------- audience

    public function audience(): string
    {
        $depuis = date('Y-m-d', strtotime('-29 days'));

        return $this->admin('admin/audience', [
            'onglet' => 'audience',
            'parJour' => Database::tous(
                "SELECT date(created_at) jour, COUNT(*) n FROM visits
                 WHERE bot = 0 AND date(created_at) >= ? GROUP BY jour ORDER BY jour", [$depuis]
            ),
            'pages' => Database::tous(
                "SELECT path, COUNT(*) n FROM visits WHERE bot = 0 AND date(created_at) >= ?
                 GROUP BY path ORDER BY n DESC LIMIT 25", [$depuis]
            ),
            'origines' => Database::tous(
                "SELECT referrer, COUNT(*) n FROM visits
                 WHERE bot = 0 AND referrer IS NOT NULL AND referrer <> '' AND date(created_at) >= ?
                 GROUP BY referrer ORDER BY n DESC LIMIT 15", [$depuis]
            ),
            'total'   => (int)Database::valeur('SELECT COUNT(*) FROM visits WHERE bot = 0'),
            'robots'  => (int)Database::valeur('SELECT COUNT(*) FROM visits WHERE bot = 1'),
        ]);
    }
}
