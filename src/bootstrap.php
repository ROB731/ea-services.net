<?php
declare(strict_types=1);

/**
 * Amorçage : chargement automatique des classes et fonctions de vue.
 * Aucune dépendance externe, aucun gestionnaire de paquets.
 */

spl_autoload_register(static function (string $classe): void {
    if (!str_starts_with($classe, 'EA\\')) return;
    $chemin = __DIR__ . '/' . str_replace('\\', '/', substr($classe, 3)) . '.php';
    if (is_file($chemin)) require $chemin;
});

require __DIR__ . '/helpers.php';

// Les erreurs partent dans le journal, jamais à l'écran du visiteur : une
// trace d'exception affichée révèle des chemins serveur et fait fuir un
// prospect plus sûrement qu'une page vide.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', dirname(__DIR__) . '/storage/php-error.log');
error_reporting(E_ALL);
date_default_timezone_set('Africa/Abidjan');
