<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="card">
  <div class="card-header">
    <span class="card-title">Semua Pesan Guestbook</span>
    <span class="badge badge-blue"><?= count($entries) ?> pesan</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Dari</th><th>Chapter</th><th>Pesan</th><th>Tanggal</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (empty($entries)): ?>
          <tr><td colspan="5" style="text-align:center;color:var(--text-dim);padding:2rem">Belum ada pesan</td></tr>
        <?php endif; ?>
        <?php foreach ($entries as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['nama_user'] ?? $e['nama'] ?? 'Tamu') ?></td>
          <td>
            <a href="<?= url('chapter/' . $e['chapter_slug']) ?>" target="_blank" style="color:var(--gold);font-size:0.8rem">
              <?= htmlspecialchars($e['chapter_judul']) ?>
            </a>
          </td>
          <td style="max-width:300px;font-size:0.83rem;color:var(--text-mid)">
            <?= htmlspecialchars(mb_strimwidth($e['pesan'], 0, 100, '...')) ?>
          </td>
          <td style="font-size:0.78rem;color:var(--text-dim);white-space:nowrap">
            <?= date('d M Y', strtotime($e['dibuat_pada'])) ?>
          </td>
          <td>
            <form method="POST" action="<?= url('admin/guestbook/' . $e['id_pesan'] . '/delete') ?>">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesan ini?')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/><path d="M10 11v6M14 11v6"/></svg></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>