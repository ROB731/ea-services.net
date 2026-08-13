<?php
declare(strict_types=1);

namespace EA\Core;

/** Authentification de l'administration (un seul compte, table `users`). */
final class Auth
{
    public static function tenter(string $email, string $motDePasse): bool
    {
        $u = Database::un('SELECT id, email, password_hash FROM users WHERE email = ? LIMIT 1', [strtolower(trim($email))]);
        if (!$u || !password_verify($motDePasse, (string)$u['password_hash'])) {
            // Coût constant : on ne laisse pas le temps de réponse révéler
            // si l'adresse existe.
            password_verify($motDePasse, '$2y$12$' . str_repeat('x', 53));
            return false;
        }
        Session::demarrer();
        session_regenerate_id(true);
        $_SESSION['utilisateur_id'] = (int)$u['id'];
        $_SESSION['utilisateur_email'] = $u['email'];
        return true;
    }

    public static function connecte(): bool
    {
        Session::demarrer();
        return !empty($_SESSION['utilisateur_id']);
    }

    public static function utilisateur(): ?array
    {
        if (!self::connecte()) return null;
        return ['id' => $_SESSION['utilisateur_id'], 'email' => $_SESSION['utilisateur_email'] ?? ''];
    }

    public static function deconnecter(): void
    {
        Session::demarrer();
        $_SESSION = [];
        session_destroy();
    }

    public static function exiger(): void
    {
        if (!self::connecte()) {
            header('Location: /admin/connexion', true, 302);
            exit;
        }
    }
}
