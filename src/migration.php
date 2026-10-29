<?php
declare(strict_types=1);

/**
 * Migration de la base vers le nouveau site.
 *
 * Ne détruit rien : la base contient 6 articles publiés, 3 témoignages réels,
 * 4133 visites et le compte d'administration. Le script est rejouable sans
 * dommage (chaque étape vérifie l'état avant d'agir).
 *
 *   /opt/lampp/bin/php src/migration.php
 */

require __DIR__ . '/bootstrap.php';

use EA\Core\Database;

$pdo = Database::pdo();
$fait = [];

/** Ajoute une colonne si elle manque. */
function colonne(PDO $pdo, string $table, string $colonne, string $definition): bool
{
    $existantes = array_column($pdo->query("PRAGMA table_info($table)")->fetchAll(), 'name');
    if (in_array($colonne, $existantes, true)) return false;
    $pdo->exec("ALTER TABLE $table ADD COLUMN $colonne $definition");
    return true;
}

// 1. Modération des commentaires. Les commentaires déjà présents (aucun à ce
//    jour) sont considérés comme validés pour ne rien faire disparaître.
if (colonne($pdo, 'article_comments', 'published', 'INTEGER NOT NULL DEFAULT 0')) {
    $pdo->exec('UPDATE article_comments SET published = 1');
    $fait[] = 'article_comments.published ajoutée';
}

// 2. Classement des visites. La colonne permet de compter l'audience réelle
//    sans effacer l'historique brut.
if (colonne($pdo, 'visits', 'bot', 'INTEGER NOT NULL DEFAULT 0')) {
    $fait[] = 'visits.bot ajoutée';
}

// 3. Reclassement rétroactif : environ 1700 des 4133 lignes héritées sont des
//    scanners. Elles restent en base, marquées comme telles.
$scanners = "path LIKE '%wp-admin%' OR path LIKE '%wp-login%' OR path LIKE '%wp-json%'
          OR path LIKE '%wp-content%' OR path LIKE '%xmlrpc%'  OR path LIKE '%.env%'
          OR path LIKE '%.git%'      OR path LIKE '%phpmyadmin%' OR path LIKE '%/vendor/%'
          OR path LIKE '%.php'       OR path LIKE '%cgi-bin%'  OR path LIKE '%/backup%'
          OR user_agent LIKE '%bot%'    OR user_agent LIKE '%crawl%'
          OR user_agent LIKE '%spider%' OR user_agent LIKE '%curl%'
          OR user_agent LIKE '%python%' OR user_agent LIKE '%wget%'";
$n = $pdo->exec("UPDATE visits SET bot = 1 WHERE bot = 0 AND ($scanners)");
if ($n) $fait[] = "$n visites reclassées en robots";

// 4. Index. Sans eux, chaque page publique fait un parcours complet de table ;
//    avec 4133 visites ce n'est pas visible, ça le deviendra.
foreach ([
    'CREATE INDEX IF NOT EXISTS idx_articles_publies ON articles(published, created_at DESC)',
    'CREATE UNIQUE INDEX IF NOT EXISTS idx_articles_slug ON articles(slug)',
    'CREATE INDEX IF NOT EXISTS idx_commentaires_article ON article_comments(article_id, published)',
    'CREATE INDEX IF NOT EXISTS idx_visites_date ON visits(created_at)',
    'CREATE INDEX IF NOT EXISTS idx_visites_bot ON visits(bot, created_at)',
    'CREATE INDEX IF NOT EXISTS idx_messages_lus ON messages(read, created_at DESC)',
] as $sql) {
    $pdo->exec($sql);
}
$fait[] = 'index vérifiés';

