<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Auth;
use EA\Core\Config;
use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Database;
use EA\Core\Texte;
use EA\Core\Vue;
use EA\Services\DeepSeek;

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
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/demandes');
    }

    public function supprimerDemande(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM messages WHERE id = ?', [(int)$this->champ('id')]);
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/demandes');
    }

    // --------------------------------------------------------------- articles

    public function articles(): string
    {
        return $this->admin('admin/articles', [
            'onglet'   => 'articles',
            'articles' => Database::tous('SELECT id, title, slug, category_label, published, created_at FROM articles ORDER BY datetime(created_at) DESC'),
            'edite'    => null,
            'sections' => [],
        ]);
    }

    public function editerArticle(string $id): string
    {
        return $this->admin('admin/articles', [
            'onglet'   => 'articles',
            'articles' => Database::tous('SELECT id, title, slug, category_label, published, created_at FROM articles ORDER BY datetime(created_at) DESC'),
            'edite'    => Database::un('SELECT * FROM articles WHERE id = ?', [(int)$id]),
            'sections' => Database::tous('SELECT * FROM article_sections WHERE article_id = ? ORDER BY position', [(int)$id]),
        ]);
    }

    public function enregistrerArticle(): string
    {
        $this->verifierJeton();

        $id       = (int)$this->champ('id');
        $titre    = mb_substr($this->champ('titre'), 0, 200);
        $contenu  = $this->champ('contenu');
        $sections = $this->nettoyerSections(is_array($_POST['sections'] ?? null) ? $_POST['sections'] : []);

        // Un article peut être écrit soit en texte simple (contenu), soit en
        // sections (avec photos/vidéos), soit les deux — mais pas ni l'un ni
        // l'autre : il n'y aurait rien à publier.
        if ($titre === '' || ($contenu === '' && !$sections)) {
            $this->rediriger('/admin/articles');
        }

        // Le résumé et la durée de lecture se calculent sur ce qu'il y a de
        // texte, qu'il vienne du contenu simple ou des sections.
        $texteReference = $contenu !== '' ? $contenu : implode("\n\n", array_column($sections, 'body'));
        $extrait  = $this->champ('extrait') ?: Texte::extrait($texteReference);
        $etiquette= mb_substr($this->champ('categorie'), 0, 40) ?: 'ANALYSE';
        $image    = mb_substr($this->champ('image'), 0, 500);
        $duree    = Texte::dureeLecture($texteReference);
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
            $id = (int)Database::pdo()->lastInsertId();
        }

        // Repli simple : les sections remplacées à chaque enregistrement,
        // plutôt que fusionnées — un seul admin à la fois sur ce site, pas
        // de risque d'écraser le travail de quelqu'un d'autre entre-temps.
        Database::executer('DELETE FROM article_sections WHERE article_id = ?', [$id]);
        foreach ($sections as $position => $s) {
            Database::executer(
                'INSERT INTO article_sections (article_id, position, heading, body, image_url, video_url)
                 VALUES (?, ?, ?, ?, ?, ?)',
                [$id, $position, $s['heading'], $s['body'], $s['image_url'], $s['video_url']]
            );
        }

        $this->rediriger('/admin/articles');
    }

    /**
     * Aperçu d'un article EN COURS D'ÉDITION, avant tout enregistrement.
     * Le formulaire pointe ici via `formaction`/`formtarget="_blank"` : les
     * mêmes champs que enregistrerArticle(), mais rien n'est écrit en base —
     * seule la page publique est rendue avec ces valeurs, dans un nouvel
     * onglet, pour se relire dans les conditions réelles avant de publier.
     */
    public function previsualiserArticle(): string
    {
        $this->verifierJeton();

        $titre    = mb_substr($this->champ('titre'), 0, 200);
        $contenu  = $this->champ('contenu');
        $sections = $this->nettoyerSections(is_array($_POST['sections'] ?? null) ? $_POST['sections'] : []);
        $texteReference = $contenu !== '' ? $contenu : implode("\n\n", array_column($sections, 'body'));
        $extrait  = mb_substr($this->champ('extrait'), 0, 300) ?: Texte::extrait($texteReference);

        $article = [
            'id'             => 0,
            'title'          => $titre !== '' ? $titre : 'Aperçu sans titre',
            'slug'           => 'apercu',
            'excerpt'        => $extrait,
            'content'        => $contenu,
            'content_html'   => Texte::enHtml($contenu),
            'category_label' => mb_substr($this->champ('categorie'), 0, 40) ?: 'ANALYSE',
            'image_url'      => mb_substr($this->champ('image'), 0, 500),
            'read_time'      => Texte::dureeLecture($texteReference),
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $sectionsRendues = [];
        foreach ($sections as $s) {
            $sectionsRendues[] = $s + [
                'body_html' => Texte::enHtml($s['body']),
                'video_src' => Texte::urlIntegrationVideo($s['video_url'] ?: null),
            ];
        }

        return $this->rendreApercu($article, $sectionsRendues);
    }

    /**
     * Aperçu d'un article déjà enregistré (publié ou brouillon), depuis la
     * liste — utile pour relire un brouillon exactement comme un visiteur le
     * verrait, sans le publier d'abord pour vérifier.
     */
    public function previsualiserArticleParId(string $id): string
    {
        $article = Database::un('SELECT * FROM articles WHERE id = ?', [(int)$id]);
        if (!$article) {
            http_response_code(404);
            return 'Article introuvable.';
        }
        $article['content_html'] = Texte::enHtml((string)$article['content']);

        $sections = Database::tous(
            'SELECT * FROM article_sections WHERE article_id = ? ORDER BY position',
            [(int)$article['id']]
        );
        foreach ($sections as &$section) {
            $section['body_html'] = Texte::enHtml((string)$section['body']);
            $section['video_src'] = Texte::urlIntegrationVideo($section['video_url'] ?: null);
        }
        unset($section);

        return $this->rendreApercu($article, $sections);
    }

    private function rendreApercu(array $article, array $sections): string
    {
        Vue::meta([
            'titre'       => $article['title'] . ' — Aperçu | EA-SERVICES',
            'description' => Texte::extrait((string)($article['excerpt'] ?: $article['content'])),
            'canonical'   => '/admin/articles',
            'robots'      => 'noindex, nofollow',
        ]);
        echo Vue::rendre('blog/article-v2', [
            'article'            => $article,
            'sections'           => $sections,
            'commentaires'       => [],
            'suggestions'        => [],
            'etatCommentaire'    => null,
            'messageCommentaire' => null,
            'apercu'             => true,
        ], 'layouts/public-v2');
        return '';
    }

    /** @return array<int,array{heading:string,body:string,image_url:string,video_url:string}> */
    private function nettoyerSections(array $brutes): array
    {
        $sections = [];
        foreach ($brutes as $s) {
            $titre = trim((string)($s['heading'] ?? ''));
            $corps = trim((string)($s['body'] ?? ''));
            $image = trim((string)($s['image'] ?? ''));
            $video = trim((string)($s['video'] ?? ''));
            if ($titre === '' && $corps === '' && $image === '' && $video === '') continue;
            $sections[] = [
                'heading'   => mb_substr($titre, 0, 200),
                'body'      => mb_substr($corps, 0, 4000),
                'image_url' => mb_substr($image, 0, 500),
                'video_url' => mb_substr($video, 0, 500),
            ];
        }
        return $sections;
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
        $id = (int)$this->champ('id');
        Database::executer('UPDATE articles SET published = 1 - published WHERE id = ?', [$id]);
        if ($this->veutJson()) {
            $publie = (int)Database::valeur('SELECT published FROM articles WHERE id = ?', [$id]);
            return $this->json(['ok' => true, 'publie' => $publie === 1]);
        }
        $this->rediriger('/admin/articles');
    }

    public function supprimerArticle(): string
    {
        $this->verifierJeton();
        $id = (int)$this->champ('id');
        Database::executer('DELETE FROM article_comments WHERE article_id = ?', [$id]);
        Database::executer('DELETE FROM article_sections WHERE article_id = ?', [$id]);
        Database::executer('DELETE FROM articles WHERE id = ?', [$id]);
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/articles');
    }

    /**
     * Téléversement d'une image (couverture d'article ou photo de section)
     * depuis l'appareil. Ne fait JAMAIS confiance au nom ni à l'extension
     * envoyés par le navigateur : seul le contenu réel du fichier, vérifié
     * par `getimagesize()`, décide de l'extension écrite sur le disque —
     * c'est ce qui empêche de déposer un script déguisé en image.
     */
    public function televerserImage(): string
    {
        $this->verifierJeton();

        $fichier = $_FILES['fichier'] ?? null;
        if (!is_array($fichier) || ($fichier['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return $this->json(['ok' => false, 'erreur' => "Aucune image reçue."], 422);
        }
        if ((int)$fichier['size'] > 5 * 1024 * 1024) {
            return $this->json(['ok' => false, 'erreur' => "Image trop lourde (5 Mo maximum)."], 422);
        }

        $infos = @getimagesize($fichier['tmp_name']);
        $extensions = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_WEBP => 'webp',
            IMAGETYPE_GIF  => 'gif',
        ];
        if ($infos === false || !isset($extensions[$infos[2]])) {
            return $this->json(['ok' => false, 'erreur' => "Le fichier n'est pas une image valide (JPG, PNG, WEBP ou GIF)."], 422);
        }

        $annee   = date('Y');
        $dossier = dirname(__DIR__, 2) . '/public/uploads/articles/' . $annee;
        if (!is_dir($dossier) && !mkdir($dossier, 0775, true) && !is_dir($dossier)) {
            return $this->json(['ok' => false, 'erreur' => "Impossible d'enregistrer l'image."], 500);
        }

        // Une « photographie éditoriale réaliste » proposée par un générateur
        // d'IA (voir le prompt d'image de l'assistant) sort souvent en PNG de
        // plusieurs mégaoctets — inutilement lourd sur le marché ivoirien,
        // massivement mobile : ça se traduit par une image qui met une
        // éternité à s'afficher, voire jamais sur une connexion lente. On
        // redimensionne et recompresse en JPEG avant d'écrire sur le disque.
        // Le GIF est laissé tel quel (potentiellement animé — GD le
        // réécrirait sur une seule image et casserait l'animation).
        $nom = bin2hex(random_bytes(12));
        if ($infos[2] !== IMAGETYPE_GIF && $this->optimiserImage($fichier['tmp_name'], $infos[2], $dossier . '/' . $nom . '.jpg')) {
            $nomFichier = $nom . '.jpg';
        } else {
            $nomFichier = $nom . '.' . $extensions[$infos[2]];
            if (!move_uploaded_file($fichier['tmp_name'], $dossier . '/' . $nomFichier)) {
                return $this->json(['ok' => false, 'erreur' => "Impossible d'enregistrer l'image."], 500);
            }
        }

        return $this->json(['ok' => true, 'url' => '/uploads/articles/' . $annee . '/' . $nomFichier]);
    }

    /**
     * Redimensionne (1600 px de large maximum, l'article n'affiche jamais
     * plus large que ça) et recompresse en JPEG qualité 82 — largement
     * suffisant pour une photo éditoriale, sans le poids inutile d'un PNG.
     * Lit le fichier temporaire d'upload directement (déjà validé par
     * getimagesize plus haut), jamais l'extension déclarée par le navigateur.
     */
    private function optimiserImage(string $source, int $type, string $cible): bool
    {
        $image = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($source),
            IMAGETYPE_PNG  => @imagecreatefrompng($source),
            IMAGETYPE_WEBP => @imagecreatefromwebp($source),
            default        => false,
        };
        if ($image === false) return false;

        $largeur = imagesx($image);
        $hauteur = imagesy($image);
        $largeurFinale = min($largeur, 1600);
        $hauteurFinale = (int)round($hauteur * ($largeurFinale / $largeur));

        $toile = imagecreatetruecolor($largeurFinale, $hauteurFinale);
        // Fond blanc avant la copie : un PNG transparent recompressé en JPEG
        // (qui ne connaît pas la transparence) afficherait du noir sinon.
        imagefill($toile, 0, 0, (int)imagecolorallocate($toile, 255, 255, 255));
        imagecopyresampled($toile, $image, 0, 0, 0, 0, $largeurFinale, $hauteurFinale, $largeur, $hauteur);
        imagedestroy($image);

        $ok = imagejpeg($toile, $cible, 82);
        imagedestroy($toile);
        return $ok;
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
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/commentaires');
    }

    public function supprimerCommentaire(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM article_comments WHERE id = ?', [(int)$this->champ('id')]);
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/commentaires');
    }

    // ------------------------------------------------------------ témoignages

    public function temoignages(): string
    {
        return $this->admin('admin/temoignages', [
            'onglet' => 'temoignages',
            'temoignages' => Database::tous('SELECT * FROM testimonials ORDER BY id DESC'),
            'edite' => null,
        ]);
    }

    public function editerTemoignage(string $id): string
    {
        return $this->admin('admin/temoignages', [
            'onglet' => 'temoignages',
            'temoignages' => Database::tous('SELECT * FROM testimonials ORDER BY id DESC'),
            'edite' => Database::un('SELECT * FROM testimonials WHERE id = ?', [(int)$id]),
        ]);
    }

    public function enregistrerTemoignage(): string
    {
        $this->verifierJeton();
        $id   = (int)$this->champ('id');
        $nom  = mb_substr($this->champ('nom'), 0, 120);
        $avis = mb_substr($this->champ('avis'), 0, 1000);
        $note = max(1, min(5, (int)$this->champ('note')));

        if ($nom === '' || $avis === '') {
            if ($this->veutJson()) {
                return $this->json(['ok' => false, 'erreur' => 'Le nom et l\'avis sont obligatoires.'], 422);
            }
            $this->rediriger('/admin/temoignages');
        }

        if ($id > 0) {
            // Corriger une faute de frappe ou une note reste possible : le
            // témoignage reste réel, seule sa transcription est corrigée.
            Database::executer(
                'UPDATE testimonials SET name = ?, comment = ?, rating = ? WHERE id = ?',
                [$nom, $avis, $note, $id]
            );
        } else {
            Database::executer(
                'INSERT INTO testimonials (name, comment, rating, created_at) VALUES (?, ?, ?, ?)',
                [$nom, $avis, $note, date('Y-m-d H:i:s')]
            );
            $id = (int)Database::pdo()->lastInsertId();
        }

        if ($this->veutJson()) {
            return $this->json([
                'ok' => true,
                'temoignage' => ['id' => $id, 'name' => $nom, 'comment' => $avis, 'rating' => $note],
            ]);
        }
        $this->rediriger('/admin/temoignages');
    }

    public function supprimerTemoignage(): string
    {
        $this->verifierJeton();
        Database::executer('DELETE FROM testimonials WHERE id = ?', [(int)$this->champ('id')]);
        if ($this->veutJson()) return $this->json(['ok' => true]);
        $this->rediriger('/admin/temoignages');
    }

    // --------------------------------------------------------------- assistant
    /*
     * Un assistant d'écriture, pas un générateur de contenu final : chaque
     * réponse arrive en BROUILLON dans le formulaire, jamais publiée toute
     * seule (voir enregistrerArticle) ou enregistrée toute seule (voir
     * enregistrerTemoignage) — le dirigeant relit et corrige avant.
     *
     * INTÉGRITÉ — même règle absolue que partout ailleurs sur ce dépôt :
     * pour un article, le prompt interdit d'inventer un chiffre, un client
     * ou un cas ; pour un témoignage, l'assistant ne fait QUE corriger
     * l'orthographe d'un texte réel déjà collé par le dirigeant — il ne
     * reçoit jamais l'instruction ni la possibilité d'inventer un avis.
     */

    public function assistantArticle(): string
    {
        $this->verifierJeton();
        $sujet  = mb_substr($this->champ('sujet'), 0, 200);
        $points = mb_substr($this->champ('points'), 0, 2000);

        if ($sujet === '') {
            return $this->json(['ok' => false, 'erreur' => "Indiquez d'abord un sujet."], 422);
        }

        $demande = "Sujet : {$sujet}";
        if ($points !== '') $demande .= "\nPoints à couvrir :\n{$points}";

        $reponse = DeepSeek::repondre([
            ['role' => 'system', 'content' => $this->promptAssistantArticle()],
            ['role' => 'user', 'content' => $demande],
        ], 2600, 0.6);

        if (!$reponse['ok']) {
            return $this->json(['ok' => false, 'erreur' => $reponse['texte']], 502);
        }
        return $this->json(['ok' => true, 'article' => $this->analyserBrouillonArticle($reponse['texte'])]);
    }

    private function promptAssistantArticle(): string
    {
        $lignes = [];
        foreach ((array)Config::get('gains', []) as $gain) {
            $lignes[] = '- ' . $gain['titre'] . ' : ' . $gain['impact'];
        }
        $gainsTexte = implode("\n", $lignes);

        return "Tu aides le dirigeant d'EA-SERVICES (agence à Abidjan : développement, automatisation, "
             . "IA, formation, coaching) à préparer un BROUILLON d'article de blog qu'il relira et corrigera "
             . "lui-même avant publication.\n\n"
             . "Doctrine à respecter strictement :\n"
             . "- On ne vend pas des fonctionnalités, on vend des résultats mesurables. L'article part d'une "
             . "perte concrète que le lecteur subit, puis montre le gain.\n"
             . "- N'INVENTE JAMAIS un chiffre précis, un nom de client, d'entreprise, ou un cas vécu. Si un "
             . "exemple chiffré rendrait le propos plus fort, écris littéralement "
             . "« [EXEMPLE À COMPLÉTER PAR LE DIRIGEANT] » au lieu d'improviser une preuve.\n"
             . "- Tu peux t'appuyer sur ces promesses déjà publiées par la marque, ce sont les seuls chiffres "
             . "à réutiliser tels quels :\n{$gainsTexte}\n"
             . "- Ton simple et concret, pour un dirigeant de PME ivoirienne. Aucun jargon technique visible "
             . "(pas de « API », « backend », « CRM », « dashboard »…).\n"
             . "- Termine sur l'appel à l'action du site : le diagnostic gratuit de 30 minutes.\n\n"
             . "Mise en forme du corps (respecte exactement ces conventions, ce sont celles du site) :\n"
             . "une ligne vide sépare deux paragraphes ; un tiret en début de ligne fait une puce de liste ; "
             . "**le texte entre deux étoiles** est mis en gras.\n\n"
             . "L'article est structuré en SECTIONS (une par idée ou étape), parce que le dirigeant "
             . "pourra ensuite accrocher une image (et, s'il en a une, une vraie vidéo) à chacune depuis "
             . "l'administration. Tu ne fournis JAMAIS l'image toi-même — mais pour chaque section, tu es "
             . "un expert du prompt engineering pour la génération d'images (ChatGPT/DALL·E) : rédige un "
             . "PROMPT D'IMAGE complet, prêt à être collé tel quel dans un générateur, pour que le dirigeant "
             . "n'ait plus qu'à copier-coller. Jamais la photo d'une vraie personne, d'un vrai client ou "
             . "d'une entreprise nommée — toujours une scène générique et crédible pour une PME ivoirienne. "
             . "Ce prompt (en français, sur UNE SEULE LIGNE) précise : le sujet et l'action, le cadrage, la "
             . "lumière, le style (photographie éditoriale réaliste, format 16:9, aucun texte ni logo dans "
             . "l'image), et la palette de marque en touches discrètes — bleu marine profond (#112849) et "
             . "or/safran (#f2b62b) sur un vêtement, un objet ou un accent lumineux, sans forcer un décor "
             . "irréaliste. Exemple : « Photographie éditoriale réaliste, format 16:9 : une commerçante "
             . "ivoirienne dans la trentaine, sourire confiant, consulte son téléphone derrière son comptoir "
             . "à Abidjan ; un accent or/safran discret sur un objet du comptoir ; lumière naturelle douce, "
             . "faible profondeur de champ, aucun texte ni logo visible. »\n\n"
             . "Réponds EXACTEMENT dans ce format, rien avant, rien après :\n"
             . "### TITRE\n<titre accrocheur, orienté bénéfice>\n"
             . "### ETIQUETTE\n<un mot-clé court en MAJUSCULES, ex: AUTOMATISATION>\n"
             . "### RESUME\n<1 à 2 phrases, sert aussi de méta-description Google>\n"
             . "### SECTION\n<intertitre court de cette partie>\n~~~\n<texte de cette partie, un ou deux paragraphes>\n~~~\n"
             . "PROMPT_IMAGE: <prompt complet, prêt à coller, une seule ligne>\n"
             . "VIDEO: <une idée de vidéo si ça aiderait vraiment cette section, sinon écris \"aucune\">\n"
             . "(Répète le bloc ### SECTION / ~~~ / ~~~ pour chaque partie : 3 à 5 sections au total, "
             . "chacune une idée ou une étape distincte.)";
    }

    /**
     * @return array{titre:string,categorie:string,extrait:string,contenu:string,
     *               sections:array<int,array{heading:string,body:string,image_prompt:string,video_suggestion:string}>}
     */
    private function analyserBrouillonArticle(string $texte): array
    {
        $entete   = ['TITRE' => '', 'ETIQUETTE' => '', 'RESUME' => ''];
        $sections = [];

        $motif = '/###\s*(TITRE|ETIQUETTE|RESUME|SECTION)\s*\n(.*?)(?=###\s*(?:TITRE|ETIQUETTE|RESUME|SECTION)\s*\n|\z)/su';
        if (preg_match_all($motif, $texte, $blocs, PREG_SET_ORDER)) {
            foreach ($blocs as $bloc) {
                $contenu = trim($bloc[2]);
                if ($bloc[1] === 'SECTION') {
                    // Format demandé : "intertitre\n~~~\ntexte\n~~~\nPHOTO: …\nVIDEO: …".
                    // Le modèle ajoute parfois un ~~~ de plus entre deux
                    // paragraphes du texte : on ne suppose donc pas une
                    // position fixe. Le premier bloc est toujours l'intertitre,
                    // le dernier n'est des suggestions QUE s'il contient
                    // vraiment "PHOTO" ou "VIDEO" — tout ce qui reste entre les
                    // deux est rejoint et devient le corps, rien n'est perdu.
                    $parties = preg_split('/\n~~~\n/', $contenu) ?: [$contenu];
                    $corps = $parties;
                    $titreSection = count($corps) > 1 ? trim(array_shift($corps)) : '';

                    $prompt = '';
                    $video = '';
                    $dernier = end($corps);
                    if ($dernier !== false && preg_match('/\b(PROMPT_IMAGE|VIDEO)\s*:/iu', $dernier)) {
                        $suggestions = array_pop($corps);
                        if (preg_match('/PROMPT_IMAGE\s*:\s*(.+)/iu', $suggestions, $mp)) $prompt = trim($mp[1]);
                        if (preg_match('/VIDEO\s*:\s*(.+)/iu', $suggestions, $mv)) $video = trim($mv[1]);
                        if (mb_strtolower($video) === 'aucune') $video = '';
                    }

                    $sections[] = [
                        'heading'          => $titreSection,
                        'body'             => trim(implode("\n\n", array_map('trim', $corps))),
                        'image_prompt'     => mb_substr($prompt, 0, 600),
                        'video_suggestion' => mb_substr($video, 0, 200),
                    ];
                } elseif ($entete[$bloc[1]] === '') {
                    $entete[$bloc[1]] = $contenu;
                }
            }
        }

        return [
            'titre'     => $entete['TITRE'],
            'categorie' => $entete['ETIQUETTE'],
            'extrait'   => $entete['RESUME'],
            'sections'  => $sections,
            // Repli : le modèle n'a suivi aucun format connu — on garde quand
            // même tout comme contenu simple plutôt que de perdre le travail.
            'contenu'   => $sections ? '' : trim($texte),
        ];
    }

    public function assistantTemoignage(): string
    {
        $this->verifierJeton();
        $texte = mb_substr(trim($this->champ('texte')), 0, 1000);

        if ($texte === '') {
            return $this->json(['ok' => false, 'erreur' => "Collez d'abord le texte réel du client."], 422);
        }

        $reponse = DeepSeek::repondre([
            ['role' => 'system', 'content' =>
                "Tu corriges UNIQUEMENT l'orthographe, la ponctuation et les majuscules d'un témoignage "
                . "client réel. Ne change le sens d'aucun mot, ne reformule rien, n'ajoute rien, ne "
                . "raccourcis rien, ne rends pas le ton plus « professionnel ». Si le texte est déjà correct, "
                . "renvoie-le à l'identique. Réponds uniquement avec le texte corrigé, sans aucun commentaire "
                . "ni guillemet autour."],
            ['role' => 'user', 'content' => $texte],
        ], 600, 0.1);

        if (!$reponse['ok']) {
            return $this->json(['ok' => false, 'erreur' => $reponse['texte']], 502);
        }
        return $this->json(['ok' => true, 'texte' => $reponse['texte']]);
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
            'confirmees' => (int)Database::valeur('SELECT COUNT(*) FROM visits WHERE humain = 1 AND date(created_at) >= ?', [$depuis]),
        ]);
    }
}
