<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="section-header">
  <span class="section-title-sm">Semua Chapter</span>
  <a href="<?= url('admin/chapters/create') ?>" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Chapter
  </a>
</div>

<?php if (empty($chapters)): ?>
  <div class="card">
    <div class="empty-state">
      <span class="empty-state-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg></span>
      <p class="empty-state-title">Belum ada chapter</p>
      <p class="empty-state-sub">Mulai tambahkan chapter pertama.</p>
    </div>
  </div>
<?php else: ?>
  <div class="chapter-cards">
    <?php foreach ($chapters as $ch): ?>
    <div class="chapter-card">
      <div class="chapter-card-top" style="background: <?= htmlspecialchars($ch['tema_warna']) ?>"></div>
      <div class="chapter-card-body">
        <p class="chapter-card-num">Chapter <?= $ch['urutan'] ?></p>
        <p class="chapter-card-title"><?= htmlspecialchars($ch['judul']) ?></p>
        <div class="chapter-card-meta">
          <span class="badge <?= $ch['is_active'] ? 'badge-green' : 'badge-gray' ?>">
            <?= $ch['is_active'] ? 'Aktif' : 'Nonaktif' ?>
          </span>
          <span class="badge badge-blue"><?= $ch['total_tracks'] ?> Tracks</span>
          <span class="badge badge-gold"><?= $ch['total_milestones'] ?> Milestones</span>
        </div>
        <div class="chapter-card-actions">
          <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/tracks') ?>" class="btn btn-primary btn-sm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/><path d="M9 18V5l12-2v13"/></svg> Tracks
          </a>
          <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/milestones') ?>" class="btn btn-outline btn-sm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 21h8M12 17v4"/><path d="M7 4h10v5a5 5 0 01-10 0V4z"/><path d="M7 5H4.5A2.5 2.5 0 007 9.5M17 5h2.5A2.5 2.5 0 0117 9.5"/></svg> Milestones
          </a>
          <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/edit') ?>" class="btn btn-outline btn-sm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit
          </a>
          <form method="POST" action="<?= url('admin/chapters/' . $ch['id_chapter'] . '/toggle') ?>" style="display:inline">
            <button type="submit" class="btn btn-outline btn-sm">
              <?php if ($ch['is_active']): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg> Nonaktifkan
              <?php else: ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 019.9-1.5"/></svg> Aktifkan
              <?php endif; ?>
            </button>
          </form>
          <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= url('admin/chapters/' . $ch['id_chapter'] . '/delete') ?>', '<?= htmlspecialchars($ch['judul']) ?>')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/><path d="M10 11v6M14 11v6"/></svg> Hapus
          </button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<!-- Delete modal -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <p class="modal-title">Hapus Chapter?</p>
    <p class="modal-msg" id="deleteModalMsg">Semua tracks, quests, dan milestones di chapter ini akan ikut terhapus. Tindakan ini tidak bisa dibatalkan.</p>
    <div class="modal-actions">
      <button class="btn btn-outline" onclick="closeModal()">Batal</button>
      <form method="POST" id="deleteForm">
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>