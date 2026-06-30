<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'Setlist Journey') ?></title>
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<nav class="navbar">
  <a href="/" class="navbar-brand">🎵 Setlist Journey</a>
  <div class="navbar-links">
    <a href="/worldmap">World Map</a>
    <?php if ($isLoggedIn ?? false): ?>
      <span><?= htmlspecialchars(Session::get('user_nama')) ?></span>
      <a href="/logout">Logout</a>
    <?php else: ?>
      <a href="/login">Login</a>
    <?php endif; ?>
  </div>
</nav>
<main>
