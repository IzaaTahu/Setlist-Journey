// ============================================================
//  WORLD MAP — worldmap.js
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // Scroll reveal untuk tiap journey stop
  const stops = document.querySelectorAll('.journey-stop');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  stops.forEach((stop, i) => {
    stop.style.opacity = '0';
    stop.style.transform = stop.classList.contains('left')
      ? 'translateX(-20px)'
      : 'translateX(20px)';
    stop.style.transition = `opacity 0.6s ease ${i * 0.1}s, transform 0.6s ease ${i * 0.1}s`;
    observer.observe(stop);
  });

  // Trigger visible class
  document.querySelectorAll('.journey-stop.visible').forEach(el => {
    el.style.opacity = '1';
    el.style.transform = 'translateX(0)';
  });

  // Override IntersectionObserver callback untuk apply style
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateX(0)';
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  stops.forEach(stop => io.observe(stop));

});