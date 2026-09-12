(() => {
  const app = window.TarotGoiMo || {};
  const cards = Array.isArray(app.cards) ? app.cards : [];
  if (!cards.length) return;

  const $ = (id) => document.getElementById(id);
  const els = {
    card: $('drawn-card'), symbol: $('card-symbol'), empty: $('reading-empty'), result: $('reading-result'),
    draw: $('draw-card-btn'), again: $('draw-again-btn'), copy: $('copy-reading-btn'),
    drawStatus: $('draw-status'), resultStatus: $('result-status'), orientation: $('reading-orientation'),
    number: $('reading-number'), name: $('reading-name'), keywords: $('reading-keywords'),
    overview: $('reading-overview'), love: $('reading-love'), work: $('reading-work'), finance: $('reading-finance'),
    inner: $('reading-inner'), reversed: $('reading-reversed'), reminder: $('reading-reminder')
  };
  const storageKey = app.storageKey || 'tarot-goi-mo:last-draw';

  function randomDraw() {
    const card = cards[Math.floor(Math.random() * cards.length)];
    return { card, reversed: Math.random() < 0.5, at: Date.now() };
  }

  function render(draw, persist = true) {
    if (!draw || !draw.card) return;
    const { card, reversed } = draw;
    els.empty.hidden = true;
    els.result.hidden = false;
    els.card.classList.toggle('is-reversed', reversed);
    els.symbol.textContent = card.number || '✦';
    els.orientation.textContent = reversed ? 'Đảo ngược · Góc nhìn cần thận trọng' : 'Xuôi · Năng lượng đang mở';
    els.number.textContent = card.number;
    els.name.textContent = `${card.name_vi} / ${card.name}`;
    els.keywords.textContent = card.keywords;
    els.overview.textContent = card.overview;
    els.love.textContent = card.love;
    els.work.textContent = card.work;
    els.finance.textContent = card.finance;
    els.inner.textContent = card.inner;
    els.reversed.textContent = card.reversed;
    els.reminder.textContent = card.reminder;
    els.resultStatus.textContent = '';
    if (persist) {
      try { localStorage.setItem(storageKey, JSON.stringify(draw)); } catch (_) {}
    }
  }

  function draw() { render(randomDraw(), true); }
  els.draw?.addEventListener('click', draw);
  els.again?.addEventListener('click', draw);

  els.copy?.addEventListener('click', async () => {
    const text = [
      `${els.number.textContent} · ${els.name.textContent}`,
      els.orientation.textContent,
      `Từ khóa: ${els.keywords.textContent}`,
      `Tổng quan: ${els.overview.textContent}`,
      `Tình cảm: ${els.love.textContent}`,
      `Công việc: ${els.work.textContent}`,
      `Tài chính: ${els.finance.textContent}`,
      `Nội tâm: ${els.inner.textContent}`,
      `Đảo ngược: ${els.reversed.textContent}`,
      `Lời nhắc: ${els.reminder.textContent}`
    ].join('\n\n');
    try {
      await navigator.clipboard.writeText(text);
      els.resultStatus.textContent = app.labels?.copied || 'Đã sao chép lời giải.';
    } catch (_) {
      els.resultStatus.textContent = app.labels?.copyFailed || 'Không thể sao chép tự động.';
    }
  });

  try {
    const saved = JSON.parse(localStorage.getItem(storageKey) || 'null');
    if (saved && saved.card && cards.some((c) => c.number === saved.card.number)) render(saved, false);
  } catch (_) {}
})();
