<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Config;
use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Database;
use EA\Core\Visites;

/**
 * Demandes de diagnostic.
 *
 * Le formulaire répond aux deux cas : avec JavaScript il attend du JSON, sans
 * JavaScript il attend une page. Sur ce marché, le repli sans JavaScript
 * n'est pas théorique — un réseau lent suffit à faire échouer le script.
 */
final class ContactController extends Controleur
{
    public function envoyer(): string
    {
        $enJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

        $donnees = [
            'nom'        => mb_substr($this->champ('nom'), 0, 120),
            'entreprise' => mb_substr($this->champ('entreprise'), 0, 120),
            'telephone'  => mb_substr($this->champ('telephone'), 0, 40),
            'email'      => mb_substr($this->champ('email'), 0, 160),
            'besoin'     => mb_substr($this->champ('besoin'), 0, 4000),
        ];

        $erreur = $this->valider($donnees);

        // Piège à robots : on répond « merci » sans rien enregistrer, pour ne
        // pas apprendre au robot qu'il a été repéré.
        if ($this->champ('site') !== '') {
            return $this->repondre($enJson, true, $this->messageSucces(), $donnees);
        }

        if (!Csrf::valide($this->champ('csrf'))) {
            return $this->repondre($enJson, false,
                "Votre session a expiré. Rechargez la page et renvoyez le formulaire.", $donnees);
        }

        if ($erreur !== null) {
            return $this->repondre($enJson, false, $erreur, $donnees);
        }

        Database::executer(
            'INSERT INTO messages (type, payload_json, read, notified, created_at) VALUES (?, ?, 0, 0, ?)',
            [
                'diagnostic',
                json_encode($donnees + [
                    'ip'       => Visites::ip(),
                    'page'     => $_SERVER['HTTP_REFERER'] ?? null,
                ], JSON_UNESCAPED_UNICODE),
                date('Y-m-d H:i:s'),
            ]
        );

        $this->prevenirParCourriel($donnees);

        return $this->repondre($enJson, true, $this->messageSucces(), []);
    }

    private function messageSucces(): string
    {
        return "Merci, votre demande est bien arrivée. Nous vous rappelons sous 24 heures ouvrées. "
             . "Pour aller plus vite, écrivez-nous sur WhatsApp au " . Config::get('contact.telephone') . ".";
    }

    private function valider(array $d): ?string
    {
        if (mb_strlen($d['nom']) < 2) {
            return "Indiquez votre nom pour que nous sachions à qui nous adresser.";
        }
        // Le téléphone est le canal de rappel réel ici : il prime sur le courriel.
        $chiffres = preg_replace('/\D+/', '', $d['telephone']) ?? '';
        if (strlen($chiffres) < 8) {
            return "Indiquez un numéro de téléphone ou WhatsApp valide : c'est par là que nous vous répondrons.";
        }
        if ($d['email'] !== '' && !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
            return "L'adresse électronique saisie ne semble pas valide. Corrigez-la ou laissez le champ vide.";
        }
        if (mb_strlen($d['besoin']) < 10) {
            return "Décrivez en une ou deux phrases ce qui vous fait perdre du temps ou des clients.";
        }
        return null;
    }

    /**
     * Alerte par courriel. Best-effort : si l'envoi échoue, la demande est
     * déjà enregistrée en base et visible en administration — on ne perd
     * jamais un prospect à cause du serveur de messagerie.
     */
    private function prevenirParCourriel(array $d): void
    {
        try {
            $destinataire = (string)Config::get('contact.email');
            $sujet = 'Demande de diagnostic — ' . ($d['entreprise'] ?: $d['nom']);
            $corps = "Nouvelle demande depuis ea-services.net\n\n"
                   . "Nom        : {$d['nom']}\n"
                   . "Entreprise : " . ($d['entreprise'] ?: '—') . "\n"
                   . "Téléphone  : {$d['telephone']}\n"
                   . "Courriel   : " . ($d['email'] ?: '—') . "\n\n"
                   . "Besoin :\n{$d['besoin']}\n\n"
                   . "Reçue le " . date('d/m/Y à H:i') . "\n";
            $entetes = "From: EA-SERVICES <$destinataire>\r\n"
                     . ($d['email'] !== '' ? "Reply-To: {$d['email']}\r\n" : '')
                     . "Content-Type: text/plain; charset=UTF-8\r\n";
            @mail($destinataire, '=?UTF-8?B?' . base64_encode($sujet) . '?=', $corps, $entetes);
        } catch (\Throwable) {
            // La demande est en base : rien n'est perdu.
        }
    }

    private function repondre(bool $enJson, bool $ok, string $message, array $ancien): string
    {
        if ($enJson) {
            return $this->json(['ok' => $ok, 'message' => $message], $ok ? 200 : 422);
        }
        if (!$ok) http_response_code(422);

        return $this->page('pages/contact', [
            'etatEnvoi'    => $ok ? 'ok' : 'erreur',
            'messageEnvoi' => $message,
            'ancien'       => $ok ? [] : $ancien,
        ], [
            'titre'       => "Contact — diagnostic gratuit de 30 minutes | EA-SERVICES",
            'description' => "WhatsApp, téléphone ou formulaire : réservez votre diagnostic gratuit de 30 minutes. Réponse sous 2 heures. EA-SERVICES, Marcory Biétry, Abidjan.",
            'canonical'   => '/pages/contact',
            'robots'      => 'noindex, follow',
            'json_ld'     => Seo::blocsCommuns('contact'),
        ]);
    }
}
