<?php
declare(strict_types=1);

namespace EA\Controllers;

use EA\Core\Controleur;
use EA\Core\Csrf;
use EA\Core\Database;
use EA\Core\Visites;

/**
 * Diagnostic automatique.
 *
 * La doctrine promet, sur chaque page : « trente minutes pour repérer vos deux
 * plus grosses pertes ». Ce diagnostic en donne un premier chiffrage tout de
 * suite, sans attendre le rendez-vous — et le visiteur repart avec, qu'il
 * travaille avec nous ou non (règle explicite de la doctrine).
 *
 * INTÉGRITÉ — règle absolue du dépôt : ne jamais inventer un chiffre.
 * Tout ce qui est affiché sort soit des réponses de la personne, soit des
 * promesses publiées de la marque (config `gains`). Le calcul est montré, pas
 * asséné : chaque ligne indique d'où vient son nombre. Rien n'est extrapolé
 * au-delà de ce qui a été déclaré.
 *
 * RÉSILIENCE — le résultat s'affiche à l'écran ET s'enregistre en base AVANT
 * toute tentative d'envoi de courriel. Le serveur de messagerie de cette
 * machine ne délivre pas (constaté le 2026-08-13) : faire dépendre la valeur
 * livrée d'un courriel reviendrait à ne rien livrer du tout.
 */
final class DiagnosticController extends Controleur
{
    /** Semaines réellement travaillées dans l'année — 52 moins congés et fêtes. */
    private const SEMAINES = 46;

    /** Heures d'une journée de travail, pour convertir un total en journées. */
    private const HEURES_JOUR = 8;

    public function formulaire(): string
    {
        return $this->page('pages/diagnostic', [], [
            'titre'       => "Diagnostic gratuit — chiffrez vos pertes en 2 minutes | EA-SERVICES",
            'description' => "Répondez à cinq questions : vous obtenez immédiatement vos deux plus "
                           . "grosses pertes, chiffrées en heures et en journées de travail. Gratuit, sans engagement.",
            'canonical'   => '/diagnostic',
        ], 'layouts/public-v2');
    }

    public function calculer(): string
    {
        // Piège à robots : même traitement que le formulaire de contact — on
        // répond normalement sans rien enregistrer, pour ne pas apprendre au
        // robot qu'il a été repéré.
        if ($this->champ('site') !== '') {
            return $this->formulaire();
        }

        if (!Csrf::valide($this->champ('csrf'))) {
            return $this->page('pages/diagnostic', [
                'erreur' => "Votre session a expiré. Rechargez la page et renvoyez le formulaire.",
            ], [
                'titre'     => "Diagnostic gratuit | EA-SERVICES",
                'canonical' => '/diagnostic',
                'robots'    => 'noindex, nofollow',
            ], 'layouts/public-v2');
        }

        $reponses = [
            'heures'    => $this->entier('heures', 0, 60),
            'delai'     => $this->champ('delai'),
            'demandes'  => $this->entier('demandes', 0, 500),
            'trouve'    => $this->champ('trouve'),
            'sauvegarde'=> $this->champ('sauvegarde'),
            'nom'       => mb_substr($this->champ('nom'), 0, 120),
            'telephone' => mb_substr($this->champ('telephone'), 0, 40),
            'email'     => mb_substr($this->champ('email'), 0, 160),
        ];

        $pertes = $this->chiffrer($reponses);

        // Enregistrement AVANT l'envoi : la valeur est acquise même si la
        // messagerie tombe. Type distinct de 'diagnostic' pour que l'admin
        // sache d'où vient la demande.
        Database::executer(
            'INSERT INTO messages (type, payload_json, read, notified, created_at) VALUES (?, ?, 0, 0, ?)',
            [
                'diagnostic-auto',
                json_encode($reponses + ['pertes' => $pertes, 'ip' => Visites::ip()], JSON_UNESCAPED_UNICODE),
                date('Y-m-d H:i:s'),
            ]
        );

        $this->prevenirParCourriel($reponses, $pertes);

        return $this->page('pages/diagnostic-resultat', [
            'pertes'   => $pertes,
            'reponses' => $reponses,
        ], [
            'titre'     => "Votre diagnostic — EA-SERVICES",
            'canonical' => '/diagnostic',
            'robots'    => 'noindex, nofollow',   // un résultat personnel n'a rien à faire dans Google
        ], 'layouts/public-v2');
    }

