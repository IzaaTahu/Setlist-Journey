// assets/js/quest.js

document.addEventListener('DOMContentLoaded', () => {
  const questBox = document.getElementById('quest-box');
  if (!questBox) return;

  const questId  = questBox.dataset.questId;
  const trackId  = questBox.dataset.trackId;
  const result   = document.getElementById('quest-result');

  // ── Trivia: klik opsi ──────────────────────────────────────
  document.querySelectorAll('.option-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      submitQuest(btn.dataset.value);
    });
  });

  // ── Input / textarea: klik tombol submit ───────────────────
  const submitBtn = document.getElementById('submit-quest');
  if (submitBtn) {
    submitBtn.addEventListener('click', () => {
      const input = document.getElementById('jawaban-input');
      submitQuest(input?.value ?? '');
    });
  }

  // ── Timer untuk tipe baca_lore ─────────────────────────────
  const timerEl = document.getElementById('timer');
  if (timerEl && submitBtn) {
    let seconds = parseInt(timerEl.textContent, 10);
    const interval = setInterval(() => {
      seconds--;
      timerEl.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(interval);
        submitBtn.disabled = false;
        submitBtn.textContent = 'Lanjutkan →';
        submitBtn.addEventListener('click', () => submitQuest('baca_lore_done'), { once: true });
      }
    }, 1000);
  }

  // ── Kirim jawaban ke server ────────────────────────────────
  async function submitQuest(jawaban) {
    if (!jawaban.trim()) return;

    const res = await fetch('/quest/submit', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ quest_id: questId, track_id: trackId, jawaban }),
    });

    const data = await res.json();

    if (data.is_correct === false) {
      result.innerHTML = '<p class="wrong">Jawaban kurang tepat, coba lagi.</p>';
      return;
    }

    result.innerHTML = '<p class="correct">Benar — menuju lagu berikutnya...</p>';

    setTimeout(() => {
      window.location.href = data.next_url;
    }, 1200);
  }
});
