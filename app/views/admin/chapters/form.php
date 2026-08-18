<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title"><?= $chapter ? 'Edit Chapter' : 'Tambah Chapter Baru' ?></span>
  </div>
  <div class="card-body">
    <form method="POST" action="<?= $chapter
      ? url('admin/chapters/' . $chapter['id_chapter'] . '/update')
      : url('admin/chapters/store') ?>">

      <div class="form-grid">

        <div class="form-group form-full">
          <label class="form-label">Judul Chapter <span>*</span></label>
          <input type="text" name="judul" class="form-input"
                 value="<?= htmlspecialchars($chapter['judul'] ?? '') ?>"
                 placeholder="Cara Meminum Ramune" required>
        </div>

        <div class="form-group">
          <label class="form-label">Slug <span>*</span></label>
          <input type="text" name="slug" class="form-input" id="slugInput"
                 value="<?= htmlspecialchars($chapter['slug'] ?? '') ?>"
                 placeholder="cara-meminum-ramune" required>
          <span class="form-hint">Dipakai untuk URL. Hanya huruf kecil, angka, dan tanda -</span>
        </div>

        <div class="form-group">
          <label class="form-label">Urutan</label>
          <input type="number" name="urutan" class="form-input" min="1"
                 value="<?= $chapter['urutan'] ?? 1 ?>">
        </div>

        <div class="form-group form-full">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-textarea" rows="3"
                    placeholder="Deskripsi singkat chapter ini..."><?= htmlspecialchars($chapter['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Warna Tema</label>
          <div class="color-input-wrap">
            <input type="color" id="colorPicker" value="<?= $chapter['tema_warna'] ?? '#4A90B8' ?>"
                   oninput="document.getElementById('colorText').value=this.value; document.getElementById('colorPreview').style.background=this.value">
            <input type="text" name="tema_warna" id="colorText" class="form-input"
                   value="<?= htmlspecialchars($chapter['tema_warna'] ?? '#4A90B8') ?>"
                   oninput="document.getElementById('colorPicker').value=this.value; document.getElementById('colorPreview').style.background=this.value"
                   style="max-width:120px">
            <div class="color-preview" id="colorPreview"
                 style="background:<?= htmlspecialchars($chapter['tema_warna'] ?? '#4A90B8') ?>"></div>
          </div>
          <span class="form-hint">Warna dominan halaman chapter ini</span>
        </div>

        <div class="form-group">
          <label class="form-label">Dekorasi Animasi</label>
          <select name="dekorasi" class="form-select">
            <?php
            $dekOptions = ['none' => 'Tidak Ada', 'bubble' => 'Bubble (Ramune)', 'confetti' => 'Confetti (Pita)', 'fire' => 'Fire (Api)'];
            foreach ($dekOptions as $val => $label):
            ?>
              <option value="<?= $val ?>" <?= ($chapter['dekorasi'] ?? 'none') === $val ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Status</label>
          <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;margin-top:0.4rem">
            <input type="checkbox" name="is_active" value="1"
                   <?= ($chapter['is_active'] ?? 0) ? 'checked' : '' ?>>
            <span style="font-size:0.85rem">Chapter aktif (bisa diakses user)</span>
          </label>
        </div>

      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">
          <?= $chapter ? 'Simpan Perubahan' : 'Tambah Chapter' ?>
        </button>
        <a href="<?= url('admin/chapters') ?>" class="btn btn-outline btn-lg">Batal</a>
      </div>
    </form>
  </div>
</div>

<script>
// Auto-generate slug dari judul
document.querySelector('[name="judul"]').addEventListener('input', function() {
  const slugInput = document.getElementById('slugInput');
  if (!slugInput.dataset.manual) {
    slugInput.value = this.value
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }
});
document.getElementById('slugInput').addEventListener('input', function() {
  this.dataset.manual = 'true';
});
</script>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>