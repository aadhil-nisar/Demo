(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page !== 'destinations') return;

    const data = (window.SL && SL.destinations) ? SL.destinations : [];
    const destGrid = document.getElementById('destGrid');
    const destCategory = document.getElementById('destCategory');
    const destProvince = document.getElementById('destProvince');
    const destSearch = document.getElementById('destSearch');
    const destCount = document.getElementById('destCount');

    const modalEl = document.getElementById('destModal');
    const modal = new bootstrap.Modal(modalEl);
    const modalTitle = document.getElementById('destModalTitle');
    const modalImg = document.getElementById('destModalImg');
    const modalDesc = document.getElementById('destModalDesc');
    const modalMeta = document.getElementById('destModalMeta');
    const quickAddBtn = document.getElementById('destQuickAdd');

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

    const categories = uniqueValues(data, d => d.category);
    const provinces = uniqueValues(data, d => d.province);

    fillSelect(destCategory, 'categories', categories);
    fillSelect(destProvince, 'provinces', provinces);

    function getImg(d) {
      if (!window.SL || !SL.images) return '';
      if (d.category === 'Heritage') return SL.images.Heritage;
      if (d.category === 'Beach') return SL.images.Beach;
      if (d.category === 'HillCountry') return SL.images.HillCountry;
      if (d.category === 'Wildlife') return SL.images.Wildlife;
      if (d.category === 'City') return SL.images.City;
      return SL.images.Heritage;
    }

    function matchesFilters(d) {
      const c = destCategory.value;
      const p = destProvince.value;
      const q = (destSearch.value || '').toLowerCase().trim();

      const catOk = (c === 'all') || (d.category === c);
      const provOk = (p === 'all') || (d.province === p);

      const hay = `${d.name} ${d.province} ${(d.tags || []).join(' ')} ${d.blurb}`.toLowerCase();
      const qOk = !q || hay.includes(q);

      return catOk && provOk && qOk;
    }

    function render() {
      destGrid.innerHTML = '';
      const filtered = data.filter(matchesFilters);

      destCount.textContent = `${filtered.length} destination(s) shown`;

      filtered.forEach(d => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 reveal';

        col.innerHTML = `
          <div class="sl-card h-100 p-0 overflow-hidden sl-click" data-id="${d.id}">
            <img class="sl-card-img" alt="${escapeHtml(d.name)}" src="${getImg(d)}">
            <div class="p-4">
              <h3 class="h5 mb-1">${escapeHtml(d.name)}</h3>
              <div class="text-white-75 small mb-2">${escapeHtml(d.province)} • ${escapeHtml(d.category)}</div>
              <div class="d-flex flex-wrap gap-1">
                ${(d.tags || []).slice(0, 3).map(t => `<span class="badge text-bg-light">${escapeHtml(t)}</span>`).join('')}
              </div>
            </div>
          </div>
        `;
        destGrid.appendChild(col);
      });

      // trigger animation observer again (for newly injected nodes)
      document.querySelectorAll('.reveal').forEach(el => el.classList.add('in-view'));
    }

    function escapeHtml(s) {
      return String(s)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    destCategory.addEventListener('change', render);
    destProvince.addEventListener('change', render);
    destSearch.addEventListener('input', render);

    destGrid.addEventListener('click', (e) => {
      const card = e.target.closest('[data-id]');
      if (!card) return;

      const id = card.getAttribute('data-id');
      active = data.find(x => x.id === id);
      if (!active) return;

      modalTitle.textContent = active.name;
      modalImg.src = getImg(active);
      modalImg.alt = active.name;
      modalDesc.textContent = active.blurb;
      modalMeta.textContent = `${active.category} • ${active.province} • Tags: ${(active.tags || []).join(', ')}`;

      modal.show();
    });

    quickAddBtn.addEventListener('click', () => {
      if (!active) return;
      localStorage.setItem('sl_quick_add', JSON.stringify({
        item_type: 'destination',
        destination: active.name,
        activity: 'Visit / sightseeing',
        notes: `Suggested destination: ${active.name}`
      }));
      window.location.href = 'planner.php';
    });

    render();
  });
})();