// 5. Coordonnées réelles dans site_settings — la table servait à afficher des
//    valeurs fictives (« 225XXXXXXXXX ») en production.
$c = \EA\Core\Config::get('contact');
$pdo->prepare(
    'INSERT INTO site_settings (id, phone, email, address, whatsapp)
     VALUES (1, ?, ?, ?, ?)
     ON CONFLICT(id) DO UPDATE SET phone = excluded.phone, email = excluded.email,
                                   address = excluded.address, whatsapp = excluded.whatsapp'
)->execute([
    $c['telephone'],
    $c['email'],
    $c['quartier'] . ', ' . $c['ville'] . ', ' . $c['pays'],
    $c['whatsapp'],
]);
$fait[] = 'coordonnées réelles enregistrées';

// 6. Durée de lecture manquante sur d'anciens articles.
foreach ($pdo->query("SELECT id, content FROM articles WHERE read_time IS NULL OR read_time = ''")->fetchAll() as $a) {
    $pdo->prepare('UPDATE articles SET read_time = ? WHERE id = ?')
        ->execute([\EA\Core\Texte::dureeLecture((string)$a['content']), (int)$a['id']]);
    $fait[] = "durée de lecture calculée (article {$a['id']})";
}

// 7. Agent de conversation (chat, 2026-08-15). Deux tables : l'une compte les
//    CONVERSATIONS (pas les messages) par client pour la limite quotidienne,
//    l'autre garde le texte échangé — utile pour l'administration et pour
//    vérifier après coup que l'agent n'a rien promis qu'il ne fallait pas.
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS chat_conversations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        client_id TEXT NOT NULL,
        conversation_id TEXT NOT NULL,
        jour TEXT NOT NULL,
        cree_le TEXT NOT NULL,
        UNIQUE(client_id, conversation_id)
    )'
);
$pdo->exec('CREATE INDEX IF NOT EXISTS idx_chat_conv_client_jour ON chat_conversations(client_id, jour)');
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS chat_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        conversation_id TEXT NOT NULL,
        role TEXT NOT NULL,
        contenu TEXT NOT NULL,
        cree_le TEXT NOT NULL
    )'
);
$pdo->exec('CREATE INDEX IF NOT EXISTS idx_chat_msg_conv ON chat_messages(conversation_id, cree_le)');
$fait[] = 'tables chat_conversations / chat_messages vérifiées';

// 8. Tables du site marchand jamais utilisées (0 ligne chacune, aucun code ne
//    les lit). On les laisse en place : les supprimer ne gagne rien et
//    interdirait un retour en arrière. Signalé, pas exécuté.
$inutilisees = [];
foreach (['orders', 'order_items', 'products', 'product_images', 'gallery_items', 'categories', 'facebook_connection'] as $t) {
    $existe = $pdo->query("SELECT 1 FROM sqlite_master WHERE type='table' AND name='$t'")->fetchColumn();
    if ($existe && (int)$pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn() === 0) $inutilisees[] = $t;
}

// 9. Articles par section (2026-08-16) : chaque section porte son propre
//    texte et, si besoin, sa propre photo ou vidéo — un article n'est plus
//    obligé d'avoir toutes ses images regroupées en tête. Un article sans
//    section continue de fonctionner exactement comme avant (repli sur la
//    colonne `content`, voir ArticleController) : rien n'est cassé pour les
//    articles déjà publiés.
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS article_sections (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        article_id INTEGER NOT NULL,
        position INTEGER NOT NULL DEFAULT 0,
        heading TEXT,
        body TEXT,
        image_url TEXT,
        video_url TEXT,
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )'
);
$pdo->exec('CREATE INDEX IF NOT EXISTS idx_article_sections_article ON article_sections(article_id, position)');
$fait[] = 'table article_sections vérifiée';

echo "Migration terminée.\n";
foreach ($fait as $ligne) echo "  · $ligne\n";
if ($inutilisees) {
    echo "\nTables vides et non utilisées, conservées par précaution :\n  "
       . implode(', ', $inutilisees) . "\n";
}

$humaines = $pdo->query('SELECT COUNT(*) FROM visits WHERE bot = 0')->fetchColumn();
$robots   = $pdo->query('SELECT COUNT(*) FROM visits WHERE bot = 1')->fetchColumn();
echo "\nAudience : $humaines visites humaines, $robots requêtes de robots.\n";
