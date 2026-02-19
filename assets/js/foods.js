(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page !== 'foods') return;

    const data = (window.SL && SL.foods) ? SL.foods : [];
    const grid = document.getElementById('foodGrid');
    const mealSel = document.getElementById('foodMeal');
    const regionSel = document.getElementById('foodRegion');
    const search = document.getElementById('foodSearch');
    const count = document.getElementById('foodCount');

    const modalEl = document.getElementById('foodModal');
    const modal = new bootstrap.Modal(modalEl);
    const titleEl = document.getElementById('foodModalTitle');
    const imgEl = document.getElementById('foodModalImg');
    const descEl = document.getElementById('foodModalDesc');
    const metaEl = document.getElementById('foodModalMeta');
    const quickAdd = document.getElementById('foodQuickAdd');

    let active = null;

    function uniqueValues(arr, fn) {
      return Array.from(new Set(arr.map(fn))).filter(Boolean).sort();
    }

    function fillSelect(select, label, values) {
      select.innerHTML = '';
      const all = document.createElement('option');
      all.value = 'all';
      all.textContent = `All ${label}`;
      select.appendChild(all);

      values.forEach(v => {
        const opt = document.createElement('option');
        opt.value = v;
        opt.textContent = v;
        select.appendChild(opt);
      });
    }

    fillSelect(mealSel, 'meals', uniqueValues(data, x => x.meal));
    fillSelect(regionSel, 'regions', uniqueValues(data, x => x.region));

    function getImg(item) {
      const key = item.imgKey || 'Food';
      return (SL.images && SL.images[key]) ? SL.images[key] : '';
    }

    function matches(item) {
      const m = mealSel.value;
      const r = regionSel.value;
      const q = (search.value || '').toLowerCase().trim();

      const mealOk = (m === 'all') || (item.meal === m);
      const regOk = (r === 'all') || (item.region === r);

      const hay = `${item.name} ${item.meal} ${item.region} ${(item.tags || []).join(' ')} ${item.blurb}`.toLowerCase();
      const qOk = !q || hay.includes(q);

      return mealOk && regOk && qOk;
    }

    function escapeHtml(s) {
      return String(s)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    function render() {
      grid.innerHTML = '';
      const filtered = data.filter(matches);
      count.textContent = `${filtered.length} dish(es) shown`;

      filtered.forEach(f => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 reveal';
        col.innerHTML = `
          <div class="sl-card h-100 p-0 overflow-hidden sl-click" data-id="${f.id}">
            <img class="sl-card-img" alt="${escapeHtml(f.name)}" src="${getImg(f)}">
            <div class="p-4">
              <h3 class="h5 mb-1">${escapeHtml(f.name)}</h3>
              <div class="text-white-75 small mb-2">${escapeHtml(f.meal)} • ${escapeHtml(f.region)}</div>
              <div class="d-flex flex-wrap gap-1">
                ${(f.tags || []).slice(0, 3).map(t => `<span class="badge text-bg-light">${escapeHtml(t)}</span>`).join('')}
              </div>
            </div>
          </div>
        `;
        grid.appendChild(col);
      });

      document.querySelectorAll('.reveal').forEach(el => el.classList.add('in-view'));
    }

    mealSel.addEventListener('change', render);
    regionSel.addEventListener('change', render);
    search.addEventListener('input', render);

    grid.addEventListener('click', (e) => {
      const card = e.target.closest('[data-id]');
      if (!card) return;

      const id = card.getAttribute('data-id');
      active = data.find(x => x.id === id);
      if (!active) return;

      titleEl.textContent = active.name;
      imgEl.src = getImg(active);
      imgEl.alt = active.name;
      descEl.textContent = active.blurb;
      metaEl.textContent = `${active.meal} • ${active.region} • Tags: ${(active.tags || []).join(', ')}`;

      modal.show();
    });

    quickAdd.addEventListener('click', () => {
      if (!active) return;
      localStorage.setItem('sl_quick_add', JSON.stringify({
        item_type: 'food',
        destination: active.region, // where you try it
        activity: `Try: ${active.name}`,
        notes: `Food stop: ${active.name}`
      }));
      window.location.href = 'planner.php';
    });

    render();
  });
})();
