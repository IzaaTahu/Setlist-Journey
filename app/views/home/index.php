<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/landing.css">
</head>
<body>

  <!-- Opening screen -->
  <div id="opening">
    <p class="opening-title">Setlist <em>Journey</em></p>
    <span class="opening-sub">Sebuah perjalanan melintasi panggung JKT48</span>
    <button class="btn-open-curtain" id="btnOpen">Buka Tirai</button>
  </div>

  <!-- Proscenium -->
  <div class="arch"></div>
  <div class="pillar pillar-left"></div>
  <div class="pillar pillar-right"></div>

  <!-- Curtains -->
  <div class="curtain-left"></div>
  <div class="curtain-right"></div>

  <!-- Navbar -->
  <nav class="nav">
    <a href="<?= url('') ?>" class="nav-brand">Setlist Journey</a>
    <div class="nav-links">
     <a href="<?= url('worldmap') ?>">World Map</a>
      <?php if ($isLoggedIn): ?>
        <a href="<?= url('logout') ?>">Logout</a>
      <?php else: ?>
        <a href="<?= url('login') ?>">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Stage / Hero -->
  <section class="stage">
    <div class="spotlight spotlight-1"></div>
    <div class="spotlight spotlight-2"></div>
    <div class="spotlight spotlight-3"></div>

    <div class="hero">
      <p class="stage-label">JKT48 · Theater Experience</p>
      <h1 class="hero-title">
        Setlist
        <em>Journey</em>
      </h1>
      <p class="hero-sub">
        Setiap setlist adalah dunia.<br>
        Mana yang ingin kamu jelajahi?
      </p>
      <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <a href="<?= url('worldmap') ?>" class="btn-enter">
        Masuk ke Teater
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
      <?php if (!$isLoggedIn): ?>
        <p class="auth-note">
          <a href="<?= url('login') ?>">Login</a> agar progressmu tersimpan
        </p>
      <?php endif; ?>
    </div>

    <div class="scroll-hint">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- About -->
  <section class="about">
    <p class="about-label">Tentang</p>
    <h2 class="about-title">
      Lebih dari sekadar<br>
      <em>daftar lagu</em>
    </h2>
    <p class="about-body">
      Setlist Journey adalah cara berbeda untuk menikmati setlist JKT48.
      Bukan sekadar membaca judul lagu — tapi menjelajahi cerita di baliknya,
      satu per satu, seperti petualangan yang sesungguhnya.
      Setiap lagu punya lore, trivia, dan tantangan kecil yang menunggumu.
    </p>
    <div class="divider">
      <div class="divider-line"></div>
      <div class="divider-diamond"></div>
      <div class="divider-line"></div>
    </div>
    <div class="features">
      <div class="feature-card">
        <span class="feature-icon">🗺️</span>
        <p class="feature-title">Peta Interaktif</p>
        <p class="feature-desc">Jelajahi tiap lagu lewat peta yang terbuka satu per satu.</p>
      </div>
      <div class="feature-card">
        <span class="feature-icon">📖</span>
        <p class="feature-title">Lore & Trivia</p>
        <p class="feature-desc">Cerita dan fakta tersembunyi di balik setiap lagu.</p>
      </div>
      <div class="feature-card">
        <span class="feature-icon">🎯</span>
        <p class="feature-title">Quest & Tantangan</p>
        <p class="feature-desc">Selesaikan tantangan unik untuk membuka lagu berikutnya.</p>
      </div>
      <div class="feature-card">
        <span class="feature-icon">🏆</span>
        <p class="feature-title">Milestone</p>
        <p class="feature-desc">Hadiah kejutan di tengah perjalananmu.</p>
      </div>
    </div>
  </section>

  <!-- CTA Bottom -->
  <div class="cta-bottom">
    <p>"Tirai sudah terbuka.<br>Panggung menunggumu."</p>
    <a href="<?= url('worldmap') ?>" class="btn-enter">
      Mulai Perjalanan
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M5 12h14M12 5l7 7-7 7"/>
      </svg>
    </a>
  </div>

  <script src="<?= BASE_URL ?>/public/assets/js/landing.js"></script>
</body>
</html>