<?php
declare(strict_types=1);

/**
 * Identité, coordonnées et promesses chiffrées d'EA-SERVICES.
 *
 * SOURCE UNIQUE. Un numéro, une adresse ou une promesse chiffrée ne doit
 * exister qu'ici — jamais recopié dans une vue. Les cinq gains sont la
 * colonne vertébrale du site (cf. skill ea-philosophie) : leurs chiffres
 * sont la promesse de la marque, ils ne se changent pas au hasard.
 */
return [
    'nom'      => 'EA-SERVICES',
    'baseline' => 'Développement · IA · Trading · Coaching',
    'domaine'  => 'https://ea-services.net',

    // Coordonnées réelles — confirmées par le dirigeant le 2026-08-06.
    'contact' => [
        'telephone'         => '+225 01 72 52 77 65',
        'telephone_e164'    => '+2250172527765',   // href="tel:"
        'whatsapp'          => '2250172527765',    // wa.me/…, sans + ni espace
        'whatsapp_message'  => 'Bonjour, je souhaite réserver mon diagnostic gratuit de 30 minutes.',
        'email'             => 'contact@ea-services.net',
        'ville'             => 'Abidjan',
        'quartier'          => 'Marcory Biétry',
        'pays'              => "Côte d'Ivoire",
        'pays_code'         => 'CI',
    ],

    // Réseaux réels — confirmés par le dirigeant le 2026-08-15. N'en ajouter
    // un que si le lien est vérifié : un lien social mort ou générique fait
    // plus de mal à la crédibilité qu'aucun lien du tout.
    // Le fondateur et son portfolio : lien réciproque avec le portfolio (le
    // portfolio renvoie vers ea-services.net), ce qui aide Google à relier
    // les deux sites à la même personne et à la même entreprise.
    'fondateur' => [
        'nom'       => 'Herman Robe',
        'titre'     => 'Concepteur-développeur full-stack',
        'portfolio' => 'https://sites-sfb.ea-services.net/portfolio-herman-robe',
        'github'    => 'https://github.com/ROB731',
    ],

    'reseaux' => [
        'youtube'  => 'https://www.youtube.com/@ea-services',
        'facebook' => 'https://www.facebook.com/entreprendreaujourdhui',
    ],

    // L'unique appel à l'action du site. Aucune page ne finit autrement.
    'cta' => [
        'titre'   => 'Commençons par un diagnostic gratuit',
        'libelle' => 'Réserver mon diagnostic',
        'promesse'=> '30 minutes · gratuit · sans engagement',
    ],

    /**
     * Les cinq gains. `cle` sert de couleur sémantique dans la feuille de
     * style (--gain-temps, --gain-conversion…) : la même teinte désigne le
     * même gain partout sur le site.
     */
    'gains' => [
        'temps' => [
            // Pas de nombre d'heures fixe (décision du dirigeant, 2026-11-05) :
            // le temps perdu dépend entièrement de l'activité, aucune
            // entreprise ne récupère le même. Le chiffre se calcule sur les
            // tâches du client, pendant le diagnostic.
            'titre'   => 'Récupérez le temps que les tâches répétitives vous prennent',
            'perte'   => "Relances, suivis, saisies, réponses courantes : chaque semaine, des heures partent dans ce qu'une machine ferait sans vous.",
            'gain'    => 'Ces heures vous reviennent, pour vos clients et pour la stratégie.',
            'impact'  => 'vos heures récupérées, comptées sur vos propres tâches',
        ],
        'conversion' => [
            'titre'   => 'Convertissez 3 fois plus de prospects',
            'perte'   => "Un prospect qui attend plus de cinq minutes appelle votre concurrent. 30 % des demandes ne sont jamais rappelées.",
            'gain'    => 'Chaque demande reçoit une réponse en moins de deux minutes, même la nuit.',
            'impact'  => '+30 % de conversion, réponse en moins de 2 minutes',
        ],
        'visibilite' => [
            'titre'   => 'Démultipliez votre visibilité',
            'perte'   => 'Vos clients ne vous trouvent pas sur Google. Vos concurrents captent les recherches à votre place.',
            'gain'    => "Une présence complète et régulière : on vous trouve quand on vous cherche.",
            'impact'  => '+50 % de visibilité, +40 % de demandes venues de Google',
        ],
        'ca' => [
            'titre'   => "Augmentez votre chiffre d'affaires sans surcharge",
            'perte'   => 'Pour gagner plus, il faudrait travailler plus. Votre temps est déjà plein.',
            'gain'    => 'Le temps récupéré et les prospects convertis nourrissent directement vos ventes.',
            'impact'  => "+20 à 40 % de chiffre d'affaires la première année",
        ],
        'serenite' => [
            'titre'   => 'Dormez tranquille',
            'perte'   => 'Une panne, une perte de données ou un contrôle et tout votre travail est menacé.',
            'gain'    => 'Sauvegarde automatique, supervision permanente, conformité assurée.',
            'impact'  => 'Zéro perte de données, zéro risque juridique',
        ],
    ],

    // Navigation publique. L'ordre est celui du parcours de décision.
    // « Solutions » retiré du menu (2026-08-16) : cette page reste en ligne
    // et indexée, atteinte depuis la section « Nos prestations » de l'accueil.
    // « Résultats » a été scindé en deux VRAIES pages séparées (2026-08-17) :
    // /pages/realisations (cas clients chiffrés) et /pages/blog (articles).
    // Une seule page qui mélangeait les deux, retrouvée par une ancre, ne
    // correspondait à aucune des deux quand on cliquait dessus.
    'navigation' => [
        ['url' => '/',                    'libelle' => 'Accueil'],
        ['url' => '/pages/services',      'libelle' => 'Services'],
        ['url' => '/pages/prestations',   'libelle' => 'Prestations'],
        ['url' => '/pages/realisations',  'libelle' => 'Réalisations'],
        ['url' => '/pages/blog',          'libelle' => 'Blog'],
        ['url' => '/pages/a-propos',      'libelle' => 'À propos'],
    ],

    /**
     * Questions réellement posées pendant les premiers échanges commerciaux.
     * SOURCE UNIQUE : utilisée à la fois pour l'affichage (page contact) et
     * pour les données structurées FAQPage (Seo::blocsCommuns) — les deux
     * doivent dire la même chose, sinon Google voit un contenu structuré qui
     * ne correspond pas à ce qui est réellement affiché.
     */
    'faq' => [
        [
            'question' => "Le diagnostic est-il vraiment gratuit ?",
            'reponse'  => "Oui. Trente minutes, sans engagement et sans vente pendant l'échange. Vous repartez avec vos deux priorités chiffrées, que vous travailliez avec nous ensuite ou non.",
        ],
        [
            'question' => "Combien coûte un accompagnement EA-SERVICES ?",
            'reponse'  => "Il n'y a pas de tarif au catalogue, parce qu'il dépend de ce que vous perdez aujourd'hui. Pendant le diagnostic nous donnons le montant, le gain mensuel attendu en FCFA et le nombre de mois au bout duquel le gain dépasse l'investissement.",
        ],
        [
            'question' => "Travaillez-vous uniquement à Abidjan ?",
            'reponse'  => "Nos bureaux sont à Marcory Biétry, à Abidjan. Nous intervenons sur place dans tout le district d'Abidjan, et à distance partout ailleurs en Côte d'Ivoire.",
        ],
        [
            'question' => "Faut-il des compétences techniques pour utiliser ce que vous mettez en place ?",
            'reponse'  => "Non. Nous formons votre équipe et l'objectif est votre autonomie sur le quotidien. Un prestataire dont on ne peut pas se passer est un risque, pas un partenaire.",
        ],
        [
            'question' => "En combien de temps voit-on les premiers résultats ?",
            'reponse'  => "Les gains de temps se voient dès les premières semaines. La visibilité et les demandes venues de Google demandent en général deux à trois mois.",
        ],
    ],
];
