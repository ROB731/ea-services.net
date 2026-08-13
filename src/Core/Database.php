<?php
declare(strict_types=1);

namespace EA\Core;

use PDO;

/**
 * Connexion SQLite unique.
 *
 * Le fichier appartient à `daemon` (Apache LAMPP tourne en daemon) et le
 * dossier data/ doit rester inscriptible : SQLite écrit un `-journal` à côté
 * de la base, une base seule en écriture ne suffit pas.
 */
final class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            $chemin = dirname(__DIR__, 2) . '/data/site.sqlite';
            self::$pdo = new PDO('sqlite:' . $chemin, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
            // WAL : une écriture (visite, message) ne bloque plus les lectures
            // des autres visiteurs. Le site est massivement en lecture.
            self::$pdo->exec('PRAGMA journal_mode = WAL');
            self::$pdo->exec('PRAGMA busy_timeout = 3000');
        }
        return self::$pdo;
    }

    /** @return array<int,array<string,mixed>> */
    public static function tous(string $sql, array $params = []): array
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function un(string $sql, array $params = []): ?array
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public static function valeur(string $sql, array $params = []): mixed
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public static function executer(string $sql, array $params = []): int
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}
