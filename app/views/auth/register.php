<?php
$error = Session::flash('error');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
</head>
<body>

  <!-- Background -->
  <div class="bg-stage">
    <div class="bg-spotlight"></div>
    <div class="bg-floor"></div>
  </div>

  <!-- Proscenium -->
  <div class="arch"></div>
  <div class="pillar pillar-left"></div>
  <div class="pillar pillar-right"></div>

  <!-- Navbar -->
  <nav class="nav">
    <a href="<?= url('') ?>" class="nav-brand">Setlist Journey</a>
    <div class="nav-links">
      <a href="<?= url('worldmap') ?>">World Map</a>
    </div>
  </nav>

  <!-- Register wrapper -->
  <div class="login-wrapper">
    <div class="login-card register-card">

      <p class="card-label">JKT48 · Theater Experience</p>
      <h1 class="card-title">Mulai <em>Petualangan</em></h1>
      <p class="card-sub">Buat akun untuk menyimpan progressmu</p>

      <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>

      <!-- Error alert -->
      <?php if ($error): ?>
        <div class="alert-error">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 8v4M12 16h.01"/>
          </svg>
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" action="<?= url('register') ?>">

        <div class="form-group">
          <label class="form-label" for="nama">Nama</label>
          <input
            class="form-input"
            type="text"
            id="nama"
            name="nama"
            placeholder="Nama panggilanmu"
            value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
            required
            autofocus
          >
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input
            class="form-input"
            type="email"
            id="email"
            name="email"
            placeholder="emailkamu@contoh.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
          >
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input
              class="form-input"
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              required
            >
          </div>

          <div class="form-group">
            <label class="form-label" for="confirm_password">Konfirmasi Password</label>
            <input
              class="form-input"
              type="password"
              id="confirm_password"
              name="confirm_password"
              placeholder="••••••••"
              required
            >
          </div>
        </div>

        <button type="submit" class="btn-submit">Buat Akun</button>

      </form>

      <!-- Footer links -->
      <div class="card-footer">
        <p>Sudah punya akun? <a href="<?= url('login') ?>">Login sekarang</a></p>
        <a href="<?= url('worldmap') ?>">Lanjut tanpa akun →</a>
      </div>

    </div>
  </div>

</body>
</html>