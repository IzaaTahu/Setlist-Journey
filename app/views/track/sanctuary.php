<?php
$isLoggedIn   = isset($_SESSION['user_id']);
$temaWarna    = htmlspecialchars($track['chapter_tema']     ?? '#4A90B8');
$hasTrivia    = !empty($track['trivia']);
$hasQuest     = !empty($quest);
$isBacaLore   = $hasQuest && $quest['tipe'] === 'baca_lore';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($track['judul_lagu']) ?> — Setlist Journey</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/sanctuary.css">
  <style>:root { --tema: <?= $temaWarna ?>; }</style>
</head>
<body
  data-tema="<?= $temaWarna ?>"
  data-quest-id="<?= $quest['id_quest'] ?? '' ?>"
  data-track-id="<?= $track['id_track'] ?>"
  data-quest-tipe="<?= htmlspecialchars($quest['tipe'] ?? '') ?>"
  data-durasi="<?= (int)($quest['durasi_baca'] ?? 0) ?>"
  data-submit-url="<?= url('quest/submit') ?>"
  data-next-url="<?= url('quest/next/' . $track['id_track']) ?>">

  <canvas id="deco-canvas"></canvas>

  <!-- Navbar -->
  <nav class="nav">
    <a href="<?= url('chapter/' . $track['chapter_slug']) ?>" class="nav-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
      </svg>
      <?= htmlspecialchars($track['chapter_judul'] ?? 'Chapter') ?>
    </a>
    <div class="nav-track-info">
      <span class="nav-track-num">Lagu <?= $track['urutan'] ?></span>
      <span class="nav-track-sep">·</span>
      <span class="nav-track-mood"><?= htmlspecialchars($track['mood'] ?? '') ?></span>
    </div>
    <?php if ($isLoggedIn): ?>
      <a href="<?= url('logout') ?>" class="nav-logout">Logout</a>
    <?php else: ?>
      <a href="<?= url('login') ?>" class="nav-logout">Login</a>
    <?php endif; ?>
  </nav>

  <!-- Section dots -->
  <div class="section-dots">
    <div class="dot active" data-section="0"></div>
    <div class="dot" data-section="1"></div>
    <?php if ($hasTrivia): ?>
      <div class="dot" data-section="2"></div>
    <?php endif; ?>
  </div>

  <!-- ══ SECTION 0 — INTRO ══ -->
  <section class="sanctuary-section" id="section-intro">
    <div class="intro-content">
      <p class="intro-chapter">
        Chapter <?= (int)$track['chapter_urutan'] ?> · Lagu <?= $track['urutan'] ?>
      </p>
      <div class="intro-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <h1 class="intro-title"><?= htmlspecialchars($track['judul_lagu']) ?></h1>
      <?php if ($track['mood']): ?>
        <span class="intro-mood"><?= htmlspecialchars($track['mood']) ?></span>
      <?php endif; ?>

      <?php if ($track['audio_preview']): ?>
        <div class="audio-player">
          <button class="audio-btn" id="audioBtn">
            <svg id="iconPlay" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            <svg id="iconPause" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
          </button>
          <span class="audio-label">Preview</span>
          <audio id="audioEl" src="<?= htmlspecialchars($track['audio_preview']) ?>"></audio>
        </div>
      <?php endif; ?>

      <!-- Note khusus baca_lore -->
      <?php if ($isBacaLore): ?>
        <div class="baca-lore-note">
          <span class="note-icon">📖</span>
          <p>Baca lore<?= $hasTrivia ? ' dan trivia' : '' ?> dengan seksama sebelum melanjutkan. Akan ada countdown setelah kamu siap mulai membaca.</p>
        </div>
      <?php endif; ?>

      <button class="scroll-next-btn" onclick="scrollToSection(1)">
        Mulai Menjelajahi
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
      </button>
    </div>
    <div class="scroll-hint">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- ══ SECTION 1 — LORE ══ -->
  <section class="sanctuary-section" id="section-lore">
    <div class="lore-content">
      <p class="section-label">Kisah di Balik Lagu</p>
      <h2 class="section-title">Lore</h2>
      <div class="lore-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <div class="lore-text">
        <?= nl2br(htmlspecialchars($track['deskripsi'] ?? 'Lore belum tersedia.')) ?>
      </div>
      <?php if ($track['lirik_petikan']): ?>
        <blockquote class="lyric-quote">
          <span class="quote-mark">"</span>
          <?= htmlspecialchars($track['lirik_petikan']) ?>
          <span class="quote-mark">"</span>
        </blockquote>
      <?php endif; ?>

      <?php if ($hasTrivia): ?>
        <button class="scroll-next-btn" onclick="scrollToSection(2)">
          Lihat Trivia
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 5v14M5 12l7 7 7-7"/>
          </svg>
        </button>
      <?php elseif ($isBacaLore): ?>
        <!-- Tidak ada trivia, timer di section ini -->
        <div class="inline-timer-wrap" id="inlineTimerWrap" style="display:none">
          <div class="inline-timer">
            <div class="inline-timer-bar">
              <div class="inline-timer-fill" id="inlineTimerFill"></div>
            </div>
            <span class="inline-timer-label">
              Membaca... <span id="inlineTimerCount"><?= (int)$quest['durasi_baca'] ?></span>s
            </span>
          </div>
        </div>
        <button class="scroll-next-btn" id="mulaiBtn" onclick="mulaiTimer()">
          Mulai Membaca
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 5v14M5 12l7 7 7-7"/>
          </svg>
        </button>
        <button class="scroll-next-btn" id="lanjutBtn" style="display:none" onclick="submitLoreDone()">
          Lanjut ke Lagu Berikutnya
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      <?php elseif ($hasQuest): ?>
        <button class="scroll-next-btn" onclick="showQuest()">
          Mulai Quest
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      <?php else: ?>
        <a href="<?= url('chapter/' . $track['chapter_slug']) ?>" class="scroll-next-btn">
          Kembali ke Chapter
        </a>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══ SECTION 2 — TRIVIA ══ -->
  <?php if ($hasTrivia): ?>
  <section class="sanctuary-section" id="section-trivia">
    <div class="trivia-content">
      <p class="section-label">Fakta Tersembunyi</p>
      <h2 class="section-title">Trivia</h2>
      <div class="lore-divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
      </div>
      <div class="trivia-card">
        <span class="trivia-icon">💡</span>
        <p class="trivia-text"><?= nl2br(htmlspecialchars($track['trivia'])) ?></p>
      </div>

      <?php if ($isBacaLore): ?>
        <!-- Timer inline di trivia — tidak nutupin teks -->
        <div class="inline-timer-wrap" id="inlineTimerWrap" style="display:none">
          <div class="inline-timer">
            <div class="inline-timer-bar">
              <div class="inline-timer-fill" id="inlineTimerFill"></div>
            </div>
            <span class="inline-timer-label">
              Membaca... <span id="inlineTimerCount"><?= (int)$quest['durasi_baca'] ?></span>s
            </span>
          </div>
        </div>
        <button class="scroll-next-btn" id="mulaiBtn" onclick="mulaiTimer()">
          Mulai Membaca
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 5v14M5 12l7 7 7-7"/>
          </svg>
        </button>
        <button class="scroll-next-btn" id="lanjutBtn" style="display:none" onclick="submitLoreDone()">
          Lanjut ke Lagu Berikutnya
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>

      <?php elseif ($hasQuest): ?>
        <button class="scroll-next-btn" onclick="showQuest()">
          Mulai Quest
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      <?php else: ?>
        <a href="<?= url('chapter/' . $track['chapter_slug']) ?>" class="scroll-next-btn">
          Kembali ke Chapter
        </a>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- ══ MILESTONE POPUP ══ -->
  <?php if ($milestone): ?>
  <div class="milestone-overlay" id="milestoneOverlay" style="display:none">
    <div class="milestone-card">
      <div class="milestone-badge">🎉</div>
      <h3 class="milestone-title"><?= htmlspecialchars($milestone['judul']) ?></h3>
      <?php if ($milestone['foto']): ?>
        <img src="<?= htmlspecialchars($milestone['foto']) ?>" alt="milestone" class="milestone-img">
      <?php endif; ?>
      <p class="milestone-msg"><?= nl2br(htmlspecialchars($milestone['pesan'])) ?></p>
      <button class="milestone-btn" onclick="closeMilestone()">Lanjutkan →</button>
    </div>
  </div>
  <?php endif; ?>

  <!-- ══ QUEST POPUP — untuk tipe selain baca_lore ══ -->
  <?php if ($hasQuest && !$isBacaLore): ?>
  <div class="quest-overlay" id="questOverlay" style="display:none">
    <div class="quest-card">
      <div class="quest-header">
        <span class="quest-badge">🎯 Quest</span>
        <span class="quest-tipe"><?= htmlspecialchars(str_replace('_', ' ', $quest['tipe'])) ?></span>
      </div>
      <p class="quest-pertanyaan"><?= htmlspecialchars($quest['pertanyaan']) ?></p>

      <?php if ($quest['tipe'] === 'trivia' && !empty($quest['options'])): ?>
        <div class="quest-options">
          <?php foreach ($quest['options'] as $opt): ?>
            <button class="quest-option-btn" data-value="<?= htmlspecialchars($opt['teks']) ?>">
              <?= htmlspecialchars($opt['teks']) ?>
            </button>
          <?php endforeach; ?>
        </div>

      <?php elseif ($quest['tipe'] === 'tebak_lirik'): ?>
        <input type="text" class="quest-input" id="questInput" placeholder="Tulis jawabanmu...">
        <button class="quest-submit-btn" id="questSubmit">Kirim Jawaban</button>

      <?php elseif ($quest['tipe'] === 'tulis_kesan'): ?>
        <textarea class="quest-textarea" id="questInput" placeholder="Tuliskan kesanmu..." rows="4"></textarea>
        <button class="quest-submit-btn" id="questSubmit">Simpan & Lanjut</button>

      <?php elseif ($quest['tipe'] === 'decode_cipher'): ?>
        <div class="cipher-box"><?= htmlspecialchars($quest['pertanyaan']) ?></div>
        <input type="text" class="quest-input" id="questInput" placeholder="Masukkan hasil decode...">
        <button class="quest-submit-btn" id="questSubmit">Kirim</button>

      <?php elseif ($quest['tipe'] === 'easter_egg'): ?>
        <div class="easter-egg-area" id="easterEggArea">
          <div class="easter-egg-hint">Klik di area ini untuk menemukan sesuatu...</div>
          <div class="easter-egg-hidden" id="easterTarget">✨</div>
        </div>
      <?php endif; ?>

      <div class="quest-result" id="questResult"></div>
    </div>
  </div>
  <?php endif; ?>

  <script src="<?= BASE_URL ?>/public/assets/js/sanctuary.js"></script>
</body>
</html>