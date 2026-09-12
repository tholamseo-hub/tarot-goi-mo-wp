(() => {
  const app = window.TarotGoiMoCore || {};
  const cards = Array.isArray(app.cards) ? app.cards : [];
  const storageKey = app.storageKey || 'tarot-goi-mo:last-draw:v2';

  const byRole = (root, role) => root.querySelector(`[data-tgm="${role}"]`);

  function randomDraw() {
    const card = cards[Math.floor(Math.random() * cards.length)];
    return { card, reversed: Math.random() < 0.5, at: Date.now() };
  }

  function renderDraw(root, draw, persist = true) {
    if (!draw || !draw.card) return;
    const { card, reversed } = draw;
    const empty = byRole(root, 'empty');
    const result = byRole(root, 'result');
    const badge = byRole(root, 'reversed-badge');

    if (empty) empty.hidden = true;
    if (result) result.hidden = false;
    if (badge) badge.hidden = !reversed;

    byRole(root, 'symbol').textContent = card.number || '✦';
    byRole(root, 'orientation').textContent = reversed
      ? 'Đảo ngược · Góc nhìn cần thận trọng'
      : 'Xuôi · Năng lượng đang mở';
    byRole(root, 'number').textContent = card.number || '';
    byRole(root, 'name').textContent = `${card.name_vi || ''} / ${card.name_en || ''}`;
    byRole(root, 'keywords').textContent = card.keywords || '';

    ['overview','love','work','finance','inner','reversed','reminder'].forEach((key) => {
      const el = byRole(root, key);
      if (el) el.textContent = card[key] || '';
    });

    const status = byRole(root, 'status');
    if (status) status.textContent = '';

    if (persist) {
      try { localStorage.setItem(storageKey, JSON.stringify(draw)); } catch (_) {}
    }
  }

  document.querySelectorAll('.tgm-draw-app').forEach((root) => {
    if (!cards.length) return;

    root.querySelector('.tgm-draw-btn')?.addEventListener('click', () => renderDraw(root, randomDraw(), true));
    root.querySelector('.tgm-again-btn')?.addEventListener('click', () => renderDraw(root, randomDraw(), true));

    root.querySelector('.tgm-copy-btn')?.addEventListener('click', async () => {
      const get = (role) => byRole(root, role)?.textContent || '';
      const text = [
        `${get('number')} · ${get('name')}`,
        get('orientation'),
        `Từ khóa: ${get('keywords')}`,
        `Tổng quan: ${get('overview')}`,
        `Tình cảm: ${get('love')}`,
        `Công việc: ${get('work')}`,
        `Tài chính: ${get('finance')}`,
        `Nội tâm: ${get('inner')}`,
        `Đảo ngược: ${get('reversed')}`,
        `Lời nhắc: ${get('reminder')}`
      ].join('\n\n');

      const status = byRole(root, 'status');
      try {
        await navigator.clipboard.writeText(text);
        if (status) status.textContent = app.labels?.copied || 'Đã sao chép lời giải.';
      } catch (_) {
        if (status) status.textContent = app.labels?.copyFailed || 'Không thể sao chép tự động.';
      }
    });

    try {
      const saved = JSON.parse(localStorage.getItem(storageKey) || 'null');
      if (saved?.card && cards.some((card) => card.id === saved.card.id || card.number === saved.card.number)) {
        renderDraw(root, saved, false);
      }
    } catch (_) {}
  });

  document.querySelectorAll('.tgm-arcana-grid').forEach((grid) => {
    grid.querySelectorAll('details').forEach((item) => {
      item.addEventListener('toggle', () => {
        if (!item.open) return;
        grid.querySelectorAll('details[open]').forEach((other) => {
          if (other !== item) other.open = false;
        });
      });
    });
  });
})();
