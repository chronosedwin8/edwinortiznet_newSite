// Artículo: barra de progreso de lectura, resaltado de la tabla de contenido, reacciones y botones para compartir.
const body = document.querySelector('[data-article-body]');
const bar = document.querySelector('[data-progress]');

if (body && bar) {
  let ticking = false;
  const update = () => {
    const rect = body.getBoundingClientRect();
    const total = rect.height - innerHeight * 0.6;
    const done = Math.min(1, Math.max(0, -rect.top / (total > 0 ? total : 1)));
    bar.style.transform = `scaleX(${done})`;
    ticking = false;
  };
  addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
  update();
}

const tocLinks = [...document.querySelectorAll('.toc a[href^="#"]')];
if (tocLinks.length && 'IntersectionObserver' in window) {
  const byId = new Map(tocLinks.map((a) => [decodeURIComponent(a.hash.slice(1)), a]));
  const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue;
      tocLinks.forEach((a) => a.removeAttribute('aria-current'));
      byId.get(entry.target.id)?.setAttribute('aria-current', 'true');
    }
  }, { rootMargin: '0px 0px -70% 0px' });
  byId.forEach((_, id) => { const h = document.getElementById(id); if (h) io.observe(h); });
}
// En escritorio (columna lateral) la tabla de contenido se abre; en móvil queda cerrada y no mueve el texto.
const toc = document.querySelector('.toc__details');
if (toc && matchMedia('(min-width: 1100px)').matches) toc.open = true;

/* ---------- Reacciones (estilo LinkedIn) ----------
   Toque = "Me gusta" (o quitar la reacción); mantener presionado, pasar el puntero o la flecha = elegir otra.
   La página puede venir de la caché: los conteos y "tu reacción" se piden a la API al cargar. */
const rxRoot = document.querySelector('[data-rx]');
if (rxRoot) initReactions(rxRoot);

