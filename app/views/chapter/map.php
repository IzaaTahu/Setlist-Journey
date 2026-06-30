<?php
$isLoggedIn = isset($_SESSION['user_id']);
$dekorasi   = htmlspecialchars($chapter['dekorasi'] ?? 'none');
$temaWarna  = htmlspecialchars($chapter['tema_warna'] ?? '#4A90B8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($chapter['judul']) ?> — Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/chapter.css">
  <style>
    :root { --tema: <?= $temaWarna ?>; }
  </style>
</head>
<body data-dekorasi="<?= $dekorasi ?>" data-tema="<?= $temaWarna ?>">

  <!-- Canvas untuk dekorasi animasi -->
  <canvas id="deco-canvas"></canvas>

  <!-- Marble dekoratif — universal, warna ikut tema -->
  <div class="marble marble-1"></div>
  <div class="marble marble-2"></div>
  <div class="marble marble-3"></div>
  <div class="marble marble-4"></div>
  <div class="marble marble-5"></div>

  <!-- Navbar -->
  <nav class="nav">
    <a href="<?= url('') ?>" class="nav-brand">Setlist Journey</a>
    <div class="nav-links">
      <a href="<?= url('worldmap') ?>">← World Map</a>
      <?php if ($isLoggedIn): ?>
        <a href="<?= url('logout') ?>">Logout</a>
      <?php else: ?>
        <a href="<?= url('login') ?>">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Chapter Header -->
  <div class="ch-header">
    <p class="ch-label">Chapter <?= (int)$chapter['urutan'] ?></p>
    <h1 class="ch-title"><?= htmlspecialchars($chapter['judul']) ?></h1>
    <?php if ($chapter['deskripsi']): ?>
      <p class="ch-desc"><?= htmlspecialchars($chapter['deskripsi']) ?></p>
    <?php endif; ?>

    <div class="ch-divider">
      <div class="ch-divider-line"></div>
      <div class="ch-divider-dot"></div>
      <div class="ch-divider-line"></div>
    </div>

    <?php if ($isLoggedIn):
      $trackCount = count($tracks);
      $progressPercentage = $trackCount ? min(100, round(($trackTerbuka - 1) / $trackCount * 100)) : 0;
    ?>
      <div class="ch-progress">
        <div class="ch-progress-track">
          <div class="ch-progress-fill"
               style="width: <?= $progressPercentage ?>%">
          </div>
        </div>
        <span class="ch-progress-label">
          <?= $trackTerbuka - 1 ?> / <?= $trackCount ?> lagu selesai
        </span>
      </div>
    <?php endif; ?>
  </div>

  <!-- Track Journey -->
  <div class="track-wrapper">
    <div class="track-journey">

      <?php foreach ($tracks as $i => $track):
        $unlocked = $track['urutan'] <= $trackTerbuka;
        $current  = $track['urutan'] == $trackTerbuka;
        $done     = $track['urutan'] < $trackTerbuka;
        $side     = $i % 2 === 0 ? 'left' : 'right';
        $status   = $done ? 'done' : ($current ? 'current' : 'locked');
      ?>

      <div class="track-stop <?= $side ?> <?= $status ?>">

        <?php if ($i > 0): ?>
          <div class="track-connector <?= ($done || $current) ? 'lit' : '' ?>"></div>
        <?php endif; ?>

        <div class="track-node">
          <div class="node-ring">
            <div class="node-dot">
              <?php if ($done): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 13l4 4L19 7"/>
                </svg>
              <?php elseif ($current): ?>
                <span><?= $track['urutan'] ?></span>
              <?php else: ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <rect x="3" y="11" width="18" height="11" rx="2"/>
                  <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="track-card">
          <div class="track-card-accent"></div>
          <div class="track-card-inner">
            <div class="track-meta">
              <span class="track-num-label">Lagu <?= $track['urutan'] ?></span>
              <?php if ($track['mood']): ?>
                <span class="track-mood"><?= htmlspecialchars($track['mood']) ?></span>
              <?php endif; ?>
            </div>
            <h3 class="track-title"><?= htmlspecialchars($track['judul_lagu']) ?></h3>
            <?php if ($unlocked): ?>
              <a href="<?= url('track/' . $track['id_track']) ?>" class="track-btn">
                <?= $done ? 'Lihat Kembali' : 'Masuk ke Lagu Ini' ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            <?php else: ?>
              <p class="track-locked-note">Selesaikan lagu sebelumnya</p>
            <?php endif; ?>
          </div>
        </div>

      </div>
      <?php endforeach; ?>

      <div class="track-end">
        <div class="end-icon">✦</div>
        <p>Akhir dari <?= htmlspecialchars($chapter['judul']) ?></p>
      </div>

    </div>
  </div>

  <?php if (!$isLoggedIn): ?>
  <div class="guest-bar">
    <p><a href="<?= url('login') ?>">Login</a> agar progressmu tersimpan</p>
  </div>
  <?php endif; ?>

  <script src="<?= BASE_URL ?>/public/assets/js/chapter.js"></script>
</body>
</html>