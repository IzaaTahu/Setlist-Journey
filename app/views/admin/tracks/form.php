<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title"><?= $track ? 'Edit Track' : 'Tambah Track Baru' ?></span>
  </div>
  <div class="card-body">
    <form method="POST" action="<?= $track
      ? url('admin/tracks/' . $track['id_track'] . '/update')
      : url('admin/chapters/' . $chapter['id_chapter'] . '/tracks/store') ?>">

      <div class="form-grid">

        <div class="form-group form-full">
          <label class="form-label">Judul Lagu <span>*</span></label>
          <input type="text" name="judul_lagu" class="form-input"
                 value="<?= htmlspecialchars($track['judul_lagu'] ?? '') ?>"
                 placeholder="Kizashi (Pertanda)" required>
        </div>

        <div class="form-group">
          <label class="form-label">Urutan di Setlist <span>*</span></label>
          <input type="number" name="urutan" class="form-input" min="1"
                 value="<?= $track['urutan'] ?? ($nextUrutan ?? 1) ?>">
        </div>

        <div class="form-group">
          <label class="form-label">Mood Tag</label>
          <input type="text" name="mood" class="form-input"
                 value="<?= htmlspecialchars($track['mood'] ?? '') ?>"
                 placeholder="hopeful, melancholic, energetic...">
        </div>

        <div class="form-group form-full">
          <label class="form-label">Deskripsi / Lore</label>
          <textarea name="deskripsi" class="form-textarea" rows="6"
                    placeholder="Cerita di balik lagu ini..."><?= htmlspecialchars($track['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="form-group form-full">
          <label class="form-label">Trivia</label>
          <textarea name="trivia" class="form-textarea" rows="4"
                    placeholder="Fakta menarik tentang lagu ini..."><?= htmlspecialchars($track['trivia'] ?? '') ?></textarea>
        </div>

        <div class="form-group form-full">
          <label class="form-label">Petikan Lirik</label>
          <textarea name="lirik_petikan" class="form-textarea" rows="3"
                    placeholder="Baris lirik yang ingin ditampilkan sebagai quote..."><?= htmlspecialchars($track['lirik_petikan'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Audio Preview (path/URL)</label>
          <input type="text" name="audio_preview" class="form-input"
                 value="<?= htmlspecialchars($track['audio_preview'] ?? '') ?>"
                 placeholder="/assets/audio/kizashi.mp3">
        </div>

        <div class="form-group">
          <label class="form-label">Background Image (path/URL)</label>
          <input type="text" name="bg_image" class="form-input"
                 value="<?= htmlspecialchars($track['bg_image'] ?? '') ?>"
                 placeholder="/assets/img/tracks/kizashi.jpg">
        </div>

      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">
          <?= $track ? 'Simpan Perubahan' : 'Tambah Track' ?>
        </button>
        <a href="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/tracks') ?>" class="btn btn-outline btn-lg">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>