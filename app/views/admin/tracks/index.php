<!-- ============================================================
     admin/tracks/index.php
     ============================================================ -->
<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="section-header">
  <div>
    <span class="section-title-sm">Tracks — <?= htmlspecialchars($chapter['judul']) ?></span>
    <div style="display:flex;gap:0.5rem;margin-top:0.4rem">
      <a href="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/milestones') ?>" class="btn btn-outline btn-sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 21h8M12 17v4"/><path d="M7 4h10v5a5 5 0 01-10 0V4z"/><path d="M7 5H4.5A2.5 2.5 0 007 9.5M17 5h2.5A2.5 2.5 0 0117 9.5"/></svg> Milestones</a>
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
            <a href="<?= url('admin/tracks/' . $t['id_track'] . '/quest') ?>" class="btn btn-outline btn-sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.2" fill="currentColor" stroke="none"/></svg> Quest</a>
          </td>
          <td style="display:flex;gap:0.4rem;flex-wrap:wrap">
            <a href="<?= url('admin/tracks/' . $t['id_track'] . '/edit') ?>" class="btn btn-outline btn-sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit</a>
            <button class="btn btn-danger btn-sm"
                    onclick="confirmDelete('<?= url('admin/tracks/' . $t['id_track'] . '/delete') ?>', '<?= htmlspecialchars($t['judul_lagu']) ?>')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/><path d="M10 11v6M14 11v6"/></svg>
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