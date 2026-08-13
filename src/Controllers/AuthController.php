<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Auth;
use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Session;
use EA\Core\Vue;

final class AuthController extends Controleur
{
    public function formulaire(string $erreur = ''): string
    {
        if (Auth::connecte()) $this->rediriger('/admin');
        header('Cache-Control: no-store, private');
        header('X-Robots-Tag: noindex, nofollow');
        return Vue::rendre('admin/connexion', ['erreur' => $erreur], null);
    }

    public function connecter(): string
    {
        Session::demarrer();

        if (!Csrf::valide($this->champ('csrf'))) {
            return $this->formulaire('Session expirée. Réessayez.');
        }

        // Limitation simple des tentatives : cinq essais, puis quinze minutes
        // d'attente. Suffisant pour rendre une attaque par dictionnaire
        // inintéressante sur un site à un seul compte.
        $essais = $_SESSION['essais'] ?? ['n' => 0, 'jusqu' => 0];
        if ($essais['n'] >= 5 && time() < $essais['jusqu']) {
            $reste = (int)ceil(($essais['jusqu'] - time()) / 60);
            return $this->formulaire("Trop de tentatives. Réessayez dans $reste minute" . ($reste > 1 ? 's' : '') . '.');
        }

        if (Auth::tenter($this->champ('email'), $this->champ('mot_de_passe'))) {
            unset($_SESSION['essais']);
            $this->rediriger('/admin');
        }

        $essais['n']++;
        $essais['jusqu'] = time() + 900;
        $_SESSION['essais'] = $essais;

        return $this->formulaire('Adresse ou mot de passe incorrect.');
    }

    public function deconnecter(): string
    {
        Auth::deconnecter();
        $this->rediriger('/admin/connexion');
    }
}
