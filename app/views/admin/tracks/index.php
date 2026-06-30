<!-- ============================================================
     admin/tracks/index.php
     ============================================================ -->
<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="section-header">
  <div>
    <span class="section-title-sm">Tracks — <?= htmlspecialchars($chapter['judul']) ?></span>
    <div style="display:flex;gap:0.5rem;margin-top:0.4rem">
      <a href="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/milestones') ?>" class="btn btn-outline btn-sm">🏆 Milestones</a>
    </div>
  </div>
  <a href="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/tracks/create') ?>" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Tambah Track
  </a>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th><th>Judul Lagu</th><th>Mood</th><th>Quest</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($tracks)): ?>
          <tr><td colspan="5" style="text-align:center;color:var(--text-dim);padding:2rem">Belum ada track</td></tr>
        <?php endif; ?>
        <?php foreach ($tracks as $t): ?>
        <tr>
          <td style="color:var(--text-dim)"><?= $t['urutan'] ?></td>
          <td>
            <strong><?= htmlspecialchars($t['judul_lagu']) ?></strong>
            <?php if ($t['deskripsi']): ?>
              <br><span style="font-size:0.75rem;color:var(--text-dim)">Ada lore</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($t['mood']): ?>
              <span class="badge badge-blue"><?= htmlspecialchars($t['mood']) ?></span>
            <?php else: ?>
              <span style="color:var(--text-dim);font-size:0.78rem">—</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?= url('admin/tracks/' . $t['id_track'] . '/quest') ?>" class="btn btn-outline btn-sm">🎯 Quest</a>
          </td>
          <td style="display:flex;gap:0.4rem;flex-wrap:wrap">
            <a href="<?= url('admin/tracks/' . $t['id_track'] . '/edit') ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
            <button class="btn btn-danger btn-sm"
                    onclick="confirmDelete('<?= url('admin/tracks/' . $t['id_track'] . '/delete') ?>', '<?= htmlspecialchars($t['judul_lagu']) ?>')">
              🗑️
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <p class="modal-title">Hapus Track?</p>
    <p class="modal-msg" id="deleteModalMsg">Quest dan data terkait track ini juga akan terhapus.</p>
    <div class="modal-actions">
      <button class="btn btn-outline" onclick="closeModal()">Batal</button>
      <form method="POST" id="deleteForm"><button type="submit" class="btn btn-danger">Hapus</button></form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>