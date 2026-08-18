// ============================================================
//  LANDING PAGE — landing.js
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ── Buka tirai ─────────────────────────────────────────
  const opening = document.getElementById('opening');
  const btnOpen = document.getElementById('btnOpen');

  if (btnOpen && opening) {
    btnOpen.addEventListener('click', () => {
      opening.classList.add('fade-out');

      setTimeout(() => {
        opening.style.display = 'none';
        document.body.classList.add('curtains-open');
      }, 800);
    });
  }

  // ── Scroll reveal untuk feature cards & about ──────────
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
      if (el.isIntersecting) {
        el.target.style.opacity = '1';
        el.target.style.transform = 'translateY(0)';
        observer.unobserve(el.target);
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('.playbill-row, .about-title, .about-body').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = `opacity 0.7s ease ${i * 0.08}s, transform 0.7s ease ${i * 0.08}s, background 0.3s`;
    observer.observe(el);
  });

});