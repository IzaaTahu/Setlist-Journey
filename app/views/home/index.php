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
    <p class="playbill-kicker">Empat Babak dalam Satu Pertunjukan</p>
    <div class="playbill">
      <div class="playbill-row">
        <span class="playbill-num">I</span>
        <div class="playbill-body">
          <p class="playbill-title">Peta Interaktif</p>
          <p class="playbill-desc">Jelajahi tiap lagu lewat peta yang terbuka satu per satu.</p>
        </div>
        <span class="playbill-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
            <path d="M9 4L4 6v14l5-2 6 2 5-2V4l-5 2-6-2z"/>
            <path d="M9 4v14M15 6v14"/>
          </svg>
        </span>
      </div>
      <div class="playbill-row">
        <span class="playbill-num">II</span>
        <div class="playbill-body">
          <p class="playbill-title">Lore &amp; Trivia</p>
          <p class="playbill-desc">Cerita dan fakta tersembunyi di balik setiap lagu.</p>
        </div>
        <span class="playbill-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
            <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
          </svg>
        </span>
      </div>
      <div class="playbill-row">
        <span class="playbill-num">III</span>
        <div class="playbill-body">
          <p class="playbill-title">Quest &amp; Tantangan</p>
          <p class="playbill-desc">Selesaikan tantangan unik untuk membuka lagu berikutnya.</p>
        </div>
        <span class="playbill-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
            <circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/>
          </svg>
        </span>
      </div>
      <div class="playbill-row">
        <span class="playbill-num">IV</span>
        <div class="playbill-body">
          <p class="playbill-title">Milestone</p>
          <p class="playbill-desc">Hadiah kejutan di tengah perjalananmu.</p>
        </div>
        <span class="playbill-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
            <path d="M8 21h8M12 17v4"/><path d="M7 4h10v5a5 5 0 01-10 0V4z"/>
            <path d="M7 5H4.5A2.5 2.5 0 007 9.5M17 5h2.5A2.5 2.5 0 0117 9.5"/>
          </svg>
        </span>
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