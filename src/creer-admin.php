<?php
declare(strict_types=1);

/**
 * Crée (ou remplace le mot de passe de) l'unique compte d'administration.
 * Le mot de passe est saisi au clavier : il n'est jamais passé en argument,
 * donc jamais écrit dans l'historique du terminal.
 *
 *   php src/creer-admin.php vous@exemple.com
 */

if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

require __DIR__ . '/bootstrap.php';

use EA\Core\Database;

$email = strtolower(trim($argv[1] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Usage : php src/creer-admin.php adresse@exemple.com\n");
    exit(1);
}

if (function_exists('posix_isatty') && posix_isatty(STDIN)) system('stty -echo');
echo "Mot de passe (12 caractères minimum) : ";
$mdp = trim((string)fgets(STDIN));
echo "\nRépéter : ";
$mdp2 = trim((string)fgets(STDIN));
if (function_exists('posix_isatty') && posix_isatty(STDIN)) system('stty echo');
echo "\n";

if ($mdp !== $mdp2 || strlen($mdp) < 12) {
    fwrite(STDERR, "Les mots de passe diffèrent ou font moins de 12 caractères.\n");
    exit(1);
}

$hash = password_hash($mdp, PASSWORD_DEFAULT);
Database::executer('DELETE FROM users');   // un seul compte sur ce site
Database::executer(
    'INSERT INTO users (email, password_hash, created_at) VALUES (?, ?, ?)',
    [$email, $hash, date('Y-m-d H:i:s')]
);
echo "Compte administrateur enregistré pour $email\n";
