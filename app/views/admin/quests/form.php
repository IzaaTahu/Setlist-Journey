<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title">Quest — <?= htmlspecialchars($track['judul_lagu']) ?></span>
    <?php if ($quest): ?>
      <form method="POST" action="<?= url('admin/quests/' . $quest['id_quest'] . '/delete') ?>">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus quest ini?')">🗑️ Hapus Quest</button>
      </form>
    <?php endif; ?>
  </div>
  <div class="card-body">
    <form method="POST" action="<?= url('admin/tracks/' . $track['id_track'] . '/quest/store') ?>" id="questForm">

      <div class="form-grid">

        <div class="form-group">
          <label class="form-label">Tipe Quest <span>*</span></label>
          <select name="tipe" class="form-select" id="tipeSelect" onchange="updateQuestForm()">
            <?php
            $tipes = [
              'trivia'       => 'Trivia (pilihan ganda)',
              'tebak_lirik'  => 'Tebak Lirik',
              'tebak_siluet' => 'Tebak Siluet Member',
              'susun_lirik'  => 'Susun Lirik',
              'baca_lore'    => 'Baca Lore (timer)',
              'easter_egg'   => 'Easter Egg',
              'tulis_kesan'  => 'Tulis Kesan',
              'decode_cipher'=> 'Decode Cipher',
            ];
            foreach ($tipes as $val => $label):
            ?>
              <option value="<?= $val ?>" <?= ($quest['tipe'] ?? '') === $val ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group" id="durasiGroup" style="display:none">
          <label class="form-label">Durasi Timer (detik)</label>
          <input type="number" name="durasi_baca" class="form-input" min="10" max="120"
                 value="<?= $quest['durasi_baca'] ?? 30 ?>" placeholder="30">
        </div>

        <div class="form-group form-full">
          <label class="form-label">Pertanyaan / Instruksi</label>
          <textarea name="pertanyaan" class="form-textarea" rows="3"
                    placeholder="Tulis pertanyaan atau instruksi quest..."><?= htmlspecialchars($quest['pertanyaan'] ?? '') ?></textarea>
        </div>

        <!-- Opsi trivia -->
        <div class="form-group form-full" id="triviaOptions" style="display:none">
          <label class="form-label">Pilihan Jawaban</label>
          <span class="form-hint" style="margin-bottom:0.75rem;display:block">Centang opsi yang benar</span>
          <?php for ($i = 0; $i < 4; $i++): ?>
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem">
              <input type="radio" name="correct" value="<?= $i ?>"
                     <?= isset($options[$i]) && $options[$i]['is_correct'] ? 'checked' : '' ?>>
              <input type="text" name="options[]" class="form-input"
                     value="<?= htmlspecialchars($options[$i]['teks_opsi'] ?? '') ?>"
                     placeholder="Opsi <?= $i+1 ?>">
            </div>
          <?php endfor; ?>
        </div>

        <!-- Jawaban benar (tebak_lirik / decode_cipher) -->
        <div class="form-group form-full" id="jawabanBenarGroup" style="display:none">
          <label class="form-label">Jawaban Benar</label>
          <input type="text" name="jawaban_benar" class="form-input"
                 value="<?= htmlspecialchars($options[0]['teks_opsi'] ?? '') ?>"
                 placeholder="Jawaban yang diterima sistem">
          <span class="form-hint">Pencocokan tidak case-sensitive</span>
        </div>

      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">Simpan Quest</button>
        <a href="<?= url('admin/chapters/' . $chapter['id_chapter'] . '/tracks') ?>" class="btn btn-outline btn-lg">Kembali</a>
      </div>
    </form>
  </div>
</div>

<script>
function updateQuestForm() {
  const tipe = document.getElementById('tipeSelect').value;
  document.getElementById('triviaOptions').style.display      = tipe === 'trivia' ? 'block' : 'none';
  document.getElementById('durasiGroup').style.display        = tipe === 'baca_lore' ? 'flex' : 'none';
  document.getElementById('jawabanBenarGroup').style.display  = ['tebak_lirik','decode_cipher','tebak_siluet'].includes(tipe) ? 'block' : 'none';
}
updateQuestForm();
</script>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>