<?php
/**
 * Prestations — direction v2.
 *
 * Troisième étage de la doctrine du site : la perte (pages précédentes), le
 * gain chiffré (Services), la méthode (« Comment on travaille », sur
 * l'accueil et À propos) — et ici, ce qu'il y a concrètement dans la boîte à
 * outils. Cette page arrive APRÈS que la confiance soit construite ailleurs :
 * c'est la seule page du site où les moyens sont nommés directement, parce
 * qu'à ce stade le visiteur a déjà compris le résultat qu'ils servent.
 *
 * Chaque famille porte un renvoi explicite vers l'un des cinq gains
 * (config/site.php) plutôt que de re-développer tout le couple perte/gain —
 * déjà fait sur /pages/services, pas la peine de le répéter ici.
 */
$prestations = [
    [
        'gain' => 'Visibilité', 'icone' => 'visibilite', 'image' => '/assets/prestations/presence-en-ligne.svg',
        'titre' => 'Présence en ligne',
        'texte' => 'Ce qui vous rend trouvable et crédible, du premier clic jusqu\'à l\'achat.',
        'points' => [
            'Site vitrine, pour présenter votre activité',
            'Boutique en ligne',
            'Gestion de vos pages (réseaux sociaux)',
        ],
    ],
    [
        'gain' => "Chiffre d'affaires", 'icone' => 'croissance', 'image' => '/assets/prestations/developpement-sur-mesure.svg',
        'titre' => 'Développement sur mesure',
        'texte' => "Quand un site ou un outil standard ne suffit plus, notre équipe de développement de "
                 . "logiciel construit exactement ce qu'il vous faut.",
        'points' => [
            'Développement de logiciel sur mesure',
            'Application web',
            'Application mobile',
        ],
    ],
    [
        'gain' => 'Temps', 'icone' => 'temps', 'image' => '/assets/prestations/automatisation.svg',
        'titre' => 'Automatisation',
        'texte' => 'Les tâches répétitives tournent sans vous.',
        'points' => [
            'Relances automatiques',
            'Réponses WhatsApp',
            'Tâches répétitives prises en charge',
        ],
    ],
    [
        'gain' => 'Sérénité', 'icone' => 'serenite', 'image' => '/assets/prestations/formation.svg',
        'titre' => 'Formation',
        'texte' => "Pour que votre équipe n'ait plus besoin de nous sur le quotidien.",
        'points' => [
            'Informatique',
            'Intelligence artificielle',
        ],
    ],
    [
        'gain' => "Chiffre d'affaires", 'icone' => 'cible', 'image' => '/assets/prestations/accompagnement.svg',
        'titre' => 'Accompagnement',
        'texte' => "Un regard extérieur régulier sur vos décisions, pas un cours ponctuel.",
        'points' => [
            'Coaching',
        ],
    ],
    [
        'gain' => 'Sérénité', 'icone' => 'document', 'image' => '/assets/prestations/infrastructure.svg',
        'titre' => 'Infrastructure',
        'texte' => 'Ce qui continue de tourner pendant que vous ne regardez pas.',
        'points' => [
            'Maintenance informatique',
            'Sauvegarde et hébergement dans le cloud',
        ],
    ],
];
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Nos prestations</span>
      <span class="etiquette-section__texte">Ce qu'il y a concrètement dans la boîte à outils</span>
    </p>
    <h1 class="mesure titre-machine">Comment vos résultats<em>prennent forme.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Développement de logiciel sur mesure &amp; développement web — Abidjan</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Chaque gain chiffré ailleurs sur ce site s'appuie sur des moyens précis.
      Les voici, sans détour ni jargon — et à côté de chacun, le résultat
      auquel il sert.
    </p>
  </div>
</section>

<?php /* --------------------------------------------------- Les 6 familles */ ?>
<section class="section section--papier">
  <div class="page-large">
    <div class="grille grille--3">
      <?php foreach ($prestations as $p): ?>
        <article class="carte" style="padding:0;overflow:hidden">
          <img src="<?= e($p['image']) ?>" alt="" width="400" height="220"
               style="width:100%;aspect-ratio:400/220;object-fit:cover" loading="lazy">
          <div style="padding:1.5rem">
            <span class="chapeau">Sert le gain — <?= e($p['gain']) ?></span>
            <h3><?= e($p['titre']) ?></h3>
            <p class="doux"><?= e($p['texte']) ?></p>
            <ul class="liste-cochee" style="margin-top:.75rem">
              <?php foreach ($p['points'] as $point): ?>
                <li><?= e($point) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* ------------------------------------------------- Par où commencer */ ?>
<section class="section section--claire">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Par où commencer</span>
      <span class="etiquette-section__texte">Pas besoin de tout prendre d'un coup</span>
    </p>
    <h2 class="mesure">Vous ne repartez pas<span class="suite">avec un catalogue.</span></h2>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Le diagnostic sert exactement à ça : identifier vos deux plus grosses
      pertes, puis ne retenir dans cette liste que ce qui les traite
      vraiment — rien de plus.
    </p>
  </div>
</section>

<?php /* ------------------------------------------------------ Le diagnostic */ ?>
<section class="diagnostic">
  <div class="page-large diagnostic__inner">
    <div>
      <p class="etiquette-section">
        <span class="etiquette-section__index">Le prochain chiffre</span>
        <span class="etiquette-section__texte"><?= e(cfg('cta.titre')) ?></span>
      </p>
      <h2 class="mesure">Trente minutes pour<span class="suite">savoir lesquels vous concernent.</span></h2>
      <p class="mesure-large doux" style="margin-top:1.25rem">
        Nous ne vendons rien pendant cet échange. Vous repartez avec vos deux
        priorités et les moyens exacts, parmi ceux-ci, qui les traitent.
      </p>
    </div>
    <div class="diagnostic__actions">
      <a class="bouton bouton--safran" href="/diagnostic">
        <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
      </a>
      <a class="bouton bouton--contour-clair" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
        <?= icone('whatsapp') ?> Écrire sur WhatsApp
      </a>
      <span class="diagnostic__note"><?= e(cfg('cta.promesse')) ?></span>
    </div>
  </div>
</section>
