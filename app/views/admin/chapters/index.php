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
      <span class="empty-state-icon">📖</span>
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
            🎵 Tracks
          </a>
          <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/milestones') ?>" class="btn btn-outline btn-sm">
            🏆 Milestones
          </a>
          <a href="<?= url('admin/chapters/' . $ch['id_chapter'] . '/edit') ?>" class="btn btn-outline btn-sm">
            ✏️ Edit
          </a>
          <form method="POST" action="<?= url('admin/chapters/' . $ch['id_chapter'] . '/toggle') ?>" style="display:inline">
            <button type="submit" class="btn btn-outline btn-sm">
              <?= $ch['is_active'] ? '🔒 Nonaktifkan' : '🔓 Aktifkan' ?>
            </button>
          </form>
          <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= url('admin/chapters/' . $ch['id_chapter'] . '/delete') ?>', '<?= htmlspecialchars($ch['judul']) ?>')">
            🗑️ Hapus
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