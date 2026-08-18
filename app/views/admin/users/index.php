<?php require_once __DIR__ . '/../../admin/layouts/header.php'; ?>

<div class="card">
  <div class="card-header"><span class="card-title">Semua User</span></div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Oshi</th><th>Bergabung</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['nama']) ?></td>
          <td style="color:var(--text-dim)"><?= htmlspecialchars($u['email']) ?></td>
          <td>
            <form method="POST" action="<?= url('admin/users/' . $u['id_user'] . '/role') ?>" style="display:inline-flex;gap:0.4rem;align-items:center">
              <select name="role" class="form-select" style="padding:0.25rem 0.5rem;font-size:0.78rem">
                <option value="user"  <?= $u['role']==='user'  ? 'selected':'' ?>>user</option>
                <option value="admin" <?= $u['role']==='admin' ? 'selected':'' ?>>admin</option>
              </select>
              <button type="submit" class="btn btn-outline btn-sm">Simpan</button>
            </form>
          </td>
          <td style="font-size:0.8rem;color:var(--text-dim)"><?= htmlspecialchars($u['oshi_name'] ?? '—') ?></td>
          <td style="font-size:0.78rem;color:var(--text-dim)"><?= date('d M Y', strtotime($u['dibuat_pada'])) ?></td>
          <td>
            <form method="POST" action="<?= url('admin/users/' . $u['id_user'] . '/delete') ?>">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/><path d="M10 11v6M14 11v6"/></svg></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>