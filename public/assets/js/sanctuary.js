// ============================================================
//  SONG SANCTUARY — sanctuary.js
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ── Config ──────────────────────────────────────────────
  const temaHex   = document.body.dataset.tema       || '#4A90B8';
  const questId   = document.body.dataset.questId    || '';
  const trackId   = document.body.dataset.trackId    || '';
  const questTipe = document.body.dataset.questTipe  || '';
  const durasi    = parseInt(document.body.dataset.durasi || '0');
  const submitUrl = document.body.dataset.submitUrl  || '';
  const nextUrl   = document.body.dataset.nextUrl    || '';

  function hexToRgb(hex) {
    const c = hex.replace('#', '');
    return {
      r: parseInt(c.substring(0, 2), 16),
      g: parseInt(c.substring(2, 4), 16),
      b: parseInt(c.substring(4, 6), 16),
    };
  }
  const rgb = hexToRgb(temaHex);

  // ── Canvas bubble ────────────────────────────────────────
  const canvas = document.getElementById('deco-canvas');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let W, H;
    const resize = () => { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; };
    resize();
    window.addEventListener('resize', resize);

    const bubbles = [];
    const mkBubble = () => ({
      x: Math.random() * W, y: H + Math.random() * 80,
      r: 3 + Math.random() * 14, speed: 0.3 + Math.random() * 0.8,
      phase: Math.random() * Math.PI * 2, opacity: 0.1 + Math.random() * 0.2,
    });

    for (let i = 0; i < 20; i++) { const b = mkBubble(); b.y = Math.random() * H; bubbles.push(b); }

    const draw = () => {
      ctx.clearRect(0, 0, W, H);
      bubbles.forEach((b, i) => {
        b.y -= b.speed; b.x += Math.sin(b.phase) * 0.25; b.phase += 0.02;
        ctx.save(); ctx.globalAlpha = b.opacity;
        const g = ctx.createRadialGradient(b.x - b.r*.3, b.y - b.r*.3, b.r*.05, b.x, b.y, b.r);
        g.addColorStop(0, 'rgba(255,255,255,0.95)');
        g.addColorStop(0.3, `rgba(${rgb.r},${rgb.g},${rgb.b},0.3)`);
        g.addColorStop(1, `rgba(${rgb.r},${rgb.g},${rgb.b},0.04)`);
        ctx.beginPath(); ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
        ctx.fillStyle = g; ctx.fill();
        ctx.strokeStyle = 'rgba(255,255,255,0.5)'; ctx.lineWidth = 0.7; ctx.stroke();
        ctx.restore();
        if (b.y + b.r < 0) bubbles[i] = mkBubble();
      });
      requestAnimationFrame(draw);
    };
    draw();
  }

  // ── Sections & dots ─────────────────────────────────────
  const sections = document.querySelectorAll('.sanctuary-section');
  const dots     = document.querySelectorAll('.dot');

  window.scrollToSection = (idx) => {
    const t = sections[idx];
    if (t) t.scrollIntoView({ behavior: 'smooth' });
  };

  const sectionObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const idx = Array.from(sections).indexOf(e.target);
      dots.forEach((d, i) => d.classList.toggle('active', i === idx));
    });
  }, { threshold: 0.6 });

  sections.forEach(s => sectionObs.observe(s));
  dots.forEach((d, i) => d.addEventListener('click', () => scrollToSection(i)));

  // ── Audio ────────────────────────────────────────────────
  const audioBtn  = document.getElementById('audioBtn');
  const audioEl   = document.getElementById('audioEl');
  const iconPlay  = document.getElementById('iconPlay');
  const iconPause = document.getElementById('iconPause');

  if (audioBtn && audioEl) {
    audioBtn.addEventListener('click', () => {
      if (audioEl.paused) {
        audioEl.play();
        iconPlay.style.display = 'none'; iconPause.style.display = 'block';
      } else {
        audioEl.pause();
        iconPlay.style.display = 'block'; iconPause.style.display = 'none';
      }
    });
    audioEl.addEventListener('ended', () => {
      iconPlay.style.display = 'block'; iconPause.style.display = 'none';
    });
  }

  // ── Milestone ────────────────────────────────────────────
  const milestoneOverlay = document.getElementById('milestoneOverlay');
  window.closeMilestone = () => {
    if (!milestoneOverlay) return;
    milestoneOverlay.style.opacity = '0';
    milestoneOverlay.style.transition = 'opacity 0.3s';
    setTimeout(() => milestoneOverlay.remove(), 300);
  };
  if (milestoneOverlay) setTimeout(() => milestoneOverlay.style.display = 'flex', 800);

  // ── BACA LORE — inline timer, bukan popup ───────────────
  // Timer muncul di dalam section (di bawah konten), tidak nutupin teks

  window.mulaiTimer = () => {
    const mulaiBtn       = document.getElementById('mulaiBtn');
    const lanjutBtn      = document.getElementById('lanjutBtn');
    const timerWrap      = document.getElementById('inlineTimerWrap');
    const timerCount     = document.getElementById('inlineTimerCount');
    const timerFill      = document.getElementById('inlineTimerFill');

    if (!mulaiBtn || !timerWrap) return;

    // Sembunyikan tombol mulai, tampilkan timer
    mulaiBtn.style.display  = 'none';
    timerWrap.style.display = 'block';

    let remaining = durasi;
    const total   = durasi;

    const interval = setInterval(() => {
      remaining--;
      if (timerCount) timerCount.textContent = remaining;
      // Update progress bar
      if (timerFill) timerFill.style.width = ((total - remaining) / total * 100) + '%';

      if (remaining <= 0) {
        clearInterval(interval);
        // Sembunyikan timer, tampilkan tombol lanjut
        timerWrap.style.display  = 'none';
        if (lanjutBtn) lanjutBtn.style.display = 'inline-flex';
      }
    }, 1000);
  };

  window.submitLoreDone = () => submitQuest('baca_lore_done');

  // ── Quest popup — untuk tipe selain baca_lore ───────────
  const questOverlay = document.getElementById('questOverlay');

  window.showQuest = () => {
    if (!questOverlay) return;
    questOverlay.style.display = 'flex';
    if (questTipe === 'easter_egg') initEasterEgg();
  };

  // ── Easter egg ───────────────────────────────────────────
  function initEasterEgg() {
    const area   = document.getElementById('easterEggArea');
    const target = document.getElementById('easterTarget');
    if (!area || !target) return;

    target.style.top  = (10 + Math.random() * 60) + '%';
    target.style.left = (10 + Math.random() * 70) + '%';

    area.addEventListener('click', (e) => {
      const rect = area.getBoundingClientRect();
      const tx   = parseFloat(target.style.left) / 100 * rect.width  + rect.left;
      const ty   = parseFloat(target.style.top)  / 100 * rect.height + rect.top;
      const dist = Math.hypot(e.clientX - tx, e.clientY - ty);

      if (dist < 44) {
        target.style.opacity = '1'; target.style.fontSize = '2.5rem';
        setTimeout(() => submitQuest('easter_egg_found'), 600);
      } else {
        const hint = area.querySelector('.easter-egg-hint');
        if (hint) {
          hint.textContent = 'Hampir! Coba lagi...';
          setTimeout(() => hint.textContent = 'Klik di area ini untuk menemukan sesuatu...', 1200);
        }
      }
    });
  }

  // ── Trivia options ───────────────────────────────────────
  document.querySelectorAll('.quest-option-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.quest-option-btn').forEach(b => b.disabled = true);
      submitQuest(btn.dataset.value, btn);
    });
  });

  // ── Submit input/textarea ────────────────────────────────
  const submitBtn = document.getElementById('questSubmit');
  if (submitBtn && !['baca_lore', 'easter_egg'].includes(questTipe)) {
    submitBtn.addEventListener('click', () => {
      const input = document.getElementById('questInput');
      if (!input || !input.value.trim()) return;
      submitQuest(input.value.trim());
    });
  }

  // ── Submit ke server ─────────────────────────────────────
  async function submitQuest(jawaban, optionEl = null) {
    const resultEl = document.getElementById('questResult');

    if (!questId || !trackId || !submitUrl) {
      window.location.href = nextUrl || '/';
      return;
    }

    try {
      const res = await fetch(submitUrl, {
        method:  'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body:    new URLSearchParams({ quest_id: questId, track_id: trackId, jawaban }),
      });

      const data = await res.json();

      if (data.is_correct === false) {
        if (optionEl) optionEl.classList.add('wrong');
        if (resultEl) { resultEl.className = 'quest-result wrong'; resultEl.textContent = '❌ Kurang tepat. Coba lagi!'; }
        setTimeout(() => {
          document.querySelectorAll('.quest-option-btn').forEach(b => b.disabled = false);
          if (resultEl) resultEl.textContent = '';
        }, 1500);
        return;
      }

      if (optionEl) optionEl.classList.add('correct');
      if (resultEl) {
        resultEl.className   = 'quest-result correct';
        resultEl.textContent = data.is_correct ? '✅ Benar! Menuju lagu berikutnya...' : '✅ Tersimpan! Menuju lagu berikutnya...';
      }

      setTimeout(() => { window.location.href = data.next_url || nextUrl; }, 1400);

    } catch (err) {
      console.error('Quest error:', err);
      setTimeout(() => { window.location.href = nextUrl; }, 800);
    }
  }

});