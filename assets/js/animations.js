(() => {
  'use strict';

  const reduceMotion = window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduceMotion) return;

  document.addEventListener('DOMContentLoaded', () => {
    const revealEls = document.querySelectorAll('.reveal');
    if (!revealEls.length) return;

    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    revealEls.forEach(el => obs.observe(el));
  });
})();