function initReactions(root) {
  const api = root.dataset.rxApi;
  const csrf = root.dataset.csrf;
  const trigger = root.querySelector('[data-rx-trigger]');
  const more = root.querySelector('[data-rx-more]');
  const picker = root.querySelector('[data-rx-picker]');
  const opts = [...root.querySelectorAll('[data-rx-opt]')];
  const countBtn = root.querySelector('[data-rx-count]');
  const none = root.querySelector('[data-rx-none]');
  const breakdown = root.querySelector('[data-rx-breakdown]');
  const status = root.querySelector('[data-rx-status]');
  const summaries = [...document.querySelectorAll('[data-rx-summary]')];
  if (!api || !trigger || !picker) return;
  const types = opts.map((o) => o.dataset.rxOpt);
  const emoji = Object.fromEntries(opts.map((o) => [o.dataset.rxOpt, o.querySelector('.rx__opt-emoji').textContent.trim()]));
  const label = Object.fromEntries(opts.map((o) => [o.dataset.rxOpt, o.dataset.label]));
  const nf = new Intl.NumberFormat(document.documentElement.lang || 'es');
  const canHover = matchMedia('(hover: hover) and (pointer: fine)').matches;
  let state = null;
  let busy = false;
  let pressTimer = 0;
  let hoverTimer = 0;
  let suppressClick = false;

  root.classList.add('rx--js');

  const topOf = (counts) => types.filter((t) => counts[t] > 0)
    .sort((a, b) => counts[b] - counts[a] || types.indexOf(a) - types.indexOf(b)).slice(0, 3);
  const stack = (el, top) => el && el.replaceChildren(...top.map((t) => Object.assign(document.createElement('span'), { textContent: emoji[t] })));
  const say = (text) => { if (status) { status.textContent = ''; setTimeout(() => { status.textContent = text; }, 30); } };

  function toggleBreakdown(show) {
    if (!breakdown || !countBtn) return;
    breakdown.hidden = !show;
    countBtn.setAttribute('aria-expanded', String(show));
  }

  function render() {
    if (!state) return;
    const { mine, total, counts } = state;
    const shown = mine || 'like';
    trigger.querySelector('[data-rx-trigger-emoji]').textContent = emoji[shown];
    trigger.querySelector('[data-rx-trigger-label]').textContent = label[shown];
    trigger.setAttribute('aria-pressed', String(Boolean(mine)));
    trigger.dataset.reaction = mine || '';
    trigger.title = mine ? root.dataset.labelRemove : '';
    opts.forEach((o) => o.setAttribute('aria-pressed', String(o.dataset.rxOpt === mine)));
    const text = total === 1 ? root.dataset.labelTotalOne : root.dataset.labelTotal.replace(':n', nf.format(total));
    if (countBtn) {
      countBtn.hidden = total === 0;
      countBtn.querySelector('[data-rx-total]').textContent = text;
      stack(countBtn.querySelector('[data-rx-stack]'), state.top);
    }
    if (none) none.hidden = total > 0;
    breakdown?.querySelectorAll('[data-rx-row]').forEach((row) => {
      const n = counts[row.dataset.rxRow] || 0;
      row.hidden = n === 0;
      row.querySelector('[data-rx-n]').textContent = nf.format(n);
    });
    if (total === 0) toggleBreakdown(false);
    summaries.forEach((s) => {
      s.hidden = total === 0;
      const short = s.querySelector('[data-rx-total-short]');
      if (short) short.textContent = nf.format(total);
      stack(s.querySelector('[data-rx-stack]'), state.top);
    });
  }

  async function load() {
    try {
      const res = await fetch(api, { headers: { Accept: 'application/json' }, credentials: 'same-origin' });
      if (res.ok) { state = await res.json(); render(); }
    } catch { /* sin red: se quedan los conteos impresos */ }
  }

  async function send(reaction) {
    if (busy || !state) return;
    busy = true;
    const prev = { ...state, counts: { ...state.counts } };
    // Optimista: la interfaz responde de inmediato y se corrige con la respuesta del servidor.
    const counts = { ...state.counts };
    if (state.mine) counts[state.mine] = Math.max(0, (counts[state.mine] || 0) - 1);
    if (reaction) counts[reaction] = (counts[reaction] || 0) + 1;
    state = { ...state, mine: reaction, counts, total: Object.values(counts).reduce((a, b) => a + b, 0), top: topOf(counts) };
    render();
    if (reaction) {
      trigger.classList.remove('is-popping');
      void trigger.offsetWidth;
      trigger.classList.add('is-popping');
    }
    try {
      const res = await fetch(api, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-Token': csrf },
        body: JSON.stringify({ reaction }),
      });
      if (!res.ok) throw new Error(String(res.status));
      state = await res.json();
      render();
      say(reaction ? root.dataset.labelSaved.replace(':r', label[reaction]) : root.dataset.labelRemoved);
      window.gtag?.('event', 'reaction', { reaction: reaction || 'none', content_type: 'article' });
    } catch {
      state = prev;
      render();
      say(root.dataset.labelError);
    } finally {
      busy = false;
    }
  }

  /* Selector de reacciones */
  const isOpen = () => picker.classList.contains('is-open');
  function openPicker(focus = false) {
    clearTimeout(hoverTimer);
    picker.classList.add('is-open');
    more?.setAttribute('aria-expanded', 'true');
    if (focus) (opts.find((o) => o.dataset.rxOpt === state?.mine) || opts[0]).focus();
  }
  function closePicker(focusTrigger = false) {
    clearTimeout(hoverTimer);
    if (!isOpen()) return;
    picker.classList.remove('is-open');
    more?.setAttribute('aria-expanded', 'false');
    if (focusTrigger) trigger.focus();
  }

  trigger.addEventListener('click', (e) => {
    e.preventDefault();
    if (suppressClick) { suppressClick = false; return; }
    closePicker();
    send(state?.mine ? null : 'like');
  });
  // Mantener presionado (táctil): abre el selector sin enviar "Me gusta".
  trigger.addEventListener('pointerdown', (e) => {
    if (e.pointerType === 'mouse') return;
    const x = e.clientX;
    const y = e.clientY;
    clearTimeout(pressTimer);
    pressTimer = setTimeout(() => { suppressClick = true; openPicker(); navigator.vibrate?.(10); }, 420);
    const cancel = (ev) => {
      if (ev.type === 'pointermove' && Math.hypot(ev.clientX - x, ev.clientY - y) < 10) return;
      clearTimeout(pressTimer);
      trigger.removeEventListener('pointermove', cancel);
    };
    trigger.addEventListener('pointermove', cancel, { passive: true });
    trigger.addEventListener('pointerup', cancel, { once: true });
    trigger.addEventListener('pointercancel', cancel, { once: true });
  });
  trigger.addEventListener('contextmenu', (e) => { if (suppressClick || isOpen()) e.preventDefault(); });
  // Puntero fino: pasar por encima abre el selector y salir lo cierra.
  if (canHover) {
    const wrap = trigger.parentElement;
    wrap.addEventListener('mouseenter', () => { clearTimeout(hoverTimer); hoverTimer = setTimeout(() => openPicker(), 450); });
    wrap.addEventListener('mouseleave', () => { clearTimeout(hoverTimer); hoverTimer = setTimeout(() => closePicker(), 300); });
  }
  more?.addEventListener('click', () => (isOpen() ? closePicker(true) : openPicker(true)));
  picker.addEventListener('click', (e) => {
    const opt = e.target.closest('[data-rx-opt]');
    if (!opt) return;
    e.preventDefault();
    const type = opt.dataset.rxOpt;
    closePicker(true);
    send(state?.mine === type ? null : type);
  });
  picker.addEventListener('keydown', (e) => {
    const i = opts.indexOf(document.activeElement);
    if (e.key === 'Escape') { e.preventDefault(); closePicker(true); return; }
    const map = { ArrowRight: i + 1, ArrowDown: i + 1, ArrowLeft: i - 1, ArrowUp: i - 1, Home: 0, End: opts.length - 1 };
    if (i < 0 || !(e.key in map)) return;
    e.preventDefault();
    opts[(map[e.key] + opts.length) % opts.length].focus();
  });
  root.addEventListener('focusout', (e) => { if (e.relatedTarget && !root.contains(e.relatedTarget)) { closePicker(); toggleBreakdown(false); } });
  document.addEventListener('pointerdown', (e) => { if (!root.contains(e.target)) { closePicker(); toggleBreakdown(false); } });
  root.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && breakdown && !breakdown.hidden) { toggleBreakdown(false); countBtn?.focus(); }
  });

  /* Detalle por reacción (toque, o puntero encima) */
  countBtn?.addEventListener('click', () => toggleBreakdown(breakdown.hidden));
  if (canHover && countBtn) {
    const wrap = countBtn.parentElement;
    let t = 0;
    wrap.addEventListener('mouseenter', () => { clearTimeout(t); if (state?.total) toggleBreakdown(true); });
    wrap.addEventListener('mouseleave', () => { clearTimeout(t); t = setTimeout(() => toggleBreakdown(false), 200); });
  }

  // Los conteos se piden cuando la barra (o el resumen junto al título) está por verse.
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      if (entries.some((en) => en.isIntersecting)) { io.disconnect(); load(); }
    }, { rootMargin: '600px 0px' });
    io.observe(root);
    summaries.forEach((s) => io.observe(s.closest('.article__meta') || s));
  } else {
    load();
  }
}

