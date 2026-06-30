/* ==============================
   JKT48 FANSITE — home.js
   ============================== */

// ==============================
// SLIDESHOW
// ==============================
(function () {
  const slidesEl = document.getElementById('slides');
  const dotsEl   = document.getElementById('dots');

  if (!slidesEl || !dotsEl) return;

  const total = slidesEl.children.length;
  let current = 0;
  let timer;

  // Build dots dynamically
  for (let i = 0; i < total; i++) {
    const btn = document.createElement('button');
    btn.className = 'dot' + (i === 0 ? ' active' : '');
    btn.setAttribute('aria-label', 'Slide ' + (i + 1));
    btn.addEventListener('click', () => {
      goTo(i);
      reset();
    });
    dotsEl.appendChild(btn);
  }

  function goTo(n) {
    current = (n + total) % total;
    slidesEl.style.transform = `translateX(-${current * 100}%)`;
    dotsEl.querySelectorAll('.dot').forEach((d, i) => {
      d.classList.toggle('active', i === current);
    });
  }

  function reset() {
    clearInterval(timer);
    timer = setInterval(() => goTo(current + 1), 4000);
  }

  // Swipe support (mobile)
  let startX = 0;
  slidesEl.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
  }, { passive: true });

  slidesEl.addEventListener('touchend', (e) => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) {
      goTo(diff > 0 ? current + 1 : current - 1);
      reset();
    }
  });

  goTo(0);
  reset();
})();

// ==============================
// FLOATING DECORATIONS
// ==============================
(function () {
  const container = document.getElementById('floaties');
  if (!container) return;

  const icons = ['❤️', '🎶', '✨', '🎤', '💖', '🎵', '🌸', '⭐'];

  function spawn() {
    const el = document.createElement('div');
    el.className = 'floatie';
    el.textContent = icons[Math.floor(Math.random() * icons.length)];
    el.style.left = Math.random() * 100 + 'vw';

    const size = Math.random() * 8 + 10; // 10px – 18px
    el.style.fontSize = size + 'px';

    const dur = Math.random() * 3 + 4; // 4s – 7s
    el.style.animationDuration = dur + 's';

    container.appendChild(el);
    setTimeout(() => el.remove(), dur * 1000);
  }

  setInterval(spawn, 350);
})();

// ==============================
// NAVBAR — active link highlight
// ==============================
(function () {
  const links = document.querySelectorAll('.navbar-menu a');
  const path  = window.location.pathname;

  links.forEach((link) => {
    if (link.getAttribute('href') === path ||
        (path === '/' && link.getAttribute('href') === 'index.html')) {
      link.classList.add('active');
    }
  });
})();

// ==============================
// SMOOTH SCROLL (fallback)
// ==============================
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});