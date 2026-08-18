<?php
$isLoggedIn = isset($_SESSION['user_id']);
$userName   = Session::get('user_nama');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>World Map — Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/worldmap.css">
</head>
<body>

  <div class="arch"></div>
  <div class="pillar pillar-left"></div>
  <div class="pillar pillar-right"></div>

  <nav class="nav">
    <a href="<?= url('') ?>" class="nav-brand">Setlist Journey</a>
    <div class="nav-links">
      <?php if ($isLoggedIn): ?>
        <span class="nav-user"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:12px;height:12px;vertical-align:-1px;margin-right:3px"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg><?= htmlspecialchars($userName) ?></span>
        <a href="<?= url('logout') ?>">Logout</a>
      <?php else: ?>
        <a href="<?= url('login') ?>">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <div class="wm-header">
    <p class="wm-label">Pilih Petualanganmu</p>
    <h1 class="wm-title">World <em>Map</em></h1>
    <p class="wm-sub">Setiap setlist adalah sebuah dunia. Jelajahi satu per satu.</p>
  </div>

  <div class="journey-wrapper">
    <div class="journey-path">

      <?php foreach ($chapters as $i => $ch):
        // Gunakan locked yang sudah dihitung di controller
        $locked  = $ch['locked'] ?? false;
        $prog    = $progress[$ch['id_chapter']] ?? null;
        $done    = $prog['selesai'] ?? false;
        $started = $prog && !$done && ($prog['track_terbuka'] ?? 1) > 1;
        $side    = $i % 2 === 0 ? 'left' : 'right';
        $status  = $locked ? 'locked' : ($done ? 'done' : ($started ? 'started' : 'unlocked'));
      ?>

      <div class="journey-stop <?= $side ?> <?= $status ?>">

        <?php if ($i > 0): ?>
          <div class="connector"></div>
        <?php endif; ?>

        <div class="stop-node">
          <div class="node-ring">
            <div class="node-dot">
              <?php if ($locked): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2"/>
                  <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
              <?php elseif ($done): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 13l4 4L19 7"/>
                </svg>
              <?php else: ?>
                <span><?= $i + 1 ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="stop-card">
          <div class="card-inner">
            <div class="card-meta">
              <span class="card-chapter">Chapter <?= $i + 1 ?></span>
              <?php if ($done): ?>
                <span class="card-badge done">Selesai</span>
              <?php elseif ($started): ?>
                <span class="card-badge started">Sedang Berjalan</span>
              <?php elseif (!$locked): ?>
                <span class="card-badge unlocked">Terbuka</span>
              <?php else: ?>
                <span class="card-badge locked">Terkunci</span>
              <?php endif; ?>
            </div>

            <h2 class="card-title"><?= htmlspecialchars($ch['judul']) ?></h2>

            <?php if ($ch['deskripsi']): ?>
              <p class="card-desc"><?= htmlspecialchars($ch['deskripsi']) ?></p>
            <?php endif; ?>

            <?php if ($started && $prog): ?>
              <div class="progress-bar">
                <div class="progress-track">
                  <div class="progress-fill" style="width: <?= min(100, round(($prog['track_terbuka'] - 1) / 16 * 100)) ?>%"></div>
                </div>
                <span class="progress-label">Lagu <?= $prog['track_terbuka'] - 1 ?> / 16</span>
              </div>
            <?php endif; ?>

            <?php if (!$locked): ?>
              <a href="<?= url('chapter/' . $ch['slug']) ?>" class="card-btn">
                <?= $done ? 'Lihat Kembali' : ($started ? 'Lanjutkan' : 'Mulai Petualangan') ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            <?php else: ?>
              <p class="card-locked-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:11px;height:11px;vertical-align:-1px;margin-right:4px"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg><?= $isLoggedIn ? 'Selesaikan chapter sebelumnya' : 'Login & selesaikan chapter sebelumnya' ?>
              </p>
            <?php endif; ?>

          </div>
          <div class="card-accent" style="background: <?= htmlspecialchars($ch['tema_warna'] ?? '#c9a84c') ?>"></div>
        </div>

      </div>
      <?php endforeach; ?>

      <div class="journey-end">
        <div class="end-dot">✦</div>
        <p>Perjalanan masih berlanjut...</p>
      </div>

    </div>
  </div>

  <?php if (!$isLoggedIn): ?>
  <div class="guest-bar">
    <p>
      <a href="<?= url('login') ?>">Login</a> atau
      <a href="<?= url('register') ?>">Daftar</a>
      agar progressmu tersimpan
    </p>
  </div>
  <?php endif; ?>

  <script src="<?= BASE_URL ?>/public/assets/js/worldmap.js"></script>
</body>
</html>