    /**
     * Chiffrage. Chaque perte porte sa propre justification, en clair : le
     * visiteur doit pouvoir refaire le calcul de tête. Une perte dont on ne
     * peut rien dire n'est PAS affichée — mieux vaut trois lignes honnêtes
     * que cinq dont deux sont creuses.
     *
     * @return array<int, array{cle:string, titre:string, chiffre:string, detail:string, methode:string, promesse:string}>
     */
    private function chiffrer(array $r): array
    {
        $gains  = (array)cfg('gains');
        $pertes = [];

        // 1. Temps — arithmétique pure sur ce qui a été déclaré.
        if ($r['heures'] > 0) {
            $anHeures = $r['heures'] * self::SEMAINES;
            $journees = (int)round($anHeures / self::HEURES_JOUR);
            $pertes[] = [
                'cle'      => 'temps',
                'titre'    => 'Le temps avalé par les tâches répétitives',
                'chiffre'  => number_format($anHeures, 0, ',', ' ') . ' h',
                'detail'   => "Soit environ $journees journées de travail par an, "
                            . "passées sur ce qu'une machine ferait sans vous.",
                'methode'  => "{$r['heures']} h par semaine que vous avez déclarées, sur "
                            . self::SEMAINES . " semaines travaillées.",
                'promesse' => (string)($gains['temps']['impact'] ?? ''),
                'poids'    => $anHeures,
            ];
        }

        // 2. Conversion — on ne chiffre QUE si le délai dépasse deux minutes,
        //    seuil publié par la marque. En dessous, il n'y a pas de perte à
        //    annoncer, et l'inventer serait malhonnête.
        $delaisLents = ['heures' => 'quelques heures', 'demain' => 'le lendemain', 'parfois' => 'parfois jamais'];
        if (isset($delaisLents[$r['delai']]) && $r['demandes'] > 0) {
            $anDemandes = $r['demandes'] * self::SEMAINES;
            $pertes[] = [
                'cle'      => 'conversion',
                'titre'    => 'Les demandes qui refroidissent avant votre réponse',
                'chiffre'  => number_format($anDemandes, 0, ',', ' ') . ' demandes',
                'detail'   => "Chacune vous parvient, puis attend « {$delaisLents[$r['delai']]} ». "
                            . "Pendant ce temps le prospect écrit ailleurs, et c'est le premier à répondre qui l'obtient.",
                'methode'  => "{$r['demandes']} demandes par semaine que vous avez déclarées, sur "
                            . self::SEMAINES . " semaines. Le seuil de deux minutes est la promesse publiée d'EA-SERVICES.",
                'promesse' => (string)($gains['conversion']['impact'] ?? ''),
                'poids'    => $anDemandes * 3,
            ];
        }

        // 3. Visibilité — pas de chiffre inventé : on nomme la dépendance.
        if ($r['trouve'] === 'bouche') {
            $pertes[] = [
                'cle'      => 'visibilite',
                'titre'    => 'Les clients qui vous cherchent sans vous trouver',
                'chiffre'  => 'Zéro',
                'detail'   => "Vous avez indiqué que vos clients viennent surtout du bouche-à-oreille. "
                            . "Ceux qui cherchent votre métier sur leur téléphone, eux, appellent quelqu'un d'autre. "
                            . "Cette perte-là ne laisse aucune trace : vous ne saurez jamais combien elle représente.",
                'methode'  => "Déduit de votre réponse sur l'origine de vos clients. Aucun chiffre n'est avancé ici, "
                            . "précisément parce qu'il serait inventé.",
                'promesse' => (string)($gains['visibilite']['impact'] ?? ''),
                'poids'    => 200,
            ];
        }

        // 4. Sérénité — un risque, pas une perte déjà subie. Formulé comme tel.
        if ($r['sauvegarde'] === 'non' || $r['sauvegarde'] === 'sais-pas') {
            $pertes[] = [
                'cle'      => 'serenite',
                'titre'    => "Ce que vous perdriez le jour où l'ordinateur tombe",
                'chiffre'  => 'Tout',
                'detail'   => $r['sauvegarde'] === 'non'
                            ? "Vos données ne sont pas sauvegardées ailleurs. Un vol, une panne de disque ou "
                            . "un incendie, et le fichier de vos clients disparaît avec."
                            : "Vous ne savez pas si vos données sont sauvegardées. Dans les faits, cela revient "
                            . "au même : personne ne vérifie, donc personne ne saura avant le jour du problème.",
                'methode'  => "Déduit de votre réponse sur la sauvegarde. C'est un risque, pas une perte "
                            . "déjà subie — il ne se chiffre pas, il se supprime.",
                'promesse' => (string)($gains['serenite']['impact'] ?? ''),
                'poids'    => 150,
            ];
        }

        // Les deux plus lourdes d'abord : la doctrine promet DEUX priorités,
        // pas une liste. Vouloir tout traiter d'un coup, c'est ne rien finir.
        usort($pertes, static fn(array $a, array $b): int => $b['poids'] <=> $a['poids']);

        return $pertes;
    }

