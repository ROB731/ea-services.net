<?php
/**
 * Contact — direction v2.
 *
 * Le CONTENU et le FORMULAIRE sont repris a l'identique : memes champs, memes
 * intitules, meme jeton CSRF, meme piege a robots, meme action POST. Le
 * formulaire continue de fonctionner SANS JavaScript (envoi classique, reponse
 * en pleine page) — sur un marche mobile et en reseau parfois lent, ce repli
 * n'est pas theorique.
 *
 * Seule la forme change : vocabulaire v2 (page-large, etiquette-section,
 * carte, bouton--safran) au lieu du vocabulaire v1.
 *
 * @var string|null $etatEnvoi 'ok' | 'erreur' | null
 * @var string|null $messageEnvoi
 * @var array $ancien Valeurs a reafficher apres une erreur
 */
$c = (array)cfg('contact');
$ancien = $ancien ?? [];
?>

<?php /* ------------------------------------------------------ L'ouverture */ ?>
<section class="section section--encre">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Contact</span>
      <span class="etiquette-section__texte">Trente minutes, gratuit, sans engagement</span>
    </p>
    <h1 class="mesure titre-machine">Commençons par<em>une conversation.</em></h1>
    <p class="heros__badge"><?= icone('cible') ?> Contactez notre agence de développement web à Abidjan</p>
    <p class="mesure-large doux" style="margin-top:1.25rem">
      Trente minutes, gratuit, sans engagement. Nous cherchons d'abord à
      comprendre où vous perdez du temps et des clients. Nous ne vendons rien
      pendant cet échange.
    </p>
  </div>
</section>

<?php /* --------------------------------------- Les canaux et le formulaire */ ?>
<section class="section section--papier">
  <div class="page-large">
    <div class="grille grille--2">

      <div>
        <h2>Trois façons de nous joindre</h2>

        <div class="pile" style="margin-top:1.5rem">
          <div class="carte">
            <h3><?= icone('whatsapp', 'ico ico--lg') ?> WhatsApp — le plus rapide</h3>
            <p class="doux">Écrivez-nous directement. Réponse en moins de deux heures pendant les heures ouvrables.</p>
            <a class="bouton bouton--whatsapp bouton--large" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
              Ouvrir WhatsApp <?= icone('fleche') ?>
            </a>
          </div>

          <div class="carte">
            <h3><?= icone('telephone', 'ico ico--lg') ?> Téléphone</h3>
            <p class="doux">Si vous préférez parler de vive voix.</p>
            <a class="bouton bouton--contour bouton--large" href="tel:<?= e($c['telephone_e164']) ?>">
              <?= e($c['telephone']) ?>
            </a>
          </div>

          <div class="carte">
            <h3><?= icone('courriel', 'ico ico--lg') ?> Courriel</h3>
            <p class="doux">Pour une demande détaillée ou un document à joindre.</p>
            <a class="bouton bouton--contour bouton--large" href="mailto:<?= e($c['email']) ?>">
              <?= e($c['email']) ?>
            </a>
          </div>

          <div class="carte">
            <h3><?= icone('lieu', 'ico ico--lg') ?> Où nous sommes</h3>
            <p><?= e($c['quartier']) ?>, <?= e($c['ville']) ?> — <?= e($c['pays']) ?></p>
            <p class="doux" style="margin:0">Nous intervenons dans tout le district d'Abidjan et à distance ailleurs en Côte d'Ivoire.</p>
          </div>
        </div>
      </div>

      <div>
        <h2>Ou écrivez-nous ici</h2>
        <p class="doux">Nous répondons sous 24 heures ouvrées.</p>

        <?php /* Raccourci vers le diagnostic automatique : quelqu'un qui hesite
                 a laisser ses coordonnees obtient quand meme un chiffre. La
                 doctrine dit « vous repartez avec, que vous travailliez avec
                 nous ou non » — autant le proposer avant le formulaire. */ ?>
        <div class="carte" style="margin-bottom:1.5rem">
          <h3>Pas envie d'attendre ?</h3>
          <p class="doux">
            Répondez à cinq questions et obtenez tout de suite vos deux plus
            grosses pertes, chiffrées. Deux minutes, sans laisser vos coordonnées.
          </p>
          <a class="bouton bouton--contour bouton--large" href="/diagnostic">
            Chiffrer mes pertes maintenant <?= icone('fleche') ?>
          </a>
        </div>

        <?php if (!empty($etatEnvoi)): ?>
          <div class="alerte alerte--<?= $etatEnvoi === 'ok' ? 'ok' : 'erreur' ?>">
            <?= e($messageEnvoi) ?>
          </div>
        <?php endif; ?>

        <div id="retour-contact" hidden></div>

        <form id="formulaire-contact" method="post" action="/pages/contact"
              data-courriel="<?= e($c['email']) ?>" novalidate>
          <?= \EA\Core\Csrf::champ() ?>

          <?php /* Piège à robots : un humain ne remplit jamais ce champ, il ne le voit pas. */ ?>
          <div class="piege" aria-hidden="true">
            <label for="site">Ne remplissez pas ce champ</label>
            <input type="text" id="site" name="site" tabindex="-1" autocomplete="off">
          </div>

          <div class="champ">
            <label for="nom">Votre nom <span aria-hidden="true">*</span></label>
            <input type="text" id="nom" name="nom" required autocomplete="name"
                   value="<?= e($ancien['nom'] ?? '') ?>">
          </div>

          <div class="champ">
            <label for="entreprise">Votre entreprise</label>
            <input type="text" id="entreprise" name="entreprise" autocomplete="organization"
                   value="<?= e($ancien['entreprise'] ?? '') ?>">
          </div>

          <div class="champ">
            <label for="telephone">Téléphone ou WhatsApp <span aria-hidden="true">*</span></label>
            <input type="tel" id="telephone" name="telephone" required autocomplete="tel"
                   inputmode="tel" placeholder="01 02 03 04 05"
                   value="<?= e($ancien['telephone'] ?? '') ?>">
            <span class="champ__aide">C'est par là que nous vous répondrons le plus vite.</span>
          </div>

          <div class="champ">
            <label for="email">Courriel</label>
            <input type="email" id="email" name="email" autocomplete="email" inputmode="email"
                   value="<?= e($ancien['email'] ?? '') ?>">
          </div>

          <div class="champ">
            <label for="besoin">Ce qui vous fait perdre le plus de temps ou de clients aujourd'hui <span aria-hidden="true">*</span></label>
            <textarea id="besoin" name="besoin" required
                      placeholder="Exemple : je reçois des demandes sur WhatsApp mais je n'ai pas le temps de toutes les rappeler."><?= e($ancien['besoin'] ?? '') ?></textarea>
            <span class="champ__aide">Deux phrases suffisent. C'est le point de départ du diagnostic.</span>
          </div>

          <button type="submit" class="bouton bouton--safran bouton--large">
            <?= e(cfg('cta.libelle')) ?> <?= icone('fleche') ?>
          </button>
          <p class="champ__aide" style="margin-top:.75rem">
            Vos informations servent uniquement à vous recontacter. Elles ne sont
            ni revendues, ni transmises à un tiers.
          </p>
        </form>
      </div>

    </div>
  </div>
