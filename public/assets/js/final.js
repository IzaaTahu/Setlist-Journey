// ============================================================
//  FINAL STAGE — final.js
//  Partikel bintang + scroll reveal
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  const temaHex = document.body.dataset.tema || '#4A90B8';

  function hexToRgb(hex) {
    const c = hex.replace('#', '');
    return {
      r: parseInt(c.substring(0, 2), 16),
      g: parseInt(c.substring(2, 4), 16),
      b: parseInt(c.substring(4, 6), 16),
    };
  }
  const rgb = hexToRgb(temaHex);

  // ── Partikel bintang di canvas ───────────────────────────
  const canvas = document.getElementById('deco-canvas');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let W, H;

    const resize = () => {
      W = canvas.width  = window.innerWidth;
      H = canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const stars = [];
    const mkStar = () => ({
      x:       Math.random() * W,
      y:       Math.random() * H,
      r:       0.5 + Math.random() * 1.5,
      opacity: 0.1 + Math.random() * 0.4,
      phase:   Math.random() * Math.PI * 2,
      speed:   0.005 + Math.random() * 0.01,
    });

    for (let i = 0; i < 80; i++) stars.push(mkStar());

    // Partikel naik pelan
    const particles = [];
    const mkParticle = () => ({
      x:       Math.random() * W,
      y:       H + Math.random() * 50,
      r:       1 + Math.random() * 3,
      speed:   0.2 + Math.random() * 0.6,
      opacity: 0.08 + Math.random() * 0.18,
      phase:   Math.random() * Math.PI * 2,
    });

    for (let i = 0; i < 25; i++) {
      const p = mkParticle(); p.y = Math.random() * H; particles.push(p);
    }

    const draw = () => {
      ctx.clearRect(0, 0, W, H);

      // Bintang berkelip
      stars.forEach(s => {
        s.phase += s.speed;
        const alpha = s.opacity * (0.6 + Math.sin(s.phase) * 0.4);
        ctx.save();
        ctx.globalAlpha = alpha;
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${rgb.r},${rgb.g},${rgb.b},1)`;
        ctx.fill();
        ctx.restore();
      });

      // Partikel naik
      particles.forEach((p, i) => {
        p.y     -= p.speed;
        p.x     += Math.sin(p.phase) * 0.2;
        p.phase += 0.02;

        ctx.save();
        ctx.globalAlpha = p.opacity;
        const g = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r);
        g.addColorStop(0, `rgba(${rgb.r},${rgb.g},${rgb.b},0.8)`);
        g.addColorStop(1, `rgba(${rgb.r},${rgb.g},${rgb.b},0)`);
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = g;
        ctx.fill();
        ctx.restore();

        if (p.y + p.r < 0) particles[i] = mkParticle();
      });

      requestAnimationFrame(draw);
    };
    draw();
  }

  // ── Scroll reveal ─────────────────────────────────────────
  const revealEls = document.querySelectorAll(
    '.track-recap-item, .entry-card, .stat-card, .next-inner'
  );

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity   = '1';
        entry.target.style.transform = 'translateY(0)';
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  revealEls.forEach((el, i) => {
    el.style.opacity   = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = `opacity 0.5s ease ${i * 0.04}s, transform 0.5s ease ${i * 0.04}s`;
    io.observe(el);
  });

});