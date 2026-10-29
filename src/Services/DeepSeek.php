<?php
declare(strict_types=1);

namespace EA\Services;

/**
 * Client DeepSeek (API compatible OpenAI).
 *
 * La clé vit dans config/secrets.php, jamais versionné, jamais envoyé au
 * navigateur — cette classe est la SEULE à la lire, et l'appel HTTP part du
 * serveur, jamais du JavaScript. Un widget de discussion qui appellerait
 * l'API directement depuis le navigateur exposerait la clé à quiconque
 * ouvre l'inspecteur du navigateur.
 */
final class DeepSeek
{
    private const URL = 'https://api.deepseek.com/chat/completions';
    private const MODELE = 'deepseek-chat';

    /**
     * @param array<int,array{role:string,content:string}> $messages
     * @param int $maxTokens Plafond de longueur — une réponse de réceptionniste (défaut)
     *                       n'a pas le même besoin qu'un brouillon d'article.
     * @param float $temperature Sobre par défaut : on guide, on n'improvise pas.
     * @return array{ok:bool,texte:string}
     */
    public static function repondre(array $messages, int $maxTokens = 400, float $temperature = 0.4): array
    {
        $cle = self::cle();
        if ($cle === null) {
            return ['ok' => false, 'texte' => "L'assistant n'est pas configuré."];
        }

        $ch = curl_init(self::URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_TIMEOUT        => 45,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $cle,
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model'       => self::MODELE,
                'messages'    => $messages,
                'temperature' => $temperature,
                'max_tokens'  => $maxTokens,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        $reponse = curl_exec($ch);
        $code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $erreur  = curl_error($ch);
        curl_close($ch);

        if ($reponse === false || $erreur !== '') {
            error_log('[ea-services] DeepSeek — échec réseau : ' . $erreur);
            return ['ok' => false, 'texte' => "Une erreur de connexion est survenue."];
        }
        if ($code !== 200) {
            error_log("[ea-services] DeepSeek — HTTP $code : " . substr((string)$reponse, 0, 500));
            return ['ok' => false, 'texte' => "L'assistant est momentanément indisponible."];
        }

        $donnees = json_decode((string)$reponse, true);
        $texte   = $donnees['choices'][0]['message']['content'] ?? null;
        if (!is_string($texte) || trim($texte) === '') {
            error_log('[ea-services] DeepSeek — réponse inattendue : ' . substr((string)$reponse, 0, 500));
            return ['ok' => false, 'texte' => "L'assistant n'a pas pu répondre, réessayez."];
        }

        return ['ok' => true, 'texte' => trim($texte)];
    }

    private static function cle(): ?string
    {
        $chemin = dirname(__DIR__, 2) . '/config/secrets.php';
        if (!is_file($chemin)) return null;
        $secrets = require $chemin;
        $cle = $secrets['deepseek_api_key'] ?? null;
        return is_string($cle) && $cle !== '' ? $cle : null;
    }
}