</section>

<?php /* -------------------------------------------------- Ce qui va se passer */ ?>
<section class="section section--sable">
  <div class="page-large">
    <p class="etiquette-section">
      <span class="etiquette-section__index">Ce qui va se passer</span>
      <span class="etiquette-section__texte">Le déroulé des trente minutes</span>
    </p>
    <h2 class="mesure">Le déroulé<span class="suite">des trente minutes.</span></h2>
    <ol class="etapes" style="margin-top:2rem;max-width:44rem">
      <li class="etape"><div><h3>Vous racontez votre semaine type</h3><p class="doux">Ce qui vous prend du temps, ce qui vous échappe, ce qui vous inquiète.</p></div></li>
      <li class="etape"><div><h3>Nous chiffrons vos pertes</h3><p class="doux">En heures et en FCFA, à partir de vos propres chiffres.</p></div></li>
      <li class="etape"><div><h3>Nous nommons vos deux priorités</h3><p class="doux">Avec le gain attendu et le délai. Vous repartez avec, que vous travailliez avec nous ou non.</p></div></li>
    </ol>
  </div>
</section>

<?php /* Questions fréquentes — même contenu que les données structurées
         FAQPage (Seo::questionsFrequentes), affiché ici pour de vrai. */ ?>
<section class="section section--claire">
  <div class="page-large">
    <div class="entete-section">
      <p class="etiquette-section">
        <span class="etiquette-section__index">Avant de nous écrire</span>
        <span class="etiquette-section__texte">Les questions qu'on nous pose le plus</span>
      </p>
      <h2 class="mesure">Les questions<span class="suite">qu'on nous pose le plus.</span></h2>
    </div>

    <div class="pile" style="max-width:44rem">
      <?php foreach ((array)cfg('faq', []) as $qr): ?>
        <details class="faq carte">
          <summary><?= e($qr['question']) ?><?= icone('fleche', 'ico faq__fleche') ?></summary>
          <p class="doux"><?= e($qr['reponse']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
