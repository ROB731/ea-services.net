<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Config;
use EA\Core\Controleur;
use EA\Core\Database;
use EA\Core\Visites;
use EA\Services\DeepSeek;

/**
 * Agent de conversation.
 *
 * Rôle exact demandé : un accueil qui écoute le besoin du visiteur et le
 * dirige vers la bonne page — jamais un vendeur qui invente un prix ou une
 * promesse. Le cadrage vit dans promptSysteme() : ancré sur les chiffres
 * publiés (config/site.php), jamais improvisé.
 *
 * Limite : 5 CONVERSATIONS par client par jour (pas 5 messages — continuer
 * un même fil ne consomme pas un nouveau crédit). Le client est identifié
 * par un cookie, la conversation par un identifiant côté navigateur — voir
 * public/js/ea-v2.js.
 */
final class ChatController extends Controleur
{
    private const CONVERSATIONS_PAR_JOUR = 5;
    private const COOKIE_CLIENT = 'ea_chat_client';

    public function message(): string
    {
        $conversationId = mb_substr($this->champ('conversation_id'), 0, 64);
        $texte          = mb_substr($this->champ('message'), 0, 2000);

        if ($conversationId === '' || $texte === '') {
            return $this->json(['ok' => false, 'erreur' => "Message vide."], 422);
        }

        $clientId = $this->identifiantClient();
        $jour     = date('Y-m-d');

        $nouvelle = Database::valeur(
            'SELECT 1 FROM chat_conversations WHERE client_id = ? AND conversation_id = ?',
            [$clientId, $conversationId]
        ) === false;

        if ($nouvelle) {
            $count = (int)Database::valeur(
                'SELECT COUNT(*) FROM chat_conversations WHERE client_id = ? AND jour = ?',
                [$clientId, $jour]
            );
            if ($count >= self::CONVERSATIONS_PAR_JOUR) {
                return $this->json([
                    'ok'     => false,
                    'limite' => true,
                    'erreur' => "Vous avez atteint les " . self::CONVERSATIONS_PAR_JOUR . " échanges "
                              . "gratuits d'aujourd'hui avec l'assistant. Écrivez-nous directement sur "
                              . "WhatsApp, on vous répond aussi bien.",
                ], 429);
            }
            Database::executer(
                'INSERT INTO chat_conversations (client_id, conversation_id, jour, cree_le) VALUES (?, ?, ?, ?)',
                [$clientId, $conversationId, $jour, date('Y-m-d H:i:s')]
            );
        }

        $this->enregistrerMessage($conversationId, 'user', $texte);

        $historique = Database::tous(
            'SELECT role, contenu FROM chat_messages WHERE conversation_id = ? ORDER BY id ASC LIMIT 20',
            [$conversationId]
        );

        $messages = [['role' => 'system', 'content' => $this->promptSysteme()]];
        foreach ($historique as $ligne) {
            $messages[] = ['role' => $ligne['role'], 'content' => $ligne['contenu']];
        }

        $reponse = DeepSeek::repondre($messages);

        if ($reponse['ok']) {
            $reponse['texte'] = $this->securiserChemins($reponse['texte']);
            $this->enregistrerMessage($conversationId, 'assistant', $reponse['texte']);
        }

        return $this->json([
            'ok'     => $reponse['ok'],
            'texte'  => $reponse['texte'],
            'restant'=> self::CONVERSATIONS_PAR_JOUR - (int)Database::valeur(
                'SELECT COUNT(*) FROM chat_conversations WHERE client_id = ? AND jour = ?',
                [$clientId, $jour]
            ),
        ], $reponse['ok'] ? 200 : 502);
    }