    /**
     * Alerte interne. Best-effort, comme pour le formulaire de contact : la
     * demande est déjà en base, et la messagerie de cette machine ne délivre
     * pas aujourd'hui. Le jour où elle sera réparée, ceci fonctionnera sans
     * qu'on y retouche.
     */
    private function prevenirParCourriel(array $r, array $pertes): void
    {
        try {
            $destinataire = (string)cfg('contact.email');
            $qui   = $r['nom'] !== '' ? $r['nom'] : 'Visiteur anonyme';
            $sujet = "Diagnostic automatique — $qui";

            $lignes = "Diagnostic rempli sur ea-services.net\n\n"
                    . "Nom        : " . ($r['nom'] ?: '—') . "\n"
                    . "Téléphone  : " . ($r['telephone'] ?: '—') . "\n"
                    . "Courriel   : " . ($r['email'] ?: '—') . "\n\n"
                    . "Ses réponses\n"
                    . "  Heures répétitives par semaine : {$r['heures']}\n"
                    . "  Délai de réponse               : {$r['delai']}\n"
                    . "  Demandes par semaine           : {$r['demandes']}\n"
                    . "  Origine des clients            : {$r['trouve']}\n"
                    . "  Sauvegarde                     : {$r['sauvegarde']}\n\n"
                    . "Pertes chiffrées\n";
            foreach ($pertes as $i => $p) {
                $lignes .= '  ' . ($i + 1) . ". {$p['titre']} — {$p['chiffre']}\n"
                         . "     {$p['methode']}\n";
            }
            $lignes .= "\nReçu le " . date('d/m/Y à H:i') . "\n";

            $entetes = "From: EA-SERVICES <$destinataire>\r\n"
                     . ($r['email'] !== '' ? "Reply-To: {$r['email']}\r\n" : '')
                     . "Content-Type: text/plain; charset=UTF-8\r\n";

            @mail($destinataire, '=?UTF-8?B?' . base64_encode($sujet) . '?=', $lignes, $entetes);
        } catch (\Throwable) {
            // Le diagnostic est en base et affiché : rien n'est perdu.
        }
    }

    /** `champ()` vient de Controleur — il gere aussi les corps JSON, ne pas le
     *  redeclarer ici (PHP refuse d'ailleurs d'en restreindre la visibilite). */
    private function entier(string $nom, int $min, int $max): int
    {
        $v = (int)($_POST[$nom] ?? 0);
        return max($min, min($max, $v));
    }
}
