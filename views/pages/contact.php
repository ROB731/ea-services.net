<?php
/**
 * Contact.
 *
 * Le formulaire fonctionne sans JavaScript (POST classique, réponse en pleine
 * page). Avec JavaScript, il s'envoie sans rechargement. Sur un marché
 * majoritairement mobile et en réseau parfois lent, le repli n'est pas
 * théorique.
 *
 * @var string|null $etatEnvoi 'ok' | 'erreur' | null
 * @var string|null $messageEnvoi
 * @var array $ancien Valeurs à réafficher après une erreur
 */
$c = (array)cfg('contact');
$ancien = $ancien ?? [];
?>

<section class="hero hero--photos">
  <?php $heroPhoto = 'nuit'; require dirname(__DIR__) . '/partials/hero-photo.php'; ?>
  <div class="contenant">
    <p class="sur-titre">Contact</p>
    <h1 class="mesure">Commençons par une conversation</h1>
    <p class="chapo mesure">
      Trente minutes, gratuit, sans engagement. Nous cherchons d'abord à
      comprendre où vous perdez du temps et des clients. Nous ne vendons rien
      pendant cet échange.
    </p>
  </div>
</section>

<section class="section">
  <div class="contenant">
    <div class="grille grille--2">

      <div>
        <h2>Trois façons de nous joindre</h2>

        <div class="carte" style="margin-bottom:1rem">
          <h3><?= icone('whatsapp', 'ico ico--lg') ?> WhatsApp — le plus rapide</h3>
          <p class="doux">Écrivez-nous directement. Réponse en moins de deux heures pendant les heures ouvrables.</p>
          <a class="bouton bouton--whatsapp bouton--large" href="<?= e(whatsapp()) ?>" target="_blank" rel="noopener">
            Ouvrir WhatsApp <?= icone('fleche') ?>
          </a>
        </div>

        <div class="carte" style="margin-bottom:1rem">
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

        <div class="carte" style="margin-top:1rem">
          <h3><?= icone('lieu', 'ico ico--lg') ?> Où nous sommes</h3>
          <p><?= e($c['quartier']) ?>, <?= e($c['ville']) ?> — <?= e($c['pays']) ?></p>
          <p class="doux" style="margin:0">Nous intervenons dans tout le district d'Abidjan et à distance ailleurs en Côte d'Ivoire.</p>
        </div>
      </div>

      <div>
        <h2>Ou écrivez-nous ici</h2>
        <p class="doux">Nous répondons sous 24 heures ouvrées.</p>

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

          <button type="submit" class="bouton bouton--or bouton--large">
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

<section class="section section--alt">
  <div class="contenant">
    <p class="sur-titre">Ce qui va se passer</p>
    <h2 class="mesure">Le déroulé des trente minutes</h2>
    <ol class="etapes" style="margin-top:1.5rem;max-width:44rem">
      <li class="etape"><div><h3>Vous racontez votre semaine type</h3><p class="doux">Ce qui vous prend du temps, ce qui vous échappe, ce qui vous inquiète.</p></div></li>
      <li class="etape"><div><h3>Nous chiffrons vos pertes</h3><p class="doux">En heures et en FCFA, à partir de vos propres chiffres.</p></div></li>
      <li class="etape"><div><h3>Nous nommons vos deux priorités</h3><p class="doux">Avec le gain attendu et le délai. Vous repartez avec, que vous travailliez avec nous ou non.</p></div></li>
    </ol>
  </div>
</section>

<?php /* Questions fréquentes — même contenu que les données structurées
         FAQPage (Seo::questionsFrequentes), affiché ici pour de vrai. */ ?>
<section class="section">
  <div class="contenant">
    <div class="entete-section">
      <p class="sur-titre">Avant de nous écrire</p>
      <h2 class="mesure">Les questions qu'on nous pose le plus</h2>
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
