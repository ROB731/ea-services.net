<?php
/** @var string $erreur */
use EA\Core\Csrf;
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Connexion — EA-SERVICES</title>
<link rel="icon" href="/assets/logo-ea-services.jpeg" type="image/jpeg">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="/css/ea.css">
</head>
<body>
<main class="contenant" style="max-width:26rem;padding-block:4rem">
  <div style="text-align:center;margin-bottom:2rem">
    <img src="/assets/logo-ea-services.jpeg" width="72" height="72" alt="EA-SERVICES"
         style="border-radius:50%;margin:0 auto 1rem">
    <h1 style="font-size:1.5rem">Administration</h1>
  </div>

  <?php if ($erreur !== ''): ?>
    <div class="alerte alerte--erreur"><?= e($erreur) ?></div>
  <?php endif; ?>

  <form method="post" action="/admin/connexion" class="carte">
    <?= Csrf::champ() ?>
    <div class="champ">
      <label for="email">Adresse électronique</label>
      <input type="email" id="email" name="email" required autocomplete="username" autofocus>
    </div>
    <div class="champ">
      <label for="mdp">Mot de passe</label>
      <input type="password" id="mdp" name="mot_de_passe" required autocomplete="current-password">
    </div>
    <button type="submit" class="bouton bouton--marine bouton--large">Se connecter</button>
  </form>

  <p style="text-align:center;margin-top:1.5rem">
    <a href="/">Retour au site</a>
  </p>
</main>
</body>
</html>
