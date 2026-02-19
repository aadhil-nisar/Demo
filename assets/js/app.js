(() => {
  'use strict';

  function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Tooltips (must be initialized manually)
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
      new bootstrap.Tooltip(el);
    });

    // Bootstrap validation pattern
    document.querySelectorAll('.needs-validation').forEach(form => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      });
    });

    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    const root = document.documentElement;

    function applyTheme(theme) {
      root.setAttribute('data-theme', theme);
      localStorage.setItem('sl_theme', theme);
    }

    const saved = localStorage.getItem('sl_theme');
    if (saved) applyTheme(saved);

    if (themeToggle) {
      themeToggle.addEventListener('click', () => {
        const current = root.getAttribute('data-theme') || 'dark';
        applyTheme(current === 'dark' ? 'light' : 'dark');
      });
    }

    // Scrollspy (Features page)
    if (document.body.dataset.page === 'features') {
      const nav = document.getElementById('featuresNav');
      if (nav) new bootstrap.ScrollSpy(document.body, { target: '#featuresNav' });
    }

    // Global namespace
    window.SLAPP = window.SLAPP || {};
    window.SLAPP.csrf = getCsrfToken();
  });
})();
