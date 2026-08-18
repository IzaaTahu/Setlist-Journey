<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Admin' ?> — Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/admin.css">
</head>
<body>

<div class="admin-layout">

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <span class="brand-icon">✦</span>
      <div>
        <p class="brand-name">Setlist Journey</p>
        <p class="brand-sub">Admin Panel</p>
      </div>
    </div>

    <nav class="sidebar-nav">
      <p class="nav-group-label">Utama</p>
      <a href="<?= url('admin') ?>" class="nav-item <?= ($activeNav ?? '') === 'dashboard' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
      </a>

      <p class="nav-group-label">Konten</p>
      <a href="<?= url('admin/chapters') ?>" class="nav-item <?= ($activeNav ?? '') === 'chapters' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
        </svg>
        Chapters & Tracks
      </a>

      <p class="nav-group-label">Komunitas</p>
      <a href="<?= url('admin/guestbook') ?>" class="nav-item <?= ($activeNav ?? '') === 'guestbook' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        Guestbook
      </a>
      <a href="<?= url('admin/users') ?>" class="nav-item <?= ($activeNav ?? '') === 'users' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Users
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="<?= url('') ?>" class="footer-link" target="_blank">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
        </svg>
        Lihat Website
      </a>
      <a href="<?= url('logout') ?>" class="footer-link logout">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
        </svg>
        Logout
      </a>
    </div>
  </aside>

  <!-- ── MAIN ── -->
  <main class="admin-main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <h1 class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
        <?php if (!empty($breadcrumb)): ?>
          <div class="breadcrumb">
            <?php foreach ($breadcrumb as $i => $crumb): ?>
              <?php if ($i > 0): ?><span class="bc-sep">›</span><?php endif; ?>
              <?php if (isset($crumb['url'])): ?>
                <a href="<?= $crumb['url'] ?>" class="bc-link"><?= htmlspecialchars($crumb['label']) ?></a>
              <?php else: ?>
                <span class="bc-current"><?= htmlspecialchars($crumb['label']) ?></span>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="topbar-right">
        <span class="topbar-user">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:13px;height:13px;vertical-align:-2px;margin-right:4px"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg><?= htmlspecialchars(Session::get('user_nama', 'Admin')) ?>
        </span>
      </div>
    </div>

    <!-- Flash messages -->
    <?php if ($flashSuccess = Session::flash('admin_success')): ?>
      <div class="flash flash-success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="width:13px;height:13px;vertical-align:-1px;margin-right:4px"><path d="M5 13l4 4L19 7"/></svg><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError = Session::flash('admin_error')): ?>
      <div class="flash flash-error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="width:13px;height:13px;vertical-align:-1px;margin-right:4px"><path d="M18 6L6 18M6 6l12 12"/></svg><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <!-- Page content -->
    <div class="page-content">