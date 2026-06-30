// ============================================================
//  CHAPTER MAP — chapter.js
//  Multi-dekorasi system
//  Dekorasi: bubble | confetti | fire | none
//  Tambah dekorasi baru: buat fungsi init + daftarkan di DECO_MAP
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ── Setup canvas ────────────────────────────────────────
  const canvas = document.getElementById('deco-canvas');
  const ctx    = canvas ? canvas.getContext('2d') : null;
  let W = window.innerWidth, H = window.innerHeight; // Berikan nilai default awal agar tidak 0

  function resize() {
  if (!canvas) return;
  // Gunakan Math.max untuk memastikan jika innerWidth/Height terbaca 0, ia punya fallback size minimal layar browser
  W = canvas.width  = Math.max(window.innerWidth, document.documentElement.clientWidth || 360);
  H = canvas.height = Math.max(window.innerHeight, document.documentElement.clientHeight || 640);
}

// Jalankan resize setelah DOM fully loaded
setTimeout(resize, 0);
window.addEventListener('resize', resize);

  // ── Ambil config dari body ──────────────────────────────
  const dekorasi = document.body.dataset.dekorasi || 'none';
  const temaHex  = document.body.dataset.tema || '#4A90B8';

  function hexToRgb(hex) {
    const c = hex.replace('#','');
    return {
      r: parseInt(c.substring(0,2),16),
      g: parseInt(c.substring(2,4),16),
      b: parseInt(c.substring(4,6),16),
    };
  }
  const rgb = hexToRgb(temaHex);

  function randomBetween(a, b) { return a + Math.random() * (b - a); }

  // ============================================================
  //  DEKORASI 1: BUBBLE (Cara Meminum Ramune)
  // ============================================================
  function initBubble() {
    const bubbles = [];

    function createBubble() {
      return {
        x:      randomBetween(0, W),
        y:      H + randomBetween(10, 80),
        r:      randomBetween(4, 20),
        speed:  randomBetween(0.35, 1.1),
        drift:  randomBetween(-0.25, 0.25),
        phase:  randomBetween(0, Math.PI * 2),
        opacity:randomBetween(0.18, 0.42),
      };
    }

    for (let i = 0; i < 30; i++) {
      const b = createBubble();
      b.y = randomBetween(0, H);
      bubbles.push(b);
    }

    function draw() {
      ctx.clearRect(0, 0, W, H);
      bubbles.forEach((b, i) => {
        b.y     -= b.speed;
        b.x     += Math.sin(b.phase) * 0.3;
        b.phase += 0.02;
        b.opacity = 0.25 + Math.sin(b.phase * 0.5) * 0.1;

        ctx.save();
        ctx.globalAlpha = b.opacity;

        const grad = ctx.createRadialGradient(
          b.x - b.r * 0.3, b.y - b.r * 0.3, b.r * 0.05,
          b.x, b.y, b.r
        );
        grad.addColorStop(0,   `rgba(255,255,255,0.92)`);
        grad.addColorStop(0.3, `rgba(${rgb.r},${rgb.g},${rgb.b},0.35)`);
        grad.addColorStop(1,   `rgba(${rgb.r},${rgb.g},${rgb.b},0.06)`);

        ctx.beginPath();
        ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
        ctx.fillStyle = grad;
        ctx.fill();
        ctx.strokeStyle = 'rgba(255,255,255,0.55)';
        ctx.lineWidth = 0.8;
        ctx.stroke();

        // Shimmer
        ctx.globalAlpha = b.opacity * 0.7;
        ctx.beginPath();
        ctx.arc(b.x - b.r*0.28, b.y - b.r*0.28, b.r*0.22, 0, Math.PI*2);
        ctx.fillStyle = 'rgba(255,255,255,0.9)';
        ctx.fill();
        ctx.restore();

        if (b.y + b.r < 0) bubbles[i] = createBubble();
      });
      requestAnimationFrame(draw);
    }
    draw();
  }

  // ============================================================
  //  DEKORASI 2: CONFETTI PITA (Sambil Menggandeng Erat Tanganmu)
  // ============================================================
  function initConfetti() {
    const pieces = [];
    const SHAPES = ['ribbon', 'circle', 'rect'];
    // Warna confetti dari turunan tema + putih + gold kecil
    const COLORS = [
      `rgba(${rgb.r},${rgb.g},${rgb.b},0.7)`,
      `rgba(255,255,255,0.8)`,
      `rgba(${Math.min(rgb.r+60,255)},${Math.min(rgb.g+30,255)},${Math.min(rgb.b+60,255)},0.65)`,
      `rgba(255,230,200,0.7)`,
      `rgba(${rgb.r},${rgb.g},${rgb.b},0.45)`,
      `rgba(255,255,255,0.6)`,
    ];

    function createPiece() {
      const shape = SHAPES[Math.floor(Math.random() * SHAPES.length)];
      return {
        x:       randomBetween(0, W),
        y:       -randomBetween(10, 100),
        w:       shape === 'ribbon' ? randomBetween(3, 6)  : randomBetween(5, 10),
        h:       shape === 'ribbon' ? randomBetween(12, 22) : randomBetween(5, 10),
        r:       randomBetween(0, Math.PI * 2),
        rSpeed:  randomBetween(-0.06, 0.06),
        speedY:  randomBetween(0.8, 2.2),
        speedX:  randomBetween(-0.5, 0.5),
        color:   COLORS[Math.floor(Math.random() * COLORS.length)],
        shape,
        wave:    randomBetween(0, Math.PI * 2),
        waveAmp: randomBetween(0.3, 1.2),
        opacity: randomBetween(0.5, 0.9),
      };
    }

    for (let i = 0; i < 55; i++) {
      const p = createPiece();
      p.y = randomBetween(-200, H);
      pieces.push(p);
    }

    function draw() {
      ctx.clearRect(0, 0, W, H);
      pieces.forEach((p, i) => {
        p.y     += p.speedY;
        p.x     += p.speedX + Math.sin(p.wave) * p.waveAmp;
        p.r     += p.rSpeed;
        p.wave  += 0.04;

        ctx.save();
        ctx.globalAlpha = p.opacity;
        ctx.translate(p.x, p.y);
        ctx.rotate(p.r);
        ctx.fillStyle = p.color;

        if (p.shape === 'ribbon') {
          // Pita melengkung
          ctx.beginPath();
          ctx.ellipse(0, 0, p.w/2, p.h/2, 0, 0, Math.PI*2);
          ctx.fill();
        } else if (p.shape === 'circle') {
          ctx.beginPath();
          ctx.arc(0, 0, p.w/2, 0, Math.PI*2);
          ctx.fill();
        } else {
          ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h);
        }

        ctx.restore();

        if (p.y > H + 30) {
          pieces[i] = createPiece();
        }
      });
      requestAnimationFrame(draw);
    }
    draw();
  }

  // ============================================================
  //  DEKORASI 3: FIRE (Passion 200%)
  // ============================================================
  function initFire() {
    const particles = [];
    // Base warna api dari tema — kalau tema gelap/merah, apinya natural
    // Kalau tema lain, tetap pakai oranye-merah khas api
    const FIRE_COLORS = [
      [255, 60,  0 ],   // merah api
      [255, 120, 0 ],   // oranye
      [255, 180, 20],   // kuning oranye
      [255, 220, 60],   // kuning
      [255, 255, 160],  // kuning terang (puncak)
    ];

    function createParticle(x, y) {
      const colorIdx = Math.floor(Math.random() * FIRE_COLORS.length);
      const [r, g, b] = FIRE_COLORS[colorIdx];
      return {
        x:      x ?? randomBetween(W * 0.1, W * 0.9),
        y:      y ?? H + 10,
        r:      randomBetween(8, 28),
        speedY: randomBetween(1.2, 3.5),
        speedX: randomBetween(-0.8, 0.8),
        life:   1.0,
        decay:  randomBetween(0.008, 0.02),
        cr: r, cg: g, cb: b,
        flicker: randomBetween(0, Math.PI * 2),
      };
    }

    // Spawn titik api di bawah
    const SOURCES = [0.15, 0.35, 0.5, 0.65, 0.85];
    SOURCES.forEach(pos => {
      for (let i = 0; i < 12; i++) {
        const p = createParticle(W * pos + randomBetween(-40, 40), H);
        p.y = randomBetween(H * 0.6, H);
        particles.push(p);
      }
    });

    function draw() {
      ctx.clearRect(0, 0, W, H);

      // Spawn partikel baru terus menerus
      SOURCES.forEach(pos => {
        if (Math.random() < 0.4) {
          particles.push(
            createParticle(W * pos + randomBetween(-50, 50), H)
          );
        }
      });

      // Batasi jumlah partikel
      while (particles.length > 200) particles.shift();

      particles.forEach((p, i) => {
        p.y       -= p.speedY;
        p.x       += p.speedX;
        p.r       *= 0.992;
        p.life    -= p.decay;
        p.flicker += 0.15;
        p.speedX  += randomBetween(-0.1, 0.1); // goyangan api

        if (p.life <= 0 || p.r < 1) {
          particles.splice(i, 1);
          return;
        }

        // Flicker opacity
        const flicker = 0.85 + Math.sin(p.flicker) * 0.15;
        const alpha   = p.life * flicker * 0.55;

        ctx.save();
        ctx.globalAlpha = alpha;

        const grad = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r);
        grad.addColorStop(0,   `rgba(255,255,220,0.9)`);
        grad.addColorStop(0.3, `rgba(${p.cr},${p.cg},${p.cb},0.8)`);
        grad.addColorStop(0.7, `rgba(${p.cr},${Math.max(p.cg-40,0)},0,0.4)`);
        grad.addColorStop(1,   `rgba(80,0,0,0)`);

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = grad;
        ctx.fill();

        ctx.restore();
      });

      // Glow di bawah
      const glowGrad = ctx.createLinearGradient(0, H * 0.75, 0, H);
      glowGrad.addColorStop(0, 'rgba(255,80,0,0)');
      glowGrad.addColorStop(1, 'rgba(255,60,0,0.18)');
      ctx.fillStyle = glowGrad;
      ctx.fillRect(0, H * 0.75, W, H * 0.25);

      requestAnimationFrame(draw);
    }
    draw();
  }

  // ============================================================
  //  DECO MAP — daftarkan semua dekorasi di sini
  //  Untuk tambah dekorasi baru:
  //  1. Buat fungsi initNamaDekorasi()
  //  2. Tambahkan ke DECO_MAP: 'nama': initNamaDekorasi
  // ============================================================
  const DECO_MAP = {
    bubble:   initBubble,
    confetti: initConfetti,
    fire:     initFire,
  };

  // Jalankan dekorasi SETELAH resize selesai
setTimeout(() => {
    // GANTI baris pengeksekusi dekorasi di paling bawah chapter.js dengan ini:

// Pastikan ukuran canvas langsung disesuaikan secara akurat
resize(); 

// DEBUG: Lihat kondisi canvas
console.log("=== DECORATION DEBUG ===");
console.log("Canvas element:", canvas);
console.log("Context:", ctx);
console.log("Dekorasi from body:", dekorasi);
console.log("DECO_MAP keys:", Object.keys(DECO_MAP));
console.log("Dekorasi ada di DECO_MAP?", dekorasi in DECO_MAP);
console.log("Canvas dimensions:", W, "x", H);

// Jalankan dekorasi dengan aman
if (ctx && dekorasi !== 'none' && DECO_MAP[dekorasi]) {
    console.log("✓ Menjalankan dekorasi:", dekorasi); // Untuk memantau di console browser
    try {
        DECO_MAP[dekorasi]();
        console.log("✓ Dekorasi berhasil dijalankan");
    } catch (e) {
        console.error("✗ Error saat menjalankan dekorasi:", e);
    }
} else {
    console.warn("✗ Dekorasi tidak dijalankan. Kondisi:");
    console.warn("  - ctx:", !!ctx);
    console.warn("  - dekorasi !== 'none':", dekorasi !== 'none');
    console.warn("  - DECO_MAP[dekorasi]:", DECO_MAP[dekorasi]);
}
}, 50);

  // ============================================================
  //  SCROLL REVEAL
  // ============================================================
  const stops = document.querySelectorAll('.track-stop');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateX(0)';
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  stops.forEach((stop, i) => {
    const isLeft = stop.classList.contains('left');
    stop.style.opacity = '0';
    stop.style.transform = isLeft ? 'translateX(-20px)' : 'translateX(20px)';
    stop.style.transition = `opacity 0.55s ease ${i * 0.05}s, transform 0.55s ease ${i * 0.05}s`;
    io.observe(stop);
  });

  // Auto scroll ke current track
  const current = document.querySelector('.track-stop.current');
  if (current) {
    setTimeout(() => {
      current.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 500);
  }

});