<?php require_once __DIR__ . '/layouts/header.php'; ?>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-box">
    <span class="stat-box-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></span>
    <div class="stat-box-num"><?= $stats['chapters'] ?></div>
    <div class="stat-box-label">Total Chapter</div>
  </div>
  <div class="stat-box">
    <span class="stat-box-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/><path d="M9 18V5l12-2v13"/></svg></span>
    <div class="stat-box-num"><?= $stats['tracks'] ?></div>
    <div class="stat-box-label">Total Track</div>
  </div>
  <div class="stat-box">
    <span class="stat-box-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg></span>
    <div class="stat-box-num"><?= $stats['users'] ?></div>
    <div class="stat-box-label">Total User</div>
  </div>
  <div class="stat-box">
    <span class="stat-box-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></span>
    <div class="stat-box-num"><?= $stats['guestbook'] ?></div>
    <div class="stat-box-label">Pesan Guestbook</div>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

  <!-- Chapters overview -->
  <div class="card">
    <div class="card-header">
      <span class="card-title">Chapters</span>
      <a href="<?= url('admin/chapters') ?>" class="btn btn-outline btn-sm">Kelola Semua</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Tracks</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($chapters as $ch): ?>
          <tr>
            <td><?= $ch['urutan'] ?></td>
            <td>
              <div style="display:flex;align-items:center;gap:0.5rem">
                <span style="width:10px;height:10px;border-radius:50%;background:<?= htmlspecialchars($ch['tema_warna']) ?>;flex-shrink:0"></span>
                <?= htmlspecialchars($ch['judul']) ?>
              </div>
            </td>
            <td><?= $ch['total_tracks'] ?></td>
            <td>
              <span class="badge <?= $ch['is_active'] ? 'badge-green' : 'badge-gray' ?>">
                <?= $ch['is_active'] ? 'Aktif' : 'Nonaktif' ?>
              </span>
            </td>
            <td>
              <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/tracks') ?>" class="btn btn-outline btn-sm">Tracks</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent users -->
  <div class="card">
    <div class="card-header">
      <span class="card-title">User Terbaru</span>
      <a href="<?= url('admin/users') ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Nama</th><th>Email</th><th>Role</th></tr>
        </thead>
        <tbody>
          <?php foreach ($recentUsers as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['nama']) ?></td>
            <td style="color:var(--text-dim);font-size:0.78rem"><?= htmlspecialchars($u['email']) ?></td>
            <td><span class="badge <?= $u['role'] === 'admin' ? 'badge-gold' : 'badge-blue' ?>"><?= $u['role'] ?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>