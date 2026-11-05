<?php
declare(strict_types=1);

/**
 * Pages d'expertise — une page par besoin que les gens tapent réellement dans
 * Google (« création site web Abidjan », « chatbot WhatsApp entreprise »…).
 *
 * POURQUOI ces pages existent (2026-11-04) : aucun titre visible du site ne
 * contenait les mots recherchés. Les pages historiques parlent de pertes et de
 * gains — c'est ce qui convainc une personne déjà sur le site — mais personne
 * ne tape « vous perdez ce qu'il rapporte ». Ces pages font le pont : le titre
 * reprend la requête, le corps garde la doctrine (perte → gain → diagnostic).
 *
 * RÈGLES, à ne jamais relâcher :
 *  - Le slug ne change JAMAIS après mise en ligne (c'est l'adresse indexée).
 *  - Aucun chiffre ici : les seuls chiffres viennent de config/site.php (gains).
 *  - `preuves` ne cite QUE des réalisations réelles, déjà en ligne sur
 *    /pages/realisations, ou des avis réels présents en base. Pas de preuve
 *    vérifiable = pas de section preuve (jamais de fiction pour combler).
 *  - La FAQ est affichée ET reprise en données structurées : les deux doivent
 *    dire exactement la même chose.
 *  - Aucun prix inventé : le montant est donné pendant le diagnostic.
 *
 * Champs : libelle, titre (balise title), description (meta), gain (clé de
 * config/site.php gains), icone, image, h1, h1_suite, badge, chapo, pertes,
 * livrables, pour_qui, differences, preuves, faq, articles, voisines.
 */
return [

    /* ------------------------------------------------------------ Site web */
    'creation-site-web-abidjan' => [
        'libelle'     => 'Création de site web',
        'service'     => 'Création de site internet',
        'titre'       => "Création de site web à Abidjan, pensé pour être trouvé | EA-SERVICES",
        'description' => "Création de site internet à Abidjan : rapide sur téléphone, écrit sur les mots que tapent vos clients, relié à WhatsApp. Diagnostic gratuit de 30 minutes.",
        'gain'        => 'visibilite',
        'icone'       => 'visibilite',
        'image'       => '/assets/prestations/presence-en-ligne.svg',
        'h1'          => 'Création de site web à Abidjan',
        'h1_suite'    => 'Un site qui ramène des clients, pas une vitrine vide.',
        'badge'       => "Site vitrine, site d'entreprise, site d'hôtel ou d'événement — Abidjan, Côte d'Ivoire",
        'chapo'       => "Beaucoup d'entreprises ont un site. Peu ont un site qui leur apporte une "
                       . "seule demande par mois. La différence ne tient pas au graphisme : elle tient "
                       . "à ce que le site répond à une recherche précise, s'affiche vite sur un "
                       . "téléphone, et donne envie d'écrire tout de suite.",
        'visuel'      => ['src' => '/assets/expertises/site-web.svg', 'alt' => "Illustration : un site d'entreprise sur ordinateur et téléphone, trouvé depuis une recherche Google"],
        'photo'       => ['fichier' => 'abidjan-plateau', 'ratio' => '1200/567',
                          'alt' => "Vue du Plateau, le quartier d'affaires d'Abidjan, depuis le pont Alassane Ouattara",
                          'legende' => "Abidjan : des milliers de recherches chaque jour, sur téléphone. La question est de savoir si l'on vous y trouve.",
                          'credit' => 'Edison McCullen, CC BY 4.0, Wikimedia Commons',
                          'source' => 'https://commons.wikimedia.org/wiki/File:Le_Plateau_depuis_le_Pont_ADO_%E2%80%93_Abidjan.jpg'],
        'pertes' => [
            ['Personne ne le trouve', "Le site existe, mais il n'apparaît sur aucune recherche. Il a été écrit pour présenter l'entreprise, pas pour répondre à ce que tapent les clients."],
            ['Il est lent sur téléphone', "Vos clients le consultent sur leur téléphone, souvent avec une connexion moyenne. Au-delà de quelques secondes d'attente, ils repartent sans avoir rien lu."],
            ['Il ne fait pas agir', "Le visiteur arrive, lit, puis ne sait pas quoi faire. Pas de bouton WhatsApp visible, pas de numéro cliquable : la demande ne part jamais."],
        ],
        'livrables' => [
            "Un site conçu d'abord pour le téléphone, puis adapté à l'ordinateur.",
            "Des pages écrites autour des recherches réelles de vos clients, avec votre ville et votre métier.",
            "Un bouton WhatsApp et un numéro cliquables sur chaque page.",
            "Les réglages qui permettent à Google de comprendre et d'afficher votre site.",
            "Votre fiche d'entreprise sur Google complétée, avec les mêmes coordonnées partout.",
            "L'hébergement, la sauvegarde et le certificat de sécurité pris en charge.",
            "Une formation pour modifier vos textes et vos photos sans dépendre de nous.",
        ],
        'pour_qui' => [
            "On vous demande encore « vous avez un site ? ».",
            "Votre site actuel ne vous a jamais apporté de client.",
            "Vos clients viennent uniquement du bouche-à-oreille.",
            "Vous ouvrez une activité et vous voulez être pris au sérieux dès le premier jour.",
        ],
        'differences' => [
            ['On part de ce que cherchent vos clients', "Avant de dessiner une page, on liste les mots que vos clients tapent réellement. Chaque page répond à l'un d'eux."],
            ['Le téléphone d’abord', "Le site est conçu et vérifié sur un écran de téléphone avant tout le reste, parce que c'est là que vos clients le liront."],
            ['Un chiffre avant un devis', "Pendant le diagnostic, on estime ce que le site doit vous rapporter. Si le calcul ne vous est pas favorable, on vous le dit."],
            ['Vous restez autonome', "Vous apprenez à modifier vos contenus vous-même. Un site qu'on ne peut pas faire vivre sans son prestataire finit abandonné."],
        ],
        'preuves' => [
            'titre' => 'Des sites déjà en ligne',
            'texte' => "Une boutique de parfums et d'accessoires avec commande par WhatsApp, un hôtel à Marcory avec réservation express, le site d'un rallye-raid international : des sites réels, que vous pouvez ouvrir.",
            'lien'  => ['/pages/realisations', 'Voir nos réalisations'],
        ],
        'faq' => [
            ['Combien coûte la création d’un site web à Abidjan ?', "Le prix dépend du nombre de pages, des textes et photos déjà prêts, et de ce que le site doit faire (présenter, vendre, prendre des réservations). Nous ne donnons pas de tarif au catalogue : pendant le diagnostic gratuit, nous donnons le montant, ce que le site doit vous rapporter, et le délai au bout duquel il est rentabilisé."],
            ['Mon site apparaîtra-t-il sur Google ?', "Le site est construit pour que Google le comprenne : adresse propre, titres qui reprennent les recherches de vos clients, fiche d'entreprise complétée. L'apparition dans les résultats prend en général deux à trois mois, et dépend aussi de la concurrence sur votre métier."],
            ['Faut-il des compétences techniques pour le faire vivre ?', "Non. Nous vous formons pour modifier vos textes et vos photos. Pour le reste — hébergement, sauvegarde, sécurité — nous nous en occupons."],
            ['Pouvez-vous refaire un site qui existe déjà ?', "Oui. On commence par regarder ce qu'il vous apporte aujourd'hui, et on conserve les adresses déjà connues de Google pour ne pas perdre ce qui a été acquis."],
            ['Travaillez-vous en dehors d’Abidjan ?', "Nos bureaux sont à Marcory Biétry. Nous intervenons sur place dans tout le district d'Abidjan, et à distance partout ailleurs en Côte d'Ivoire."],
        ],
        'articles' => [
            'agence-web-cote-d-ivoire-comment-choisir-la-bonne-agence-pour-votre-pme-a-abidja',
            'creation-de-site-web-ia-ce-que-ca-change-vraiment-pour-une-pme-ivoirienne',
            'votre-entreprise-existe-t-elle-vraiment-si-elle-n-apparait-pas-sur-google',
        ],
        'voisines' => ['boutique-en-ligne-abidjan', 'referencement-google-abidjan', 'chatbot-whatsapp-entreprise'],
    ],

    /* ----------------------------------------------------- Boutique en ligne */
    'boutique-en-ligne-abidjan' => [
        'libelle'     => 'Boutique en ligne',
        'service'     => 'Création de boutique en ligne',
        'titre'       => "Créer une boutique en ligne en Côte d'Ivoire | EA-SERVICES",
        'description' => "Boutique en ligne à Abidjan : catalogue sur téléphone, commande par WhatsApp, paiement à la livraison ou Mobile Money. Vendez même quand la boutique est fermée.",
        'gain'        => 'ca',
        'icone'       => 'croissance',
        'image'       => '/assets/prestations/presence-en-ligne.svg',
        'h1'          => "Créer votre boutique en ligne en Côte d'Ivoire",
        'h1_suite'    => 'Vendez aussi quand le magasin est fermé.',
        'badge'       => "Boutique en ligne, catalogue et commande WhatsApp — Abidjan, Côte d'Ivoire",
        'chapo'       => "Vos clients regardent vos produits sur leur téléphone, le soir, après le "
                       . "travail. S'ils doivent vous écrire pour demander chaque prix et chaque "
                       . "taille, la plupart abandonnent avant d'avoir commandé.",
        'visuel'      => ['src' => '/assets/expertises/boutique-en-ligne.svg', 'alt' => "Illustration : une boutique en ligne sur téléphone et une commande reçue sur WhatsApp"],
        'photo'       => ['fichier' => 'abidjan-marche', 'ratio' => '4/3',
                          'alt' => "Un marché couvert de parasols à Abidjan, vu d'en haut",
                          'legende' => "Vos clients achètent déjà partout dans la ville. La boutique en ligne vous met sous leurs yeux, même quand ils ne passent pas devant chez vous.",
                          'credit' => 'Al K. Bou, CC BY-SA 4.0, Wikimedia Commons',
                          'source' => 'https://commons.wikimedia.org/wiki/File:Abidjan_Market.JPG'],
        'pertes' => [
            ['Les questions répétées', "« C'est combien ? », « Il reste la taille 40 ? », « Vous livrez à Yopougon ? » : chaque vente commence par dix messages, et vous répondez à la main."],
            ['Les ventes de nuit perdues', "Un client prêt à acheter à 22 h n'a personne pour lui répondre. Le lendemain, il a acheté ailleurs ou il a oublié."],
            ['Un catalogue éparpillé', "Les photos sont dans les statuts, les prix dans votre tête, le stock sur un cahier. Rien n'est consultable d'un seul coup d'œil."],
        ],
        'livrables' => [
            "Un catalogue clair sur téléphone : photos, prix, tailles et disponibilités.",
            "La commande envoyée sur votre WhatsApp, déjà détaillée : produit, quantité, adresse.",
            "Le paiement à la livraison, ou par Mobile Money selon votre organisation.",
            "Vos zones et délais de livraison affichés avant que le client ne pose la question.",
            "Des pages produits écrites pour être trouvées sur Google.",
            "Une formation pour ajouter vos produits et changer vos prix vous-même.",
        ],
        'pour_qui' => [
            "Vous vendez déjà par WhatsApp, Facebook ou Instagram et vous croulez sous les messages.",
            "Vous avez un magasin physique et vous voulez vendre au-delà de votre quartier.",
            "Vous perdez des ventes faute de pouvoir répondre le soir et le week-end.",
        ],
        'differences' => [
            ['Adaptée à la façon dont on achète ici', "Commande par WhatsApp, paiement à la livraison, Mobile Money : la boutique suit les habitudes réelles de vos clients, pas un modèle importé."],
            ['Moins de messages, plus de commandes', "Chaque question à laquelle la page répond d'elle-même, c'est un message de moins pour vous et une hésitation de moins pour le client."],
            ['Vous gardez la main', "Vous ajoutez un produit, changez un prix ou retirez un article épuisé en quelques secondes, depuis votre téléphone."],
        ],
        'preuves' => [
            'titre' => 'Une boutique réelle, déjà en ligne',
            'texte' => "Emile'S Boutik vend parfums, sacs, chaussures et bijoux à Abidjan : catalogue complet, commande par WhatsApp, paiement à la livraison. Vous pouvez la parcourir comme un client.",
            'lien'  => ['/pages/realisations', 'Voir la boutique et nos autres réalisations'],
        ],
        'faq' => [
            ['Quel moyen de paiement pour une boutique en ligne en Côte d’Ivoire ?', "Le paiement à la livraison reste le plus rassurant pour beaucoup de clients. Le Mobile Money convient bien aux commandes payées d'avance. Nous choisissons avec vous selon vos produits et votre façon de livrer."],
            ['Faut-il abandonner la vente sur WhatsApp ?', "Non. La boutique envoie les commandes sur votre WhatsApp, déjà détaillées. Vous gardez le contact direct avec le client, sans les dix messages de questions avant chaque vente."],
            ['Combien coûte une boutique en ligne ?', "Cela dépend du nombre de produits, des photos à préparer et du mode de paiement. Pendant le diagnostic gratuit, nous donnons le montant et le nombre de ventes nécessaires pour le rentabiliser."],
            ['Puis-je gérer mes produits moi-même ?', "Oui, c'est le but. Nous vous formons pour ajouter, modifier ou retirer un produit depuis votre téléphone."],
        ],
        'articles' => [
            'chatbot-whatsapp-business-comment-ca-marche-et-pourquoi-l-adopter-pour-votre-pme',
            'votre-entreprise-existe-t-elle-vraiment-si-elle-n-apparait-pas-sur-google',
        ],
        'voisines' => ['creation-site-web-abidjan', 'chatbot-whatsapp-entreprise', 'referencement-google-abidjan'],
    ],

    /* ----------------------------------------------------- Application mobile */
    'application-mobile-abidjan' => [
        'libelle'     => 'Application mobile',
        'service'     => "Développement d'application mobile",
        'titre'       => "Développement d'application mobile à Abidjan | EA-SERVICES",
        'description' => "Application mobile sur mesure à Abidjan, pour vos clients ou votre équipe. Nous concevons aussi nos propres applications, comme Sonnera. Diagnostic gratuit.",
        'gain'        => 'temps',
        'icone'       => 'temps',
        'image'       => '/assets/prestations/developpement-sur-mesure.svg',
        'h1'          => "Développement d'application mobile à Abidjan",
        'h1_suite'    => 'Une application que les gens ouvrent vraiment.',
        'badge'       => "Application Android sur mesure, pour vos clients ou votre équipe — Abidjan, Côte d'Ivoire",
        'chapo'       => "La plupart des applications sont installées une fois, puis oubliées. "
                       . "Une application utile règle un problème qui revient chaque jour : une "
                       . "commande à passer, une tâche à confirmer, un suivi à consulter. C'est "
                       . "de là que nous partons.",
        'visuel'      => ['src' => '/assets/expertises/application-mobile.svg', 'alt' => "Illustration : une application d'équipe avec une alarme de tâche et le suivi des réponses"],
        'pertes' => [
            ['Tout passe par des messages', "Les commandes, les consignes et les suivis passent par des groupes de discussion. Rien n'est rangé, tout se perd, et personne ne sait ce qui a été fait."],
            ['Des outils qui ne vous ressemblent pas', "Les applications toutes faites imposent leur façon de travailler. Votre équipe contourne l'outil, et vous revenez aux cahiers."],
            ['Le projet qui ne finit jamais', "Une application commandée sans objectif clair grossit de mois en mois, coûte toujours plus, et n'est jamais vraiment utilisée."],
        ],
        'livrables' => [
            "Un objectif écrit avant la première ligne : ce que l'application doit vous faire gagner.",
            "Une première version limitée à l'essentiel, mise entre les mains de vrais utilisateurs rapidement.",
            "Une application Android conçue pour les téléphones et les connexions de vos utilisateurs.",
            "Les notifications qui comptent, et seulement celles-là.",
            "La mise en ligne, le suivi et les corrections après le lancement.",
            "La formation de votre équipe et de vos premiers utilisateurs.",
        ],
        'pour_qui' => [
            "Votre équipe se coordonne par messages et des choses se perdent chaque semaine.",
            "Vos clients vous demandent un moyen plus simple de commander ou de suivre.",
            "Vous avez une idée d'application et vous voulez savoir si elle tient avant d'investir.",
        ],
        'differences' => [
            ['Nous construisons nos propres applications', "Sonnera, notre application de rappels et de suivi d'équipe, est conçue et maintenue par nous. Nous savons ce qu'il faut pour qu'une application soit utilisée tous les jours."],
            ['L’essentiel d’abord', "On commence petit, on mesure l'usage réel, puis on ajoute. Pas de projet de six mois avant le premier utilisateur."],
            ['Pensée pour le terrain ivoirien', "Téléphones Android, connexion variable, utilisateurs pressés : l'application est conçue pour ces conditions, pas pour une démonstration en bureau."],
        ],
        'preuves' => [
            'titre' => 'Sonnera, notre propre application',
            'texte' => "Une alarme qui sonne même téléphone verrouillé, des tâches réparties entre collègues, et un responsable prévenu quand rien n'est fait. C'est le genre d'application que nous savons concevoir.",
            'lien'  => ['/pages/sonnera', 'Découvrir Sonnera'],
        ],
        'faq' => [
            ['Combien coûte le développement d’une application mobile ?', "Tout dépend de ce que l'application doit faire. C'est pour cela que nous commençons par une première version limitée à l'essentiel. Pendant le diagnostic gratuit, nous donnons le montant de cette première version et ce qu'elle doit vous faire gagner."],
            ['Android ou iPhone ?', "Sonnera, notre propre application, fonctionne sur Android, le téléphone de la grande majorité des utilisateurs en Côte d'Ivoire. Si votre public est surtout sur iPhone, nous en parlons dès le diagnostic."],
            ['Faut-il une application ou un site suffit-il ?', "Souvent, un site bien fait suffit. Une application se justifie quand elle est ouverte chaque jour : une équipe à coordonner, des commandes régulières, des alertes. Nous vous le dirons honnêtement."],
            ['Qui s’occupe de l’application après sa sortie ?', "Nous assurons le suivi et les corrections après le lancement, et nous formons votre équipe à son usage quotidien."],
        ],
        'articles' => [
            'comment-s-assurer-qu-une-consigne-est-faite-sans-relancer-ses-employes',
            'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider',
        ],
        'voisines' => ['logiciel-sur-mesure-abidjan', 'automatisation-taches-entreprise', 'creation-site-web-abidjan'],
    ],

    /* ----------------------------------------------------- Logiciel sur mesure */
    'logiciel-sur-mesure-abidjan' => [
        'libelle'     => 'Logiciel sur mesure',
        'service'     => 'Développement de logiciel sur mesure',
        'titre'       => "Logiciel sur mesure et application web à Abidjan | EA-SERVICES",
        'description' => "Développement de logiciel sur mesure à Abidjan : un outil construit autour de votre façon de travailler, pas l'inverse. Plateformes déjà en service en Côte d'Ivoire.",
        'gain'        => 'temps',
        'icone'       => 'croissance',
        'image'       => '/assets/prestations/developpement-sur-mesure.svg',
        'h1'          => 'Logiciel sur mesure à Abidjan',
        'h1_suite'    => 'Un outil construit autour de votre façon de travailler.',
        'badge'       => "Application web, espace client, outil de gestion — Abidjan, Côte d'Ivoire",
        'chapo'       => "Quand une entreprise grandit, les fichiers, les cahiers et les groupes de "
                       . "discussion ne suffisent plus. On ressaisit les mêmes informations trois "
                       . "fois, on cherche un document pendant vingt minutes, et les erreurs coûtent "
                       . "de l'argent. Un logiciel sur mesure remet tout au même endroit.",
        'visuel'      => ['src' => '/assets/expertises/logiciel-sur-mesure.svg', 'alt' => "Illustration : un logiciel de gestion qui regroupe les commandes et leur statut"],
        'pertes' => [
            ['La double saisie', "La même commande est notée sur papier, recopiée dans un fichier, puis envoyée par message. Trois saisies, trois occasions de se tromper."],
            ['L’information introuvable', "Pour savoir où en est un client ou une livraison, il faut appeler quelqu'un. Personne n'a la vue d'ensemble."],
            ['Le logiciel qui ne colle pas', "Le logiciel acheté sur étagère impose une façon de travailler qui n'est pas la vôtre. L'équipe le contourne, et vous payez pour rien."],
        ],
        'livrables' => [
            "Un état des lieux de votre façon de travailler, avant toute proposition.",
            "Un outil accessible depuis un ordinateur ou un téléphone, avec des accès par personne.",
            "Un espace client si vos clients doivent suivre leurs commandes ou leurs dossiers.",
            "La reprise de vos fichiers existants, pour ne pas repartir de zéro.",
            "Des sauvegardes quotidiennes et une surveillance permanente.",
            "La formation de vos équipes, puis le suivi et les évolutions.",
        ],
        'pour_qui' => [
            "Vos équipes ressaisissent les mêmes informations à plusieurs endroits.",
            "Vos clients vous appellent pour savoir où en est leur commande ou leur dossier.",
            "Vous avez essayé un logiciel standard et votre équipe ne l'utilise pas.",
        ],
        'differences' => [
            ['Des plateformes déjà en service', "Plateforme de livraison avec espace client, plateforme d'emploi, outil de prospection : nous avons conçu des outils qui tournent tous les jours en Côte d'Ivoire."],
            ['On part de votre quotidien', "On observe comment vous travaillez avant de proposer quoi que ce soit. L'outil s'adapte à vous, pas l'inverse."],
            ['Chaque fonction se justifie', "Une fonction qu'on ne sait pas traduire en temps gagné ou en erreur évitée n'est pas construite. Le projet reste maîtrisé."],
        ],
        'preuves' => [
            'titre' => 'Des outils qui tournent tous les jours',
            'texte' => "IvoirRapid (livraison express à Abidjan, avec son espace client pour les entreprises partenaires), EMPLOI.EA (plateforme d'emploi) et SFB (outil de prospection) : des plateformes réelles, en service.",
            'lien'  => ['/pages/realisations', 'Voir ces réalisations'],
        ],
        'faq' => [
            ['Qu’est-ce qu’un logiciel sur mesure ?', "C'est un outil construit pour votre entreprise, autour de votre façon de travailler : vos étapes, vos documents, vos accès. À la différence d'un logiciel acheté tout fait, il ne vous oblige pas à changer vos habitudes pour lui."],
            ['Combien coûte un logiciel sur mesure ?', "Le montant dépend du nombre de fonctions et d'utilisateurs. Nous commençons par l'essentiel, ce qui rend le premier investissement mesurable. Pendant le diagnostic gratuit, nous donnons le montant, le gain mensuel attendu et le délai de retour."],
            ['Mes données sont-elles en sécurité ?', "Les données sont sauvegardées chaque jour et chaque personne n'accède qu'à ce qui la concerne. Nous surveillons le fonctionnement en permanence."],
            ['Peut-on récupérer nos fichiers actuels ?', "Oui. La reprise de vos fichiers existants fait partie du travail : on ne repart pas d'une page blanche."],
        ],
        'articles' => [
            'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider',
            'agence-web-cote-d-ivoire-comment-choisir-la-bonne-agence-pour-votre-pme-a-abidja',
        ],
        'voisines' => ['application-mobile-abidjan', 'automatisation-taches-entreprise', 'maintenance-informatique-abidjan'],
    ],

    /* ------------------------------------------------------- Chatbot WhatsApp */
    'chatbot-whatsapp-entreprise' => [
        'libelle'     => 'Chatbot WhatsApp',
        'service'     => 'Chatbot WhatsApp pour entreprise',
        'titre'       => "Chatbot WhatsApp pour entreprise en Côte d'Ivoire | EA-SERVICES",
        'description' => "Chatbot WhatsApp Business à Abidjan : chaque client reçoit une réponse en moins de 2 minutes, même la nuit. Vous ne rappelez que les demandes sérieuses.",
        'gain'        => 'conversion',
        'icone'       => 'conversion',
        'image'       => '/assets/prestations/automatisation.svg',
        'h1'          => "Chatbot WhatsApp pour votre entreprise",
        'h1_suite'    => 'Répondez à vos clients même quand vous dormez.',
        'badge'       => "Réponse automatique WhatsApp Business — Abidjan, Côte d'Ivoire",
        'chapo'       => "Un client vous écrit à 21 h. Vous le voyez le lendemain à 11 h. Entre-temps, "
                       . "il a écrit à deux autres entreprises, et l'une d'elles a répondu. Vous "
                       . "n'avez perdu ni sur le prix ni sur la qualité : vous avez perdu sur le délai.",
        'visuel'      => ['src' => '/assets/expertises/chatbot-whatsapp.svg', 'alt' => "Illustration : une conversation WhatsApp où un client reçoit une réponse immédiate le soir"],
        'pertes' => [
            ['Les messages de la nuit', "Les demandes arrivent le soir et le week-end, quand personne n'est là pour répondre. Le client n'attend pas."],
            ['Les mêmes questions, cent fois', "Horaires, prix, adresse, délais : vous ou votre équipe répondez chaque jour aux mêmes questions, à la main."],
            ['Les demandes oubliées', "Un message lu puis remis à plus tard disparaît sous les autres conversations. Le prospect, lui, ne revient pas."],
        ],
        'livrables' => [
            "Une réponse immédiate à chaque message, de jour comme de nuit.",
            "Les réponses aux questions courantes, écrites avec vous et dans votre ton.",
            "Trois questions simples pour savoir si la demande est sérieuse.",
            "Un passage à un humain dès que la conversation le demande.",
            "Les demandes sans suite relancées automatiquement.",
            "Rien ne part en votre nom sans que vous ayez validé les messages types.",
        ],
        'pour_qui' => [
            "Vous recevez beaucoup de messages WhatsApp et vous n'arrivez pas à tous les suivre.",
            "Vos clients vous écrivent le soir et le week-end.",
            "Vous passez des heures à répondre aux mêmes questions.",
        ],
        'differences' => [
            ['La vitesse d’abord', "Le premier qui répond gagne souvent la vente. L'objectif est simple : aucun client sans réponse, à n'importe quelle heure."],
            ['Un humain quand il le faut', "Le chatbot ne remplace pas votre relation client : il traite le courant et vous passe la main dès qu'une vraie discussion commence."],
            ['Vos mots, pas ceux d’un robot', "Les réponses sont écrites avec vous. Vos clients reconnaissent votre façon de parler."],
        ],
        'preuves' => [
            'titre' => 'Essayez-le sur ce site',
            'texte' => "Un assistant de discussion répond aux visiteurs de ce site, à toute heure. C'est le même principe que nous mettons en place sur votre WhatsApp : répondre tout de suite, puis passer la main.",
            'lien'  => ['/pages/contact', 'Nous écrire'],
        ],
        'faq' => [
            ['Comment fonctionne un chatbot WhatsApp ?', "Il répond automatiquement aux messages reçus sur votre numéro WhatsApp Business : questions courantes, prise d'informations, orientation. Dès qu'une demande sort du cadre prévu, la conversation vous est transmise."],
            ['Mes clients sauront-ils qu’ils parlent à un robot ?', "Oui, et c'est préférable. Ce qui compte pour eux, c'est une réponse immédiate et utile, puis un humain quand ils en ont besoin."],
            ['Faut-il changer de numéro ?', "Le chatbot fonctionne avec un compte WhatsApp Business. Nous voyons avec vous, pendant le diagnostic, comment l'installer sans perturber vos clients habituels."],
            ['Combien coûte un chatbot WhatsApp ?', "Le montant dépend du volume de messages et du nombre de situations à prévoir. Pendant le diagnostic gratuit, nous comparons ce montant aux ventes que vous perdez aujourd'hui faute de réponse rapide."],
        ],
        'articles' => [
            'chatbot-whatsapp-business-comment-ca-marche-et-pourquoi-l-adopter-pour-votre-pme',
            'votre-entreprise-repond-en-moins-de-2-minutes-meme-quand-vous-dormez-adoptez-le-chatbot-whatsapp',
            'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider',
        ],
        'voisines' => ['automatisation-taches-entreprise', 'boutique-en-ligne-abidjan', 'creation-site-web-abidjan'],
    ],

    /* ------------------------------------------------------- Automatisation */
    'automatisation-taches-entreprise' => [
        'libelle'     => 'Automatisation des tâches',
        'service'     => 'Automatisation des tâches répétitives',
        'titre'       => "Automatisation des tâches pour PME à Abidjan | EA-SERVICES",
        'description' => "Relances, saisies, réponses courantes, sauvegardes : automatisez les tâches répétitives de votre PME et récupérez ce temps chaque semaine. Diagnostic gratuit.",
        'gain'        => 'temps',
        'icone'       => 'temps',
        'image'       => '/assets/prestations/automatisation.svg',
        'h1'          => 'Automatisation des tâches pour votre PME',
        'h1_suite'    => 'Ce qui se répète tourne sans vous.',
        'badge'       => "Relances, saisies, réponses et rapports automatiques — Abidjan, Côte d'Ivoire",
        'chapo'       => "Relancer un prospect, recopier une commande d'un cahier à un fichier, "
                       . "répondre pour la dixième fois à la même question : le soir, le vrai "
                       . "travail n'a pas avancé. Ces tâches se répètent, donc elles peuvent "
                       . "tourner seules.",
        'visuel'      => ['src' => '/assets/expertises/automatisation.svg', 'alt' => "Illustration : une suite de relances qui partent automatiquement au bon moment"],
        'pertes' => [
            ['Les relances à la main', "Vous savez qu'il faudrait relancer ce prospect à trois jours, puis à sept. En pratique, vous y pensez trois semaines plus tard."],
            ['La double saisie', "Les mêmes informations sont recopiées d'un endroit à l'autre. Du temps perdu, et des erreurs à chaque copie."],
            ['Le dirigeant goulot', "Tout passe par vous : validations, réponses, vérifications. Vous êtes devenu le plafond de votre propre entreprise."],
        ],
        'livrables' => [
            "Un relevé des tâches qui se répètent chez vous, avec le temps que chacune vous coûte.",
            "Vos relances envoyées au bon moment : le jour même, à trois jours, à sept jours.",
            "Les demandes triées avant vous : les plus sérieuses remontent en premier.",
            "Vos informations recopiées automatiquement d'un outil à l'autre.",
            "Des rapports qui arrivent tout seuls, au lieu d'être préparés à la main.",
            "Une sauvegarde quotidienne, sans que personne n'y pense.",
        ],
        'pour_qui' => [
            "Vous travaillez le soir pour rattraper ce que la journée n'a pas permis.",
            "Votre équipe passe ses heures sur des tâches de recopie.",
            "Des prospects sont perdus faute d'avoir été relancés à temps.",
        ],
        'differences' => [
            ['On mesure avant d’automatiser', "On chiffre d'abord le temps que chaque tâche vous coûte. On automatise ce qui rapporte le plus, pas ce qui est le plus impressionnant."],
            ['Vous gardez le contrôle', "Rien ne part en votre nom sans validation. Les automatismes s'arrêtent ou se modifient simplement."],
            ['Nos propres outils l’utilisent', "Notre outil de prospection SFB relance, trie et suit les prospects automatiquement : nous l'utilisons pour EA-SERVICES elle-même."],
        ],
        'preuves' => null,
        'faq' => [
            ['Quelles tâches peut-on automatiser dans une PME ?', "Les relances de prospects et de factures, les réponses aux questions courantes, la recopie d'informations d'un outil à l'autre, les rapports réguliers et les sauvegardes. En règle générale : tout ce qui se répète de la même façon."],
            ['Faut-il changer tous nos outils ?', "Non. Nous partons de ce que vous utilisez déjà et nous relions les outils entre eux. Le changement est progressif."],
            ['Combien de temps peut-on récupérer ?', "Cela dépend entièrement de votre activité, et nous ne donnerons pas de chiffre avant de l'avoir mesuré. Pendant le diagnostic gratuit, nous comptons avec vous les heures passées chaque semaine sur des tâches répétitives : c'est ce chiffre-là, le vôtre, qui sert de base."],
            ['En combien de temps voit-on les résultats ?', "Les gains de temps se voient dès les premières semaines, car on commence par les tâches qui vous en coûtent le plus."],
        ],
        'articles' => [
            'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider',
            'comment-s-assurer-qu-une-consigne-est-faite-sans-relancer-ses-employes',
            'votre-entreprise-repond-en-moins-de-2-minutes-meme-quand-vous-dormez-adoptez-le-chatbot-whatsapp',
        ],
        'voisines' => ['chatbot-whatsapp-entreprise', 'logiciel-sur-mesure-abidjan', 'application-mobile-abidjan'],
    ],

    /* ------------------------------------------------------- Référencement */
    'referencement-google-abidjan' => [
        'libelle'     => 'Référencement Google',
        'service'     => 'Référencement sur Google',
        'titre'       => "Référencement Google à Abidjan : être trouvé | EA-SERVICES",
        'description' => "Référencement naturel à Abidjan : apparaître quand vos clients cherchent votre métier sur Google, avec une fiche d'entreprise complète et des pages qui répondent.",
        'gain'        => 'visibilite',
        'icone'       => 'visibilite',
        'image'       => '/assets/prestations/presence-en-ligne.svg',
        'h1'          => 'Référencement Google à Abidjan',
        'h1_suite'    => 'Apparaître quand on vous cherche.',
        'badge'       => "Référencement naturel et fiche d'entreprise Google — Abidjan, Côte d'Ivoire",
        'chapo'       => "Quelqu'un cherche exactement ce que vous vendez, à Abidjan, aujourd'hui. "
                       . "Il tape sa recherche sur son téléphone. Il ne vous trouve pas. Il appelle "
                       . "le premier nom de la liste, et ce n'est pas vous.",
        'visuel'      => ['src' => '/assets/expertises/referencement.svg', 'alt' => "Illustration : une page de résultats de recherche où l'entreprise apparaît sur la carte et dans les résultats"],
        'photo'       => ['fichier' => 'abidjan-plateau', 'ratio' => '1200/567',
                          'alt' => "Vue du Plateau, le quartier d'affaires d'Abidjan, depuis le pont Alassane Ouattara",
                          'legende' => "Quand quelqu'un cherche votre métier à Abidjan, il ne regarde que les premiers noms. Le travail consiste à y faire figurer le vôtre.",
                          'credit' => 'Edison McCullen, CC BY 4.0, Wikimedia Commons',
                          'source' => 'https://commons.wikimedia.org/wiki/File:Le_Plateau_depuis_le_Pont_ADO_%E2%80%93_Abidjan.jpg'],
        'pertes' => [
            ['Absent des recherches', "Votre site existe, mais Google ne le montre pour aucune recherche utile. Pour vos clients, vous n'existez pas."],
            ['Pas de fiche d’entreprise', "Sans fiche d'entreprise sur Google, vous n'apparaissez ni sur la carte ni dans les résultats locaux, là où se fait la majorité des appels."],
            ['Des informations contradictoires', "Un ancien numéro sur un annuaire, une autre adresse sur Facebook : Google ne sait plus quelle information croire, et vos clients non plus."],
        ],
        'livrables' => [
            "La liste des recherches réelles de vos clients, avec votre métier et votre ville.",
            "Une page par recherche importante, écrite pour y répondre vraiment.",
            "Votre fiche d'entreprise sur Google créée ou complétée : horaires, photos, téléphone, WhatsApp.",
            "Les mêmes coordonnées partout : site, fiche Google, réseaux, annuaires.",
            "Les réglages techniques qui permettent à Google de lire votre site sans erreur.",
            "Un suivi des recherches qui vous amènent des visiteurs, mois après mois.",
        ],
        'pour_qui' => [
            "Vous avez un site mais aucune demande n'en vient.",
            "Vos concurrents apparaissent sur Google, pas vous.",
            "Vous n'avez pas encore de fiche d'entreprise sur Google.",
        ],
        'differences' => [
            ['Des recherches réelles, pas des intuitions', "On part de ce que vos clients tapent vraiment, pas des mots qui vous plaisent."],
            ['Des pages utiles', "Une page qui répond honnêtement à une question est mieux classée et mieux lue qu'une page remplie de mots-clés."],
            ['Pas de promesse de première place', "Personne ne peut garantir la première position sur Google. Nous nous engageons sur le travail et nous mesurons les résultats avec vous."],
        ],
        'preuves' => null,
        'faq' => [
            ['Combien de temps pour apparaître sur Google ?', "En général deux à trois mois pour voir arriver les premières demandes venues de Google. Cela dépend de votre métier, de la concurrence et de l'état de départ de votre site."],
            ['Pouvez-vous garantir la première place sur Google ?', "Non, et méfiez-vous de ceux qui la garantissent : personne ne contrôle le classement de Google. Nous nous engageons sur le travail réalisé et sur un suivi mesuré."],
            ['Qu’est-ce qu’une fiche d’entreprise Google ?', "C'est la fiche qui apparaît sur Google et sur la carte quand on cherche votre entreprise ou votre métier près de chez soi : adresse, horaires, téléphone, photos, avis. Elle est gratuite et souvent décisive pour les recherches locales."],
            ['Faut-il refaire mon site pour être référencé ?', "Pas forcément. On commence par vérifier ce que votre site actuel permet. S'il bloque le référencement, nous vous le dirons et nous chiffrerons l'écart."],
        ],
        'articles' => [
            'votre-entreprise-existe-t-elle-vraiment-si-elle-n-apparait-pas-sur-google',
            'agence-web-cote-d-ivoire-comment-choisir-la-bonne-agence-pour-votre-pme-a-abidja',
        ],
        'voisines' => ['creation-site-web-abidjan', 'boutique-en-ligne-abidjan', 'chatbot-whatsapp-entreprise'],
    ],

    /* ------------------------------------------------- Maintenance & sauvegarde */
    'maintenance-informatique-abidjan' => [
        'libelle'     => 'Maintenance informatique',
        'service'     => 'Maintenance informatique et sauvegarde',
        'titre'       => "Maintenance informatique et sauvegarde à Abidjan | EA-SERVICES",
        'description' => "Maintenance informatique, sauvegarde et hébergement pour PME à Abidjan : vos données survivent à n'importe quelle panne, et un interlocuteur répond en moins de 2 heures.",
        'gain'        => 'serenite',
        'icone'       => 'serenite',
        'image'       => '/assets/prestations/infrastructure.svg',
        'h1'          => 'Maintenance informatique et sauvegarde à Abidjan',
        'h1_suite'    => 'Dormez tranquille.',
        'badge'       => "Maintenance, sauvegarde et hébergement pour entreprises — Abidjan, Côte d'Ivoire",
        'chapo'       => "Le fichier de vos clients est sur un seul ordinateur. Le jour où cet "
                       . "ordinateur tombe, est volé ou prend l'eau, vous perdez des années de "
                       . "travail. Ce n'est pas une question de « si », c'est une question de « quand ».",
        'visuel'      => ['src' => '/assets/expertises/maintenance.svg', 'alt' => "Illustration : un tableau de surveillance avec la sauvegarde du jour réussie à deux endroits"],
        'pertes' => [
            ['Une seule copie', "Vos données importantes n'existent qu'à un seul endroit. Une panne suffit à tout perdre."],
            ['La panne découverte trop tard', "Le site ou la messagerie tombe, et ce sont vos clients qui vous préviennent."],
            ['Personne à appeler', "Quand un problème survient, vous cherchez quelqu'un de disponible, et vous perdez une journée."],
        ],
        'livrables' => [
            "Vos données recopiées automatiquement à deux endroits distincts, chaque jour.",
            "L'hébergement de votre site et de vos outils, avec certificat de sécurité.",
            "Une surveillance permanente : si quelque chose tombe, nous le savons avant vos clients.",
            "Vos obligations sur les données personnelles respectées : consentement, suppression sur demande.",
            "La maintenance de vos postes et de vos outils.",
            "Un interlocuteur qui répond en moins de deux heures quand il y a un problème.",
        ],
        'pour_qui' => [
            "Vos données importantes ne sont sauvegardées nulle part, ou vous n'en êtes pas sûr.",
            "Vous avez déjà perdu des fichiers à cause d'une panne ou d'un vol.",
            "Vous n'avez pas de service informatique et vous dépannez vous-même.",
        ],
        'differences' => [
            ['On vérifie que la sauvegarde fonctionne', "Une sauvegarde qu'on n'a jamais essayé de restaurer n'est pas une sauvegarde. Nous vérifions qu'elle repart vraiment."],
            ['La prévention plutôt que le dépannage', "La surveillance détecte les problèmes avant qu'ils ne vous coûtent une journée."],
            ['Un interlocuteur, pas un standard', "Vous savez qui appeler, et il connaît votre installation."],
        ],
        'preuves' => null,
        'faq' => [
            ['Pourquoi sauvegarder à deux endroits ?', "Parce qu'un incident qui touche un endroit — panne, vol, incendie, inondation — ne touche pas l'autre. Une seule copie, même sur un disque externe posé à côté de l'ordinateur, ne suffit pas."],
            ['En combien de temps intervenez-vous ?', "Un interlocuteur vous répond en moins de deux heures quand il y a un problème. Sur place, nous intervenons dans tout le district d'Abidjan."],
            ['Hébergez-vous les sites et les outils ?', "Oui. Nous hébergeons, sauvegardons et surveillons les sites et outils que nous mettons en place, avec certificat de sécurité."],
            ['Combien coûte la maintenance informatique ?', "Le montant dépend du nombre de postes, de la quantité de données et du niveau de surveillance. Pendant le diagnostic gratuit, nous le comparons à ce que vous coûterait une journée d'arrêt ou une perte de données."],
        ],
        'articles' => [
            'votre-entreprise-existe-t-elle-vraiment-si-elle-n-apparait-pas-sur-google',
        ],
        'voisines' => ['logiciel-sur-mesure-abidjan', 'creation-site-web-abidjan', 'formation-informatique-ia-abidjan'],
    ],

    /* ------------------------------------------------------- Formation */
    'formation-informatique-ia-abidjan' => [
        'libelle'     => 'Formation informatique et IA',
        'service'     => 'Formation en informatique et intelligence artificielle',
        'titre'       => "Formation informatique et IA pour entreprises à Abidjan | EA-SERVICES",
        'description' => "Formation en informatique, développement web et intelligence artificielle à Abidjan, pour vos équipes ou vos étudiants. Des cas concrets, tirés de votre métier.",
        'gain'        => 'serenite',
        'icone'       => 'document',
        'image'       => '/assets/prestations/formation.svg',
        'h1'          => 'Formation informatique et intelligence artificielle à Abidjan',
        'h1_suite'    => "Pour que votre équipe n'ait plus besoin de nous au quotidien.",
        'badge'       => "Informatique, développement web, intelligence artificielle — Abidjan, Côte d'Ivoire",
        'chapo'       => "Un outil que personne ne sait utiliser ne rapporte rien. L'intelligence "
                       . "artificielle peut faire gagner des heures chaque semaine, à condition de "
                       . "savoir quoi lui demander et quoi vérifier. C'est ce que nous apprenons à "
                       . "vos équipes, sur leurs propres tâches.",
        'visuel'      => ['src' => '/assets/expertises/formation.svg', 'alt' => "Illustration : une formation à l'intelligence artificielle appliquée à un vrai document de travail"],
        'photo'       => ['fichier' => 'formation-informatique-abidjan', 'ratio' => '4/3',
                          'alt' => "Une salle de formation informatique à Abidjan, un formateur face à des participants sur ordinateur",
                          'legende' => "Une formation informatique à Abidjan (photo d'illustration, atelier du WikiClub Niangon). Nos formations se déroulent sur le même principe : sur ordinateur, sur des cas concrets.",
                          'credit' => 'Manouka, CC0, Wikimedia Commons',
                          'source' => 'https://commons.wikimedia.org/wiki/File:Formation_des_leaders_du_WikiClub_Niangon_20_novembre_2024_05.jpg'],
        'pertes' => [
            ['Des outils payés, pas utilisés', "Les logiciels sont là, mais l'équipe n'en exploite qu'une petite partie. Le reste est payé pour rien."],
            ['L’IA testée puis abandonnée', "On a essayé, le résultat était décevant, on a arrêté. Le plus souvent, il manquait seulement la bonne méthode."],
            ['La dépendance au prestataire', "Chaque petite modification demande d'appeler quelqu'un. Du temps et de l'argent perdus à chaque fois."],
        ],
        'livrables' => [
            "Un programme construit à partir des tâches réelles de votre équipe.",
            "Les bases de l'informatique au quotidien pour ceux qui en ont besoin.",
            "L'usage de l'intelligence artificielle pour rédiger, résumer, analyser et répondre.",
            "Le développement d'applications web, pour les équipes et les étudiants qui veulent aller plus loin.",
            "Des exercices sur vos propres documents, pas sur des exemples théoriques.",
            "Des supports que l'équipe garde après la formation.",
        ],
        'pour_qui' => [
            "Votre équipe utilise mal des outils que vous payez déjà.",
            "Vous voulez que vos collaborateurs utilisent l'intelligence artificielle sans risque d'erreur.",
            "Vous êtes un centre de formation et vous cherchez un intervenant en développement web.",
        ],
        'differences' => [
            ['Sur vos tâches, pas sur des cas d’école', "Chaque exercice part d'une tâche que votre équipe fait réellement. Le gain se voit dès le lendemain."],
            ['L’autonomie comme objectif', "Un prestataire dont on ne peut pas se passer est un risque, pas un partenaire. La formation vise votre autonomie."],
            ['Ce qu’il faut vérifier', "L'intelligence artificielle se trompe parfois avec aplomb. Nous apprenons aussi à vérifier ses réponses."],
        ],
        'preuves' => [
            'titre' => 'Avis de DKER TECHNOLOGY',
            'texte' => "DKER TECHNOLOGY, cabinet de formation en informatique, indique avoir fait appel à EA-SERVICES comme consultant pour former plus de trente étudiants en informatique et en développement d'applications web.",
            'lien'  => null,
        ],
        'faq' => [
            ['À qui s’adressent vos formations ?', "Aux équipes d'entreprise qui veulent mieux utiliser leurs outils et l'intelligence artificielle, et aux centres de formation qui cherchent un intervenant en informatique ou en développement web."],
            ['Faut-il un niveau en informatique ?', "Non. Le programme part du niveau réel de chaque groupe, des bases jusqu'au développement d'applications web."],
            ['La formation se fait-elle sur place ?', "Sur place dans le district d'Abidjan, ou à distance ailleurs en Côte d'Ivoire."],
            ['Combien coûte une formation ?', "Le montant dépend du nombre de personnes, de la durée et du programme. Pendant le diagnostic gratuit, nous le comparons au temps que la formation doit faire gagner à votre équipe."],
        ],
        'articles' => [
            'qu-est-ce-qu-un-agent-ia-pour-entreprise-et-comment-peut-il-vous-aider',
            'creation-de-site-web-ia-ce-que-ca-change-vraiment-pour-une-pme-ivoirienne',
        ],
        'voisines' => ['automatisation-taches-entreprise', 'logiciel-sur-mesure-abidjan', 'maintenance-informatique-abidjan'],
    ],
];