    /**
     * Restitue l'historique d'une conversation — pour qu'un visiteur qui
     * revient sur le site (identifiant conservé en localStorage côté
     * navigateur, voir ea-v2.js) retrouve son échange précédent au lieu de
     * repartir de zéro à chaque visite.
     *
     * VÉRIFICATION DE PROPRIÉTÉ obligatoire : l'identifiant de conversation
     * est une simple chaîne générée côté navigateur — sans ce contrôle,
     * n'importe qui devinant ou récupérant un identifiant pourrait lire la
     * conversation d'un autre visiteur. On ne renvoie l'historique QUE si le
     * cookie client présenté correspond bien au client qui a ouvert cette
     * conversation.
     */
    public function historique(): string
    {
        $conversationId = mb_substr($_GET['conversation_id'] ?? '', 0, 64);
        $clientId       = $_COOKIE[self::COOKIE_CLIENT] ?? '';

        if ($conversationId === '' || $clientId === '') {
            return $this->json(['ok' => true, 'messages' => []]);
        }

        $proprietaire = Database::valeur(
            'SELECT 1 FROM chat_conversations WHERE client_id = ? AND conversation_id = ?',
            [$clientId, $conversationId]
        );
        if ($proprietaire === false) {
            return $this->json(['ok' => true, 'messages' => []]);
        }

        $messages = Database::tous(
            'SELECT role, contenu FROM chat_messages WHERE conversation_id = ? ORDER BY id ASC LIMIT 40',
            [$conversationId]
        );

        return $this->json(['ok' => true, 'messages' => $messages]);
    }

    /**
     * Filet de sécurité sur les chemins — ne pas se fier à la seule
     * consigne du prompt système. Un modèle de langage peut inventer un
     * chemin plausible (« /pages/tarifs », « /blog » au lieu de
     * « /pages/blog ») même bien cadré : c'est un comportement statistique,
     * pas une garantie. On vérifie donc CHAQUE chemin mentionné contre la
     * liste réelle des adresses du site avant d'afficher la réponse — un
     * lien mort dans la bouche d'EMTITÉ serait exactement le genre de
     * promesse non tenue que la doctrine du site interdit.
     *
     * Si un chemin inventé est détecté, toute la réponse est remplacée :
     * corriger seulement le lien, au milieu d'une phrase déjà écrite autour
     * de lui, produirait une phrase bancale. Mieux vaut une réponse plus
     * sobre mais fiable qu'une réponse fluide mais fausse.
     */
    private function securiserChemins(string $texte): string
    {
        if (!preg_match_all('#(?<!\S)/[a-zA-Z][a-zA-Z0-9/_-]{1,60}[.,;:!?)]*(?!\S)#', $texte, $m)) {
            return $texte; // aucun chemin mentionné, rien à vérifier
        }

        $connus = [
            '/', '/pages/services', '/pages/produits', '/pages/prestations',
            '/pages/realisations', '/pages/blog', '/pages/a-propos', '/pages/contact', '/diagnostic',
        ];
        $slugsArticles = Database::tous('SELECT slug FROM articles WHERE published = 1');
        foreach ($slugsArticles as $a) {
            $connus[] = '/article/' . $a['slug'];
        }

        foreach ($m[0] as $chemin) {
            $chemin = rtrim($chemin, '.,;:!?)');
            if (!in_array($chemin, $connus, true)) {
                error_log("[ea-services] EMTITÉ a mentionné un chemin inexistant : $chemin");
                return "Pour être sûr de vous donner la bonne adresse, je préfère vous orienter "
                     . "directement : /pages/prestations présente tout ce qu'on propose, ou "
                     . "réservez votre diagnostic gratuit pour qu'on regarde votre cas précis.";
            }
        }

        return $texte;
    }

    private function enregistrerMessage(string $conversationId, string $role, string $contenu): void
    {
        Database::executer(
            'INSERT INTO chat_messages (conversation_id, role, contenu, cree_le) VALUES (?, ?, ?, ?)',
            [$conversationId, $role, $contenu, date('Y-m-d H:i:s')]
        );
    }

