(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page !== 'planner') return;

    const csrf = (window.SLAPP && SLAPP.csrf) ? SLAPP.csrf : '';
    const tripSelect = document.getElementById('tripSelect');
    const tripForm = document.getElementById('createTripForm');
    const itemForm = document.getElementById('addItemForm');
    const addBtn = document.getElementById('addItemBtn');
    const itemsContainer = document.getElementById('itemsContainer');
    const jumpList = document.getElementById('dayJumpList');
    const tripMeta = document.getElementById('tripMeta');

    // Not logged in -> controls not present
    if (!tripSelect || !tripForm || !itemForm) return;

    const toastEl = document.getElementById('slToast');
    const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 2600 }) : null;

    function notify(msg) {
      if (!toast) return;
      document.getElementById('slToastBody').textContent = msg;
      toast.show();
    }

    async function apiGet(url) {
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      return res.json();
    }

    async function apiPost(action, formData) {
      formData.append('action', action);
      const res = await fetch('api/itinerary.php', {
        method: 'POST',
        headers: { 'X-CSRF-Token': csrf },
        body: formData
      });
      return res.json();
    }

    async function loadTrips() {
      tripSelect.innerHTML = '<option value="">Loading…</option>';
      const json = await apiGet('api/itinerary.php?action=listTrips');
      if (!json.ok) { tripSelect.innerHTML = '<option value="">Error</option>'; return; }

      const trips = json.data || [];
      tripSelect.innerHTML = '<option value="">Select a trip…</option>';
      trips.forEach(t => {
        const opt = document.createElement('option');
        opt.value = t.id;
        opt.textContent = t.title;
        tripSelect.appendChild(opt);
      });
    }

    function escapeHtml(s) {
      return String(s)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    function badgeForType(t) {
      if (t === 'food') return '<span class="badge text-bg-warning">Food</span>';
      if (t === 'destination') return '<span class="badge text-bg-info">Destination</span>';
      return '<span class="badge text-bg-light">Activity</span>';
    }

    function groupByDate(items) {
      const map = new Map();
      for (const it of items) {
        const key = it.item_date;
        if (!map.has(key)) map.set(key, []);
        map.get(key).push(it);
      }
      return map;
    }

    function renderJumpLinks(dateKeys) {
      if (!jumpList) return;
      if (!dateKeys.length) {
        jumpList.innerHTML = '<div>No days yet. Add an item.</div>';
        return;
      }
      jumpList.innerHTML = '';
      dateKeys.forEach((d, idx) => {
        const a = document.createElement('a');
        a.href = `#day-${d}`;
        a.className = 'btn btn-sm btn-outline-light text-start';
        a.textContent = `Day ${idx + 1} • ${d}`;
        jumpList.appendChild(a);
      });
    }

    function renderItems(items) {
      if (!items.length) {
        itemsContainer.innerHTML = '<div class="text-white-75">No items yet. Add your first one above.</div>';
        renderJumpLinks([]);
        if (tripMeta) tripMeta.textContent = '';
        return;
      }

      const grouped = groupByDate(items);
      const dates = Array.from(grouped.keys()).sort();
      renderJumpLinks(dates);

      if (tripMeta) tripMeta.textContent = `${dates.length} day(s) • ${items.length} item(s)`;

      const html = [];
      dates.forEach((date, idx) => {
        const dayId = `day-${date}`;
        const dayItems = grouped.get(date);

        html.push(`
          <div class="sl-day mb-3" id="${dayId}">
            <button class="sl-day-header w-100" type="button" data-day-toggle="${dayId}">
              <span class="fw-semibold">Day ${idx + 1}</span>
              <span class="text-white-75 small">${date} • ${dayItems.length} item(s)</span>
              <i class="bi bi-chevron-down"></i>
            </button>
            <div class="sl-day-body" data-day-body="${dayId}">
        `);

        dayItems.forEach(it => {
          const time = it.start_time ? `${it.start_time}` : '—';
          const notes = it.notes ? `<div class="text-white-75 small mt-2">${escapeHtml(it.notes)}</div>` : '';
          html.push(`
            <div class="sl-item">
              <div class="d-flex align-items-start justify-content-between gap-2">
                <div>
                  <div class="d-flex align-items-center gap-2">
                    ${badgeForType(it.item_type)}
                    <div class="text-white-75 small"><i class="bi bi-clock"></i> ${escapeHtml(time)}</div>
                  </div>
                  <div class="fw-semibold mt-2">${escapeHtml(it.destination)}</div>
                  <div class="text-white-75">${escapeHtml(it.activity)}</div>
                  ${notes}
                </div>
                <button class="btn btn-sm btn-outline-light"
                        data-delete-item="${it.id}"
                        data-bs-toggle="tooltip"
                        data-bs-title="Delete this item">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
          `);
        });

        html.push(`</div></div>`);
      });

      itemsContainer.innerHTML = html.join('');
      itemsContainer.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    }

    async function loadItems(tripId) {
      itemsContainer.innerHTML = '<div class="text-white-75">Loading itinerary…</div>';
      const json = await apiGet(`api/itinerary.php?action=listItems&trip_id=${encodeURIComponent(tripId)}`);
      if (!json.ok) {
        itemsContainer.innerHTML = `<div class="text-white-75">Error: ${escapeHtml(json.error || 'Failed')}</div>`;
        return;
      }
      renderItems(json.data || []);
    }

    tripSelect.addEventListener('change', async () => {
      const tripId = tripSelect.value;
      addBtn.disabled = !tripId;
      if (!tripId) {
        itemsContainer.innerHTML = '<div class="text-white-75">Select a trip to load items.</div>';
        return;
      }
      await loadItems(tripId);
      notify('Trip loaded.');
    });

    tripForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!tripForm.checkValidity()) return;

      const fd = new FormData(tripForm);
      const json = await apiPost('createTrip', fd);
      if (!json.ok) { notify(json.error || 'Failed to create trip'); return; }

      await loadTrips();
      const newId = String(json.data.trip_id);
      tripSelect.value = newId;
      tripSelect.dispatchEvent(new Event('change'));
      notify('Trip created.');
      tripForm.reset();
      tripForm.classList.remove('was-validated');
    });

    itemForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!itemForm.checkValidity()) return;

      const tripId = tripSelect.value;
      if (!tripId) { notify('Select a trip first.'); return; }

      const fd = new FormData(itemForm);
      fd.append('trip_id', tripId);

      const json = await apiPost('addItem', fd);
      if (!json.ok) { notify(json.error || 'Failed to add item'); return; }

      await loadItems(tripId);
      notify('Item added.');
      itemForm.reset();
      itemForm.classList.remove('was-validated');
    });

    itemsContainer.addEventListener('click', async (e) => {
      const delBtn = e.target.closest('[data-delete-item]');
      if (delBtn) {
        const itemId = delBtn.getAttribute('data-delete-item');
        if (!confirm('Delete this item?')) return;

        const fd = new FormData();
        fd.append('csrf_token', csrf);
        fd.append('item_id', itemId);

        const json = await apiPost('deleteItem', fd);
        if (!json.ok) { notify(json.error || 'Failed to delete'); return; }

        await loadItems(tripSelect.value);
        notify('Item deleted.');
        return;
      }

      const toggle = e.target.closest('[data-day-toggle]');
      if (toggle) {
        const id = toggle.getAttribute('data-day-toggle');
        const body = itemsContainer.querySelector(`[data-day-body="${id}"]`);
        if (body) body.classList.toggle('d-none');
      }
    });

    // Quick add from Destinations/Foods
    const quick = localStorage.getItem('sl_quick_add');
    if (quick) {
      try {
        const q = JSON.parse(quick);
        document.getElementById('itemType').value = q.item_type || 'activity';
        document.getElementById('destination').value = q.destination || '';
        document.getElementById('activity').value = q.activity || '';
        document.getElementById('notes').value = q.notes || '';
        notify('Quick‑add loaded. Select a trip + choose a date.');
      } catch {}
      localStorage.removeItem('sl_quick_add');
    }

    loadTrips();
  });
})();
