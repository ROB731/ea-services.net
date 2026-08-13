<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Database;
use EA\Core\Texte;

/**
 * Articles.
 *
 * Les six slugs existants sont conservés à l'identique — ils sont indexés et
 * figurent dans la liste des URL à préserver.
 */
final class ArticleController extends Controleur
{
    public function afficher(string $slug, array $etat = []): string
    {
        $article = Database::un(
            'SELECT * FROM articles WHERE slug = ? AND published = 1 LIMIT 1',
            [$slug]
        );

        if (!$article) {
            return (new PageController())->introuvable();
        }

        $article['content_html'] = Texte::enHtml((string)$article['content']);

        $commentaires = Database::tous(
            'SELECT name, comment, created_at FROM article_comments
             WHERE article_id = ? AND published = 1 ORDER BY datetime(created_at) DESC',
            [(int)$article['id']]
        );

        $suggestions = Database::tous(
            'SELECT title, slug, excerpt, category_label, image_url, read_time, created_at
             FROM articles WHERE published = 1 AND id <> ?
             ORDER BY (category = ?) DESC, datetime(created_at) DESC LIMIT 3',
            [(int)$article['id'], (string)$article['category']]
        );

        return $this->page('blog/article', [
            'article'            => $article,
            'commentaires'       => $commentaires,
            'suggestions'        => $suggestions,
            'etatCommentaire'    => $etat['etat'] ?? null,
            'messageCommentaire' => $etat['message'] ?? null,
        ], [
            'titre'       => $article['title'] . ' | EA-SERVICES',
            'description' => Texte::extrait((string)($article['excerpt'] ?: $article['content'])),
            'canonical'   => '/article/' . $article['slug'],
            'image'       => $article['image_url'] ?: '/assets/logo-ea-services.jpeg',
            'og_type'     => 'article',
            'json_ld'     => Seo::blocsArticle($article),
        ]);
    }

    /**
     * Dépôt d'un commentaire.
     *
     * Les commentaires sont relus avant publication (`published = 0`) : sur un
     * site professionnel, un commentaire indésirable publié automatiquement
     * abîme la crédibilité que le reste de la page cherche à construire.
     */
    public function commenter(string $slug): string
    {
        $article = Database::un('SELECT id FROM articles WHERE slug = ? AND published = 1', [$slug]);
        if (!$article) {
            return (new PageController())->introuvable();
        }

        $etat = ['etat' => 'erreur', 'message' => ''];

        if (!Csrf::valide($this->champ('csrf'))) {
            $etat['message'] = "Votre session a expiré. Rechargez la page et réessayez.";
            return $this->afficher($slug, $etat);
        }
        if ($this->champ('site') !== '') {
            // Piège à robots rempli : on répond normalement sans rien enregistrer.
            return $this->afficher($slug, ['etat' => 'ok', 'message' => 'Merci, votre commentaire sera relu avant publication.']);
        }

        $nom     = mb_substr($this->champ('nom'), 0, 80);
        $message = mb_substr($this->champ('commentaire'), 0, 2000);

        if (mb_strlen($nom) < 2 || mb_strlen($message) < 5) {
            $etat['message'] = "Indiquez votre nom et un commentaire d'au moins quelques mots.";
            return $this->afficher($slug, $etat);
        }

        Database::executer(
            'INSERT INTO article_comments (article_id, name, comment, published, created_at) VALUES (?, ?, ?, 0, ?)',
            [(int)$article['id'], $nom, $message, date('Y-m-d H:i:s')]
        );

        return $this->afficher($slug, [
            'etat'    => 'ok',
            'message' => 'Merci. Votre commentaire sera publié après relecture.',
        ]);
    }
}
