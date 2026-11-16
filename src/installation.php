<?php
declare(strict_types=1);

/**
 * Création d'une base NEUVE (2026-11-16).
 *
 * La base d'origine a été perdue avec l'ancien serveur ; ce schéma a été
 * reconstruit d'après les requêtes du code, pas copié depuis l'original.
 * Rejouable sans dommage : tout est en `IF NOT EXISTS`, aucune donnée n'est
 * jamais supprimée. À lancer AVANT src/migration.php.
 *
 *   php src/installation.php
 *   php src/migration.php
 *   php src/creer-admin.php
 */

if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

require __DIR__ . '/bootstrap.php';

use EA\Core\Database;

$pdo = Database::pdo();

$tables = [
    'users' => 'CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        created_at TEXT
    )',
    'articles' => 'CREATE TABLE IF NOT EXISTS articles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL,
        excerpt TEXT,
        content TEXT,
        category TEXT,
        category_label TEXT,
        image_url TEXT,
        read_time TEXT,
        published INTEGER NOT NULL DEFAULT 0,
        generated_by_ai INTEGER NOT NULL DEFAULT 0,
        created_at TEXT NOT NULL
    )',
    'article_sections' => 'CREATE TABLE IF NOT EXISTS article_sections (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        article_id INTEGER NOT NULL,
        position INTEGER NOT NULL DEFAULT 0,
        heading TEXT,
        body TEXT,
        image_url TEXT,
        video_url TEXT,
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )',
    'article_comments' => 'CREATE TABLE IF NOT EXISTS article_comments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        article_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        comment TEXT NOT NULL,
        published INTEGER NOT NULL DEFAULT 0,
        created_at TEXT NOT NULL,
        FOREIGN KEY (article_id) REFERENCES articles(id)
    )',
    'testimonials' => 'CREATE TABLE IF NOT EXISTS testimonials (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        comment TEXT NOT NULL,
        rating INTEGER NOT NULL DEFAULT 5,
        created_at TEXT
    )',
    'messages' => 'CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        type TEXT,
        payload_json TEXT,
        read INTEGER NOT NULL DEFAULT 0,
        notified INTEGER NOT NULL DEFAULT 0,
        created_at TEXT NOT NULL
    )',
    'visits' => 'CREATE TABLE IF NOT EXISTS visits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        path TEXT,
        ip TEXT,
        user_agent TEXT,
        referrer TEXT,
        bot INTEGER NOT NULL DEFAULT 0,
        humain INTEGER NOT NULL DEFAULT 0,
        created_at TEXT NOT NULL
    )',
    'site_settings' => 'CREATE TABLE IF NOT EXISTS site_settings (
        id INTEGER PRIMARY KEY,
        phone TEXT,
        email TEXT,
        address TEXT,
        whatsapp TEXT
    )',
    'chat_conversations' => 'CREATE TABLE IF NOT EXISTS chat_conversations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        client_id TEXT NOT NULL,
        conversation_id TEXT NOT NULL,
        jour TEXT NOT NULL,
        cree_le TEXT NOT NULL,
        UNIQUE(client_id, conversation_id)
    )',
    'chat_messages' => 'CREATE TABLE IF NOT EXISTS chat_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        conversation_id TEXT NOT NULL,
        role TEXT NOT NULL,
        contenu TEXT NOT NULL,
        cree_le TEXT NOT NULL
    )',
];

foreach ($tables as $nom => $sql) {
    $pdo->exec($sql);
    echo "  · table $nom vérifiée\n";
}

echo "\nBase prête : " . dirname(__DIR__) . "/data/site.sqlite\n";
echo "Étape suivante : php src/migration.php, puis php src/creer-admin.php\n";
