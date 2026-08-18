# SetlistJourney

**SetlistJourney** adalah web app gamifikasi bertema *musical journey* — pengguna menjelajahi **World Map**, membuka **Chapter** (babak/album) satu per satu, mendengarkan cerita tiap **Track** (lagu), menyelesaikan **Quest** (trivia/tebak lirik) untuk membuka track berikutnya, menemukan **Milestone** (momen spesial) di sepanjang jalan, dan menutup tiap chapter dengan menulis pesan di **Guestbook**.

Dibangun dengan **PHP native (tanpa framework)** menggunakan pola MVC sederhana buatan sendiri (`core/Router.php`, `core/Controller.php`, `core/Model.php`, `core/Session.php`).

> ⚠️ Karena ini pure PHP native (bukan hosted), project ini **hanya bisa dilihat/dicoba dengan cara di-download dan dijalankan di local**. Ikuti panduan instalasi di bawah.

---

## Fitur

- 🔐 Autentikasi user (register/login/logout) dengan `password_hash`/`password_verify`
- 🗺️ World Map — progres eksplorasi chapter per user
- 📖 Chapter & Track dengan mood, deskripsi, trivia, dan petikan lirik
- 🧩 Quest per track (trivia / tebak lirik / decode cipher) yang mengunci track selanjutnya sampai terjawab
- 🏆 Milestone — reward/cerita tambahan setelah track tertentu
- 📝 Guestbook di tiap penutup chapter (final stage)
- 🛠️ Panel Admin: kelola Chapter, Track, Quest, Milestone, User, dan Guestbook
- 🧭 Router custom dengan dukungan parameter dinamis (`/chapter/:slug`, `/track/:id`, dst.)

---

## Tech Stack

- PHP native (MVC custom, tanpa Composer/framework)
- MySQL / MariaDB (PDO)
- Vanilla JS + CSS per halaman (`public/assets/js`, `public/assets/css`)
- Apache `mod_rewrite` (`.htaccess`)

---

## Struktur Project

```
SetlistJourney2/
├── app/
│   ├── controllers/     # Controller publik & admin
│   ├── models/          # Model (Chapter, Track, Quest, Milestone, Progress, User, Member)
│   └── views/           # View per fitur (home, auth, worldmap, chapter, track, final, admin)
├── config/
│   └── database.php     # Konfigurasi koneksi database (PDO)
├── core/                # Router, Controller, Model, Session (mini-framework)
├── database/
│   └── schema.sql       # Struktur tabel database (lihat catatan di bawah)
├── public/
│   └── assets/          # CSS & JS
├── .htaccess
└── index.php            # Entry point / bootstrap
```

---

## Instalasi & Menjalankan di Local

### Prasyarat
- PHP **8.0+** (pakai fitur typed property & union return type)
- MySQL / MariaDB
- Apache dengan `mod_rewrite` aktif (disarankan **XAMPP** / **Laragon**)

### Langkah-langkah

1. **Clone / download project** ke folder root server local kamu.
   ```bash
   git clone https://github.com/<username>/SetlistJourney2.git
   ```
   Kalau pakai XAMPP, taruh folder ini di `htdocs/SetlistJourney2`.

2. **Buat database** lalu import schema-nya:
   ```bash
   mysql -u root -p -e "CREATE DATABASE setlist_journey1"
   mysql -u root -p setlist_journey1 < database/schema.sql
   ```
   > **Catatan:** `database/schema.sql` disusun ulang dari query-query di `app/models` & `app/controllers` (dump SQL asli tidak disertakan di project ini). Sesuaikan/tambahkan data chapter, track, quest, dsb. lewat panel admin setelah setup.

3. **Sesuaikan koneksi database** di `config/database.php` kalau username/password MySQL kamu berbeda dari default (`root` / tanpa password):
   ```php
   private string $host     = 'localhost';
   private string $dbname   = 'setlist_journey1';
   private string $username = 'root';
   private string $password = '';
   ```

4. **Pastikan `RewriteBase` di `.htaccess` sesuai nama folder project kamu.** Defaultnya:
   ```apache
   RewriteBase /SetlistJourney2/
   ```
   Ganti bagian ini kalau kamu menaruh project di path/nama folder lain.

5. **Jalankan server** (contoh pakai PHP built-in server dari dalam folder project):
   ```bash
   php -S localhost:8000
   ```
   atau akses lewat Apache di XAMPP/Laragon:
   ```
   http://localhost/SetlistJourney2/
   ```

6. **Buat akun admin**
   - Daftar akun biasa lewat halaman `/register`.
   - Jadikan admin lewat query manual:
     ```sql
     UPDATE users SET role = 'admin' WHERE email = 'email_kamu@contoh.com';
     ```
   - Login lagi, lalu akses `/admin` untuk mulai mengisi konten (Chapter → Track → Quest → Milestone).

---

## 🗺️ Alur Utama Aplikasi

```
Register/Login → World Map → pilih Chapter → baca Track
   → jawab Quest (kalau ada) → track/chapter berikutnya terbuka
   → selesai semua track di chapter → Guestbook (Final Stage)
```

Admin mengatur seluruh konten (chapter, track, quest, milestone) lewat `/admin`, termasuk memantau user & guestbook.

---

## 📌 Catatan

- Ini project pembelajaran/personal, dibuat pure PHP native tanpa framework — cocok buat yang mau lihat implementasi MVC dari nol.
- Karena tidak di-hosting, satu-satunya cara melihat aplikasinya jalan adalah dengan clone & run di local sesuai langkah di atas.
- Kontribusi/issue silakan dibuka lewat tab **Issues** di repo ini.

---

## 📄 Lisensi

Belum ada lisensi resmi — tambahkan file `LICENSE` kalau ingin project ini open source secara formal (misalnya MIT).