<?php
$isLoggedIn = isset($_SESSION['user_id']);
$temaWarna  = htmlspecialchars($chapter['tema_warna'] ?? '#4A90B8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memory Box — <?= htmlspecialchars($chapter['judul']) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/final.css">
  <style>:root { --tema: <?= $temaWarna ?>; }</style>
</head>
<body data-tema="<?= $temaWarna ?>">

  <canvas id="deco-canvas"></canvas>

  <!-- Navbar -->
  <nav class="nav">
    <a href="<?= url('worldmap') ?>" class="nav-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
      </svg>
      World Map
    </a>
    <span class="nav-chapter"><?= htmlspecialchars($chapter['judul']) ?></span>
    <?php if ($isLoggedIn): ?>
      <a href="<?= url('logout') ?>" class="nav-logout">Logout</a>
    <?php else: ?>
      <a href="<?= url('login') ?>" class="nav-logout">Login</a>
    <?php endif; ?>
  </nav>

  <!-- ══ HERO ══ -->
  <section class="final-hero">
    <div class="hero-content">
      <div class="hero-badge">✦</div>
      <p class="hero-label">Chapter Selesai</p>
      <h1 class="hero-title">Memory <em>Box</em></h1>
      <p class="hero-chapter"><?= htmlspecialchars($chapter['judul']) ?></p>

      <div class="hero-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>

      <!-- Statistik -->
      <div class="stats-row">
        <div class="stat-card">
          <span class="stat-num"><?= $stats['total_lagu'] ?></span>
          <span class="stat-label">Lagu Dijelajahi</span>
        </div>
        <div class="stat-divider">·</div>
        <div class="stat-card">
          <span class="stat-num"><?= $stats['total_lagu'] ?></span>
          <span class="stat-label">Quest Diselesaikan</span>
        </div>
        <div class="stat-divider">·</div>
        <div class="stat-card">
          <span class="stat-num">1</span>
          <span class="stat-label">Chapter Tamat</span>
        </div>
      </div>

      <button class="scroll-down-btn" onclick="document.getElementById('guestbook-section').scrollIntoView({behavior:'smooth'})">
        Tinggalkan Pesanmu
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
      </button>
    </div>

    <div class="scroll-hint">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- ══ RECAP LAGU ══ -->
  <section class="recap-section">
    <div class="recap-inner">
      <p class="section-label">Perjalananmu</p>
      <h2 class="section-title">Setlist yang Kamu Jelajahi</h2>
      <div class="recap-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>

      <div class="track-recap-list">
        <?php foreach ($tracks as $track): ?>
          <div class="track-recap-item">
            <span class="track-recap-num"><?= $track['urutan'] ?></span>
            <div class="track-recap-info">
              <span class="track-recap-title"><?= htmlspecialchars($track['judul_lagu']) ?></span>
              <?php if ($track['mood']): ?>
                <span class="track-recap-mood"><?= htmlspecialchars($track['mood']) ?></span>
              <?php endif; ?>
            </div>
            <span class="track-recap-check">✓</span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══ GUESTBOOK ══ -->
  <section class="guestbook-section" id="guestbook-section">
    <div class="guestbook-inner">
      <p class="section-label">Buku Tamu</p>
      <h2 class="section-title">Tinggalkan <em>Kesanmu</em></h2>
      <div class="recap-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <p class="guestbook-sub">Apa yang kamu rasakan setelah menyelesaikan perjalanan ini?</p>

      <?php if ($success ?? null): ?>
        <div class="success-alert">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="width:14px;height:14px;vertical-align:-2px;margin-right:5px"><path d="M5 13l4 4L19 7"/></svg><?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <!-- Form guestbook -->
      <form class="guestbook-form" method="POST" action="<?= url('final/' . $chapter['slug']) ?>">
        <?php if (!$isLoggedIn): ?>
          <div class="form-group">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-input" placeholder="Namamu" required>
          </div>
        <?php endif; ?>
        <div class="form-group">
          <label class="form-label">Pesanmu</label>
          <textarea name="pesan" class="form-textarea" rows="4"
                    placeholder="Ceritakan pengalamanmu menjelajahi setlist ini..." required></textarea>
        </div>
        <button type="submit" class="submit-btn">
          Kirim Pesan
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </form>

      <!-- Entries guestbook -->
      <?php if (!empty($guestbook)): ?>
        <div class="guestbook-entries">
          <p class="entries-label"><?= count($guestbook) ?> pesan dari penjelajah lain</p>
          <?php foreach ($guestbook as $entry): ?>
            <div class="entry-card">
              <div class="entry-header">
                <span class="entry-name">
                  <?= htmlspecialchars($entry['nama_user'] ?? $entry['nama'] ?? 'Penjelajah') ?>
                </span>
                <span class="entry-date">
                  <?= date('d M Y', strtotime($entry['dibuat_pada'])) ?>
                </span>
              </div>
              <p class="entry-msg"><?= nl2br(htmlspecialchars($entry['pesan'])) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ NEXT CHAPTER ══ -->
  <section class="next-section">
    <div class="next-inner">
      <div class="next-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <p class="next-label">Perjalanan Belum Berakhir</p>
      <h2 class="next-title">Kembali ke <em>World Map</em></h2>
      <p class="next-sub">Chapter berikutnya menunggumu di sana.</p>
      <a href="<?= url('worldmap') ?>" class="next-btn">
        Ke World Map
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </section>

  <script src="<?= BASE_URL ?>/public/assets/js/final.js"></script>
</body>
</html>