    /**
     * Cookie longue durée, pas l'IP seule : sur le marché ivoirien, beaucoup
     * de visiteurs partagent une même adresse IP (réseau mobile, box
     * partagée) — l'IP seule pénaliserait des clients différents comme un
     * seul et même client.
     */
    private function identifiantClient(): string
    {
        $id = $_COOKIE[self::COOKIE_CLIENT] ?? '';
        if (!preg_match('/^[a-f0-9]{32}$/', $id)) {
            $id = bin2hex(random_bytes(16));
            setcookie(self::COOKIE_CLIENT, $id, [
                'expires'  => time() + 31536000,
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
        return $id;
    }

    /**
     * Le cadrage. Trois règles non négociables (doctrine du site) :
     *   1. Jamais un prix, un délai ou une garantie inventés — le diagnostic
     *      existe précisément pour ça.
     *   2. Jamais de jargon (API, backend, CRM…) — le visiteur n'est pas
     *      développeur.
     *   3. Toujours ramener vers une des pages réelles du site ou le
     *      diagnostic — jamais laisser la conversation dans le vide.
     */
    private function promptSysteme(): string
    {
        $gains = (array)Config::get('gains');
        $lignesGains = [];
        foreach ($gains as $g) {
            $lignesGains[] = "- {$g['titre']} — {$g['impact']}";
        }

        return "Tu t'appelles EMTITÉ, l'accueil d'EA-SERVICES, agence digitale et de formation "
             . "informatique/IA basée à Marcory Biétry, Abidjan, Côte d'Ivoire. Tu n'es PAS un humain et tu "
             . "ne le prétends jamais — si on te le demande, tu dis que tu es EMTITÉ, l'assistant du site. "
             . "Ne te présente par ton nom qu'au tout début de l'échange ou si on te le demande, pas à "
             . "chaque message.\n\n"
             . "TON RÔLE : comprendre ce que la personne cherche à améliorer dans son activité, et la "
             . "diriger vers la bonne réponse. Tu es un accueil qui écoute et oriente, pas un vendeur qui "
             . "pousse une offre.\n\n"
             . "CE QUE TU CONNAIS RÉELLEMENT (ne dis jamais autre chose que ceci comme chiffre ou promesse) :\n"
             . implode("\n", $lignesGains) . "\n\n"
             . "Nos moyens concrets, présentés sur /pages/prestations : site vitrine, boutique en ligne, "
             . "gestion de pages, applications web et mobile sur mesure, automatisation (relances, "
             . "WhatsApp), formation informatique et IA, coaching, maintenance informatique, cloud.\n\n"
             . "Pages du site vers lesquelles orienter : /pages/services (le détail des 5 gains), "
             . "/pages/prestations (les moyens concrets ci-dessus), /pages/produits (nos 3 solutions), "
             . "/pages/realisations (cas clients chiffrés), /pages/blog (nos articles), "
             . "/diagnostic (diagnostic gratuit en 5 questions).\n\n"
             . "INTERDITS ABSOLUS :\n"
             . "- Ne jamais annoncer un prix, un tarif ou un montant en FCFA : nous n'avons pas de "
             . "catalogue de prix, chaque cas est différent. Dis que le prix se calcule au diagnostic "
             . "gratuit (30 minutes, sans engagement), jamais un chiffre approximatif.\n"
             . "- Ne jamais promettre un délai précis, une garantie, ou citer un client par son nom si tu "
             . "n'en es pas sûr.\n"
             . "- Ne jamais utiliser de jargon technique (API, backend, CRM, dashboard, workflow).\n"
             . "- Aucun emoji.\n\n"
             . "STYLE : vouvoiement, français, phrases courtes, direct. Réponses de 2 à 4 phrases maximum. "
             . "Termine par une suggestion concrète (une page à visiter, ou le diagnostic gratuit) quand "
             . "c'est pertinent — jamais systématiquement, seulement quand ça aide vraiment.";
    }
}