/* ---------- Compartir ---------- */
const shareRoot = document.querySelector('.share');
if (shareRoot) initShare(shareRoot);

function initShare(root) {
  const status = root.querySelector('[data-share-status]');
  const nativeBtn = root.querySelector('[data-share-native]');
  const coarse = matchMedia('(pointer: coarse)').matches;
  const track = (method) => window.gtag?.('event', 'share', { method, content_type: 'article', item_id: location.pathname });
  const nativeShare = async (btn) => {
    try {
      await navigator.share({ title: btn.dataset.title, url: btn.dataset.url });
      track('native');
    } catch { /* cancelado por el usuario */ }
  };

  if (nativeBtn && typeof navigator.share === 'function') {
    nativeBtn.closest('[data-share-native-item]').hidden = false;
    // En el celular el menú nativo del sistema es lo más cómodo: va primero y destacado.
    if (coarse) root.classList.add('share--native');
    nativeBtn.addEventListener('click', () => nativeShare(nativeBtn));
    // "Compartir" junto al título: en el celular abre el menú nativo; si no, baja a los botones.
    document.querySelectorAll('[data-share-jump]').forEach((a) => a.addEventListener('click', (e) => {
      if (!coarse) return;
      e.preventDefault();
      nativeShare(nativeBtn);
    }));
  }

  root.addEventListener('click', (e) => {
    const link = e.target.closest('a[data-share-net]');
    if (!link) return;
    const net = link.dataset.shareNet;
    track(net);
    // En escritorio, las redes se abren en una ventana pequeña; en el celular, la app de cada red se encarga.
    if (!coarse && ['linkedin', 'facebook', 'x', 'telegram'].includes(net)) {
      e.preventDefault();
      const w = 620;
      const h = 640;
      window.open(link.href, `share-${net}`, `width=${w},height=${h},left=${Math.max(0, (screen.width - w) / 2)},top=${Math.max(0, (screen.height - h) / 3)},noopener`);
    }
  });

  const copyBtn = root.querySelector('[data-share-copy]');
  let copyTimer = 0;
  copyBtn?.addEventListener('click', async () => {
    const url = copyBtn.dataset.url;
    let ok = false;
    try {
      await navigator.clipboard.writeText(url);
      ok = true;
    } catch {
      const input = Object.assign(document.createElement('textarea'), { value: url });
      input.setAttribute('readonly', '');
      input.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
      document.body.append(input);
      input.select();
      try { ok = document.execCommand('copy'); } catch { ok = false; }
      input.remove();
    }
    const labelEl = copyBtn.querySelector('[data-share-copy-label]');
    copyBtn.classList.toggle('is-done', ok);
    if (labelEl) labelEl.textContent = ok ? copyBtn.dataset.labelDone : copyBtn.dataset.label;
    if (status) status.textContent = ok ? copyBtn.dataset.labelDone : copyBtn.dataset.labelError;
    if (ok) track('copy');
    clearTimeout(copyTimer);
    copyTimer = setTimeout(() => {
      copyBtn.classList.remove('is-done');
      if (labelEl) labelEl.textContent = copyBtn.dataset.label;
      if (status) status.textContent = '';
    }, 2600);
  });
}
