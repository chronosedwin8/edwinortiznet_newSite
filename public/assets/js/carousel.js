// Carrusel de imágenes (.carousel-gallery) — módulo sin dependencias.
//
// Marcado que se guarda (HtmlCleaner lo garantiza y ContentRenderer::carousels() le añade role="region",
// aria-roledescription, aria-label, tabindex, --cg-ratio y los textos data-label-*):
//   <div class="carousel-gallery" [data-autoplay="segundos"]>
//     <figure class="carousel-gallery__item"><img …><figcaption>…</figcaption></figure> …
//   </div>
// Sin JavaScript es una tira horizontal con scroll-snap (se desliza con el dedo, la rueda o el teclado).
// Este módulo añade: botones anterior/siguiente, contador «2 / 5», puntos (hasta 10 diapositivas), flechas,
// Inicio/Fin, arrastre con el ratón, anuncio en aria-live y avance automático opcional (apagado por defecto,
// nunca con «reducir movimiento», con botón de pausa y en pausa al pasar el puntero o enfocar).
// Reutilizable fuera de los artículos: enhance(elemento) con cualquier contenedor .carousel-gallery.

const reduced = matchMedia('(prefers-reduced-motion: reduce)');
const DEFAULTS = {
  Prev: 'Anterior', Next: 'Siguiente', Goto: ':i', Status: ':i / :n', Pause: 'Pausa', Play: 'Reproducir',
};
const svg = (d) => `<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false"><path d="${d}" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
const ICONS = {
  prev: svg('M15 5l-7 7 7 7'),
  next: svg('M9 5l7 7-7 7'),
  pause: svg('M9 6v12M15 6v12'),
  play: '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false"><path d="M8 5.5v13l10.5-6.5z" fill="currentColor"/></svg>',
};
let uid = 0;

export function enhance(track) {
  if (!track || track.dataset.cgReady) return null;
  const slides = [...track.children].filter((el) => el.nodeType === 1 && el.tagName !== 'BUTTON');
  if (slides.length < 2) return null;
  track.dataset.cgReady = '1';
  if (!track.id) track.id = `carrusel-js-${++uid}`;
  const n = slides.length;
  const label = (key, vars = {}) => (track.dataset[`label${key}`] || DEFAULTS[key]).replace(/:(\w+)/g, (_, v) => vars[v] ?? '');
  const behavior = () => (reduced.matches ? 'auto' : 'smooth');

  // Envoltura: los controles quedan fuera del contenedor que se desplaza.
  const shell = document.createElement('div');
  shell.className = 'cg';
  const ratio = track.style.getPropertyValue('--cg-ratio');
  if (ratio) shell.style.setProperty('--cg-ratio', ratio);
  track.before(shell);
  shell.append(track);
  if (!track.hasAttribute('tabindex')) track.tabIndex = 0;
  slides.forEach((s) => s.querySelectorAll('img').forEach((img) => { img.draggable = false; }));

  const frame = document.createElement('div');
  frame.className = 'cg__frame';
  const button = (cls, html, text) => {
    const b = document.createElement('button');
    b.type = 'button';
    b.className = `cg__btn ${cls}`;
    b.innerHTML = html;
    b.setAttribute('aria-label', text);
    b.setAttribute('aria-controls', track.id);
    return b;
  };
  const prev = button('cg__btn--prev', ICONS.prev, label('Prev'));
  const next = button('cg__btn--next', ICONS.next, label('Next'));
  const count = document.createElement('span');
  count.className = 'cg__count';
  count.setAttribute('aria-hidden', 'true');
  frame.append(prev, next, count);

  let dots = [];
  if (n <= 10) {
    const nav = document.createElement('div');
    nav.className = 'cg__dots';
    dots = slides.map((_, i) => {
      const d = document.createElement('button');
      d.type = 'button';
      d.className = 'cg__dot';
      d.setAttribute('aria-label', label('Goto', { i: i + 1, n }));
      d.setAttribute('aria-controls', track.id);
      d.addEventListener('click', () => go(i, true));
      nav.append(d);
      return d;
    });
    frame.append(nav);
  }
  const live = document.createElement('p');
  live.className = 'visually-hidden';
  live.setAttribute('aria-live', 'polite');
  live.setAttribute('aria-atomic', 'true');
  shell.append(frame, live);

  let index = 0;
  let announce = false;
  const offset = (i) => slides[i].offsetLeft - slides[0].offsetLeft;
  const nearest = () => {
    let best = 0;
    let dist = Infinity;
    slides.forEach((_, i) => {
      const d = Math.abs(offset(i) - track.scrollLeft);
      if (d < dist) { dist = d; best = i; }
    });
    return best;
  };
  const describe = (i) => {
    const s = slides[i];
    const text = (s.querySelector('figcaption')?.textContent || s.querySelector('img')?.alt || '').trim();
    return label('Status', { i: i + 1, n }) + (text ? `: ${text}` : '');
  };
  const preload = (i) => {
    const img = slides[i]?.querySelector('img[loading="lazy"]');
    if (img) img.loading = 'eager';
  };
  const paint = () => {
    count.textContent = `${index + 1} / ${n}`;
    prev.disabled = index === 0;
    next.disabled = index === n - 1;
    dots.forEach((d, i) => (i === index ? d.setAttribute('aria-current', 'true') : d.removeAttribute('aria-current')));
    slides.forEach((s, i) => s.classList.toggle('is-current', i === index));
    preload(index + 1);
  };
  const settle = () => {
    const i = nearest();
    const changed = i !== index;
    index = i;
    paint();
    if (changed && announce && !playing) live.textContent = describe(i);
  };
  function go(i, fromUser = false) {
    const target = Math.max(0, Math.min(n - 1, i));
    if (fromUser) { announce = true; stop(true); }
    preload(target);
    track.scrollTo({ left: offset(target), behavior: behavior() });
    if (target === index) settle();
  }

  prev.addEventListener('click', () => go(index - 1, true));
  next.addEventListener('click', () => go(index + 1, true));
  let scrollTimer = 0;
  track.addEventListener('scroll', () => {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(settle, 90);
  }, { passive: true });
  shell.addEventListener('keydown', (e) => {
    if (e.altKey || e.ctrlKey || e.metaKey || e.target.closest('input, textarea, select')) return;
    const map = { ArrowLeft: index - 1, ArrowRight: index + 1, Home: 0, End: n - 1 };
    if (!(e.key in map)) return;
    e.preventDefault();
    go(map[e.key], true);
  });
  // Conserva la diapositiva visible al cambiar el ancho (girar el teléfono, abrir la barra lateral…).
  if ('ResizeObserver' in window) {
    let width = track.clientWidth;
    new ResizeObserver(() => {
      if (track.clientWidth === width) return;
      width = track.clientWidth;
      track.scrollTo({ left: offset(index), behavior: 'auto' });
    }).observe(track);
  }

  // Arrastrar con el ratón (en táctil ya lo hace el desplazamiento nativo).
  let drag = null;
  let suppressClick = false;
  track.addEventListener('pointerdown', (e) => {
    if (e.pointerType !== 'mouse' || e.button !== 0) return;
    drag = { x: e.clientX, left: track.scrollLeft, moved: false };
  });
  track.addEventListener('pointermove', (e) => {
    if (!drag) return;
    const dx = e.clientX - drag.x;
    if (!drag.moved && Math.abs(dx) < 6) return;
    if (!drag.moved) { drag.moved = true; track.setPointerCapture(e.pointerId); track.classList.add('is-dragging'); }
    track.scrollLeft = drag.left - dx;
  });
  const endDrag = (e) => {
    if (!drag) return;
    const { moved, x } = drag;
    drag = null;
    if (!moved) return;
    track.classList.remove('is-dragging');
    suppressClick = true;
    setTimeout(() => { suppressClick = false; }, 0);
    if (track.hasPointerCapture?.(e.pointerId)) track.releasePointerCapture(e.pointerId);
    const dx = e.clientX - x;
    const start = nearest();
    go(Math.abs(dx) > 40 && start === index ? index + (dx < 0 ? 1 : -1) : start, true);
  };
  track.addEventListener('pointerup', endDrag);
  track.addEventListener('pointercancel', endDrag);
  track.addEventListener('click', (e) => { if (suppressClick) { e.preventDefault(); e.stopPropagation(); } }, true);

  // Avance automático opcional: data-autoplay="segundos" (3 a 30). Apagado por defecto.
  let playing = false;
  let timer = 0;
  let userPaused = false;
  let hovering = false;
  let visible = true;
  const seconds = Number(track.dataset.autoplay || 0);
  let toggle = null;
  function stop(byUser = false) {
    clearInterval(timer);
    timer = 0;
    playing = false;
    live.setAttribute('aria-live', 'polite');
    if (byUser && toggle) { userPaused = true; syncToggle(); }
  }
  function start() {
    if (!seconds || userPaused || hovering || !visible || document.hidden || reduced.matches || timer) return;
    playing = true;
    live.setAttribute('aria-live', 'off');
    timer = setInterval(() => {
      announce = false;
      const target = index + 1 >= n ? 0 : index + 1;
      preload(target);
      track.scrollTo({ left: offset(target), behavior: behavior() });
    }, seconds * 1000);
  }
  function syncToggle() {
    if (!toggle) return;
    toggle.innerHTML = userPaused ? ICONS.play : ICONS.pause;
    toggle.setAttribute('aria-label', userPaused ? label('Play') : label('Pause'));
  }
  if (seconds >= 3 && !reduced.matches) {
    toggle = button('cg__btn--play', ICONS.pause, label('Pause'));
    toggle.addEventListener('click', () => {
      userPaused = !userPaused;
      syncToggle();
      if (userPaused) stop(); else start();
    });
    frame.append(toggle);
    shell.addEventListener('pointerenter', () => { hovering = true; stop(); });
    shell.addEventListener('pointerleave', () => { hovering = false; start(); });
    shell.addEventListener('focusin', () => { hovering = true; stop(); });
    shell.addEventListener('focusout', (e) => { if (!shell.contains(e.relatedTarget)) { hovering = false; start(); } });
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));
    reduced.addEventListener?.('change', () => { if (reduced.matches) { userPaused = true; syncToggle(); stop(); } });
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; if (visible) start(); else stop(); }, { threshold: 0.5 }).observe(shell);
    } else {
      start();
    }
  }

  shell.classList.add('cg--ready');
  paint();
  return { go: (i) => go(i, true), get index() { return index; }, shell };
}

document.querySelectorAll('.carousel-gallery').forEach((el) => enhance(el));
