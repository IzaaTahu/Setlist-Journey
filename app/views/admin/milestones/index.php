<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">

  <!-- Form tambah milestone -->
  <div class="card">
    <div class="card-header"><span class="card-title">Tambah Milestone</span></div>
    <div class="card-body">
      <form method="POST" action="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/milestones/store') ?>">
        <div class="form-grid form-grid col-1">
          <div class="form-group">
            <label class="form-label">Muncul Setelah Lagu</label>
            <select name="setelah_track" class="form-select">
              <?php foreach ($tracks as $t): ?>
                <option value="<?= $t['urutan'] ?>">Lagu <?= $t['urutan'] ?> — <?= htmlspecialchars($t['judul_lagu']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Judul Popup</label>
            <input type="text" name="judul" class="form-input" placeholder="Separuh Perjalanan">
          </div>
          <div class="form-group">
            <label class="form-label">Pesan</label>
            <textarea name="pesan" class="form-textarea" rows="3" placeholder="Pesan yang ditampilkan..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Foto (path/URL, opsional)</label>
            <input type="text" name="foto" class="form-input" placeholder="/assets/img/milestone1.jpg">
          </div>
          <div class="form-actions" style="border:none;padding:0">
            <button type="submit" class="btn btn-primary">Tambah Milestone</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- List milestones -->
  <div>
    <?php if (empty($milestones)): ?>
      <div class="card">
        <div class="empty-state">
          <span class="empty-state-icon">🏆</span>
          <p class="empty-state-title">Belum ada milestone</p>
        </div>
      </div>
    <?php endif; ?>
    <?php foreach ($milestones as $ms): ?>
    <div class="card" style="margin-bottom:1rem">
      <div class="card-body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem">
          <div>
            <p style="font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim)">
              Setelah lagu <?= $ms['setelah_track'] ?>
            </p>
            <p style="font-weight:600;margin:0.2rem 0"><?= htmlspecialchars($ms['judul']) ?></p>
            <p style="font-size:0.82rem;color:var(--text-mid)"><?= htmlspecialchars($ms['pesan']) ?></p>
          </div>
          <form method="POST" action="<?= url('admin/milestones/' . $ms['id_milestone'] . '/delete') ?>">
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus milestone ini?')">🗑️</button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>