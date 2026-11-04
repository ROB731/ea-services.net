<?php
declare(strict_types=1);

/**
 * Point d'entrée unique.
 *
 * Apache sert /opt/ea-services/public en DocumentRoot avec
 * `FallbackResource /index.php` : tout ce qui n'est pas un fichier réel
 * arrive ici. Pas de RewriteRule — les anciennes règles en [P] provoquaient
 * des boucles AH00124.
 */

/**
 * Serveur intégré de PHP (développement uniquement) : il envoie TOUTES les
 * requêtes au script de routage, y compris les fichiers réellement présents.
 * Sans ce garde, la feuille de style et les images partent en 404 en local
 * alors qu'elles fonctionnent en production — on teste alors une page sans
 * son habillage sans s'en rendre compte. Apache sert ces fichiers lui-même.
 */
if (PHP_SAPI === 'cli-server') {
    $fichier = __DIR__ . (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
    if (is_file($fichier)) return false;
}

require dirname(__DIR__) . '/src/bootstrap.php';

use EA\Core\Router;
use EA\Controllers\AdminController;
use EA\Controllers\ArticleController;
use EA\Controllers\AuthController;
use EA\Controllers\ChatController;
use EA\Controllers\ContactController;
use EA\Controllers\DiagnosticController;
use EA\Controllers\PageController;
use EA\Controllers\Seo;

$routeur = new Router();

/* ---------------------------------------------------------------- public
   Ces six adresses et les six adresses d'articles sont indexées : elles ne
   changent pas. */
$routeur->get('/',                 [PageController::class, 'accueil']);
$routeur->get('/pages/{slug}',     [PageController::class, 'afficher']);
$routeur->get('/article/{slug}',   [ArticleController::class, 'afficher']);
$routeur->post('/article/{slug}/commentaire', [ArticleController::class, 'commenter']);
$routeur->post('/pages/contact',   [ContactController::class, 'envoyer']);

// Diagnostic automatique : le questionnaire, puis son resultat chiffre.
$routeur->get('/diagnostic',  [DiagnosticController::class, 'formulaire']);
$routeur->post('/diagnostic', [DiagnosticController::class, 'calculer']);

/* Agent de conversation — voir ChatController pour le cadrage et la limite. */
$routeur->post('/chat/message',    [ChatController::class, 'message']);
$routeur->get('/chat/historique',  [ChatController::class, 'historique']);

/* Page d'erreur du site statique précédent : 410, pas 404 (sort de l'index
   plus vite). */
$routeur->get('/ea-services-404.html', [PageController::class, 'disparue']);

/* Deux articles d'un ancien site (emploi, colis) que Google redemande encore
   des dizaines de fois : 410 plutot que 404, il les retire de l'index plus
   vite et cesse de gaspiller son exploration sur ces adresses. */
foreach ([
    '/article/comment-trouver-un-emploi-a-abidjan-conseils-pratiques-et-outils-pour-2026',
    '/article/envoi-colis-abidjan-les-solutions-rapides-et-fiables-pour-livrer-en-ville',
] as $ancien) {
    $routeur->get($ancien, [PageController::class, 'disparue']);
}

/* Confirmation qu'un vrai navigateur a eu une vraie interaction (voir ea-v2.js). */
$routeur->post('/__h', [PageController::class, 'humain']);

/* ------------------------------------------------------------------- SEO */
$routeur->get('/sitemap.xml', [Seo::class, 'sitemap']);
$routeur->get('/robots.txt',  [Seo::class, 'robots']);

/* ---------------------------------------------------------------- accès */
$routeur->get('/admin/connexion',    [AuthController::class, 'formulaire']);
$routeur->post('/admin/connexion',   [AuthController::class, 'connecter']);
$routeur->get('/admin/deconnexion',  [AuthController::class, 'deconnecter']);

/* --------------------------------------------------------- administration */
$routeur->get('/admin',                        [AdminController::class, 'tableau']);
$routeur->get('/admin/demandes',               [AdminController::class, 'demandes']);
$routeur->post('/admin/demandes/lue',          [AdminController::class, 'marquerLue']);
$routeur->post('/admin/demandes/supprimer',    [AdminController::class, 'supprimerDemande']);
$routeur->get('/admin/articles',               [AdminController::class, 'articles']);
$routeur->get('/admin/articles/{id}',          [AdminController::class, 'editerArticle']);
$routeur->get('/admin/articles/{id}/previsualiser', [AdminController::class, 'previsualiserArticleParId']);
$routeur->post('/admin/articles/enregistrer',  [AdminController::class, 'enregistrerArticle']);
$routeur->post('/admin/articles/previsualiser',[AdminController::class, 'previsualiserArticle']);
$routeur->post('/admin/articles/basculer',     [AdminController::class, 'basculerArticle']);
$routeur->post('/admin/articles/supprimer',    [AdminController::class, 'supprimerArticle']);
$routeur->post('/admin/articles/televerser',   [AdminController::class, 'televerserImage']);
$routeur->get('/admin/commentaires',           [AdminController::class, 'commentaires']);
$routeur->post('/admin/commentaires/valider',  [AdminController::class, 'validerCommentaire']);
$routeur->post('/admin/commentaires/supprimer',[AdminController::class, 'supprimerCommentaire']);
$routeur->get('/admin/temoignages',             [AdminController::class, 'temoignages']);
$routeur->get('/admin/temoignages/{id}',        [AdminController::class, 'editerTemoignage']);
$routeur->post('/admin/temoignages/enregistrer',[AdminController::class, 'enregistrerTemoignage']);
$routeur->post('/admin/temoignages/supprimer',  [AdminController::class, 'supprimerTemoignage']);
$routeur->post('/admin/assistant/article',      [AdminController::class, 'assistantArticle']);
$routeur->post('/admin/assistant/temoignage',   [AdminController::class, 'assistantTemoignage']);
$routeur->get('/admin/audience',               [AdminController::class, 'audience']);

try {
    $routeur->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
} catch (\Throwable $erreur) {
    // Le visiteur ne voit jamais une trace d'exception : elle révèle des
    // chemins serveur et fait fuir un prospect plus sûrement qu'une erreur.
    error_log('[ea-services] ' . $erreur->getMessage() . ' @ ' . $erreur->getFile() . ':' . $erreur->getLine());
    http_response_code(500);
    echo '<!doctype html><meta charset="utf-8"><title>Erreur temporaire</title>'
       . '<div style="font-family:system-ui;max-width:32rem;margin:4rem auto;padding:0 1rem">'
       . '<h1>Une erreur temporaire est survenue</h1>'
       . '<p>Le problème a été enregistré. Écrivez-nous sur WhatsApp au '
       . htmlspecialchars((string)\EA\Core\Config::get('contact.telephone')) . '.</p>'
       . '<p><a href="/">Retour à l\'accueil</a></p></div>';
}
