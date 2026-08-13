<?php
declare(strict_types=1);

namespace EA\Core;

/** Jeton anti-falsification pour tous les envois de formulaire. */
final class Csrf
{
    public static function jeton(): string
    {
        Session::demarrer();
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function valide(?string $fourni): bool
    {
        Session::demarrer();
        $attendu = $_SESSION['csrf'] ?? '';
        return $attendu !== '' && is_string($fourni) && hash_equals($attendu, $fourni);
    }

    public static function champ(): string
    {
        return '<input type="hidden" name="csrf" value="' . htmlspecialchars(self::jeton(), ENT_QUOTES) . '">';
    }
}
