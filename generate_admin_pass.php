<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <title>Generate Admin Password</title>
  <style>
    body { font-family: monospace; background: #fdf6fb; padding: 40px; color: #4a2040; }
    .box { background: white; border: 2px solid #f8bbd0; border-radius: 16px; padding: 28px; max-width: 600px; margin: 0 auto; }
    h2   { font-family: serif; color: #e91e8c; margin-bottom: 20px; }
    label { font-size: 13px; font-weight: bold; display: block; margin-bottom: 6px; }
    input[type=text], input[type=password] {
      width: 100%; padding: 10px 14px; border: 1.5px solid #f8bbd0;
      border-radius: 10px; font-size: 14px; font-family: monospace;
      margin-bottom: 16px; outline: none; box-sizing: border-box;
    }
    input:focus { border-color: #e91e8c; }
    button {
      background: #e91e8c; color: white; border: none;
      padding: 10px 24px; border-radius: 20px; font-size: 14px;
      font-weight: bold; cursor: pointer;
    }
    button:hover { background: #c2185b; }
    .result {
      margin-top: 24px; background: #fce4ec;
      border-radius: 12px; padding: 18px;
      border-left: 4px solid #e91e8c;
    }
    .result code {
      display: block; word-break: break-all;
      font-size: 13px; margin: 8px 0;
      background: #fff; padding: 10px; border-radius: 8px;
      border: 1px solid #f8bbd0;
      user-select: all;
    }
    .sql-box {
      margin-top: 16px; background: #1e1e2e;
      color: #cdd6f4; border-radius: 10px; padding: 14px;
      font-size: 13px; line-height: 1.6;
    }
    .sql-box .kw  { color: #89b4fa; }
    .sql-box .str { color: #a6e3a1; }
    .warning { background: #fff3e0; border: 1.5px solid #ffb74d; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-top: 12px; color: #e65100; }
    .step { margin-bottom: 6px; font-size: 13px; }
  </style>
</head>
<body>
<div class="box">
  <h2>🔑 Generate Admin Password Hash</h2>
  <p style="font-size:13px;color:#7b3f6e;margin-bottom:20px;">
    Masukkan password yang ingin kamu pakai untuk akun admin, lalu copy SQL-nya ke phpMyAdmin/HeidiSQL.
  </p>

  <form method="POST">
    <label>Email Admin (untuk query SQL)</label>
    <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? 'jot@gmail.com') ?>" placeholder="email@contoh.com"/>

    <label>Password yang ingin dipakai</label>
    <input type="password" name="password" placeholder="Masukkan password baru..." required/>

    <button type="submit">🔒 Generate Hash</button>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
      $email    = htmlspecialchars(strip_tags(trim($_POST['email'])));
      $password = $_POST['password'];
      $hash     = password_hash($password, PASSWORD_DEFAULT);
  ?>
  <div class="result">
    <strong>✅ Hash berhasil di-generate!</strong>

    <p style="font-size:13px;margin-top:10px;">Hash untuk password "<strong><?= str_repeat('•', strlen($password)) ?></strong>":</p>
    <code><?= htmlspecialchars($hash) ?></code>

    <p style="font-size:13px;margin-top:14px;font-weight:bold;">📋 Jalankan SQL ini di phpMyAdmin / HeidiSQL:</p>
    <div class="sql-box">
      <span class="kw">UPDATE</span> users<br>
      <span class="kw">SET</span> password_pengguna = <span class="str">'<?= htmlspecialchars($hash) ?>'</span>,<br>
      &nbsp;&nbsp;&nbsp;&nbsp;ROLE = <span class="str">'admin'</span><br>
      <span class="kw">WHERE</span> email = <span class="str">'<?= htmlspecialchars($email) ?>'</span>;
    </div>

    <div class="warning">
      ⚠️ <strong>Setelah berhasil login, segera hapus file ini!</strong><br>
      Jangan biarkan file ini bisa diakses publik.
    </div>
  </div>
  <?php } ?>

  <div style="margin-top:24px;border-top:1.5px solid #f8bbd0;padding-top:18px;">
    <p style="font-size:13px;font-weight:bold;margin-bottom:10px;">📖 Cara pakai:</p>
    <div class="step">1️⃣ Isi email admin dan password yang kamu mau</div>
    <div class="step">2️⃣ Klik "Generate Hash"</div>
    <div class="step">3️⃣ Copy perintah SQL yang muncul</div>
    <div class="step">4️⃣ Paste & jalankan di phpMyAdmin → tab SQL</div>
    <div class="step">5️⃣ Coba login di web dengan email + password tadi</div>
    <div class="step">6️⃣ <strong>Hapus file ini setelah selesai!</strong></div>
  </div>
</div>
</body>
</html>