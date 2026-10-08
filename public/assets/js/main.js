// edwinortiz.net — JavaScript común (módulo ES, sin dependencias).
// Mejora progresiva: el sitio funciona sin JS salvo el buscador instantáneo y las herramientas.

const doc = document.documentElement;
const locale = doc.dataset.locale === 'en' ? 'en' : 'es';
const store = {
  get(key, fallback = null) { try { const v = localStorage.getItem(key); return v === null ? fallback : v; } catch { return fallback; } },
  set(key, value) { try { localStorage.setItem(key, value); } catch { /* modo privado */ } },
  json(key, fallback) { try { return JSON.parse(this.get(key, '')) ?? fallback; } catch { return fallback; } },
};
const $ = (sel, root = document) => root.querySelector(sel);
const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ---------- Tema claro/oscuro (recuerda la elección) ---------- */
function initTheme() {
  const btn = $('[data-theme-toggle]');
  if (!btn) return;
  btn.addEventListener('click', () => {
    const current = doc.dataset.theme || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    const next = current === 'dark' ? 'light' : 'dark';
    doc.dataset.theme = next;
    store.set('eo-theme', next);
  });
}

/* ---------- Franja "This page is available in English" ---------- */
function initLangBanner() {
  const banner = $('[data-lang-banner]');
  if (!banner || store.get('eo-lang-banner') === 'closed') return;
  const prefs = (navigator.languages || [navigator.language || '']).map((l) => l.toLowerCase().slice(0, 2));
  const other = locale === 'es' ? 'en' : 'es';
  const firstKnown = prefs.find((l) => l === 'es' || l === 'en');
  if (firstKnown !== other) return;
  banner.hidden = false;
  $('[data-lang-banner-close]', banner)?.addEventListener('click', () => {
    banner.hidden = true;
    store.set('eo-lang-banner', 'closed');
  });
}

/* ---------- Aparición al hacer scroll ---------- */
function initReveal() {
  const items = $$('.reveal');
  if (!items.length) return;
  if (reducedMotion || !('IntersectionObserver' in window)) {
    items.forEach((el) => el.classList.add('is-in'));
    return;
  }
  const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      }
    }
  }, { rootMargin: '0px 0px -8% 0px' });
  items.forEach((el) => io.observe(el));
}

/* ---------- YouTube lite: el iframe se crea al hacer clic ---------- */
function initLiteYoutube() {
  document.addEventListener('click', (event) => {
    const link = event.target.closest('.lite-yt__link');
    if (!link) return;
    event.preventDefault();
    const id = link.dataset.yt;
    const figure = link.closest('.lite-yt');
    if (!id || !figure) return;
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(id)}?autoplay=1&rel=0`;
    iframe.title = link.querySelector('img')?.alt || 'YouTube';
    iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen';
    iframe.allowFullscreen = true;
    figure.replaceChildren(iframe);
    iframe.focus();
  });
}

/* ---------- Moneda de referencia (solo español; el cobro siempre es en COP) ---------- */
const fmt = {
  COP: new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }),
  USDes: new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'USD', currencyDisplay: 'symbol', maximumFractionDigits: 2, minimumFractionDigits: 0 }),
  USD: new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 2, minimumFractionDigits: 0 }),
};
function formatPrice(item) {
  return locale === 'en' ? fmt.USD.format(item.usd) : fmt.COP.format(item.cop);
}
function initCurrency() {
  if (locale !== 'es') return;
  const prices = $$('[data-price]');
  if (!prices.length) return;
  const apply = (mode) => {
    for (const p of prices) {
      const main = $('[data-price-main]', p);
      const ref = $('[data-price-ref]', p);
      if (!main || !ref) continue;
      if (!p.dataset.copLabel) { p.dataset.copLabel = main.textContent; p.dataset.usdLabel = ref.textContent; }
      if (mode === 'USD') {
        main.textContent = fmt.USDes.format(Number(p.dataset.usd)).replace('US$', 'US$ ');
        ref.textContent = (document.body.dataset.labelCharged || '') + ' ' + p.dataset.copLabel;
      } else {
        main.textContent = p.dataset.copLabel;
        ref.textContent = p.dataset.usdLabel;
      }
    }
  };
  const toggle = document.createElement('div');
  toggle.className = 'currency-toggle';
  toggle.setAttribute('role', 'group');
  toggle.setAttribute('aria-label', document.body.dataset.labelCurrency || 'COP / USD');
  toggle.innerHTML = '<button type="button" data-cur="COP">COP</button><button type="button" data-cur="USD">USD</button>';
  const mode = store.get('eo-currency', 'COP');
  const update = (m) => {
    $$('button', toggle).forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.cur === m)));
    apply(m);
  };
  toggle.addEventListener('click', (e) => {
    const b = e.target.closest('button[data-cur]');
    if (!b) return;
    store.set('eo-currency', b.dataset.cur);
    update(b.dataset.cur);
  });
  const actions = $('.header-actions');
  actions?.prepend(toggle);
  update(mode === 'USD' ? 'USD' : 'COP');
}

/* ---------- Carrito (localStorage, validado en servidor al pagar) ---------- */
const CART_KEY = `eo-cart-${locale}`;
// Cada línea es "id" o "id:variante" (p. ej. la materia del kit): dos variantes = dos líneas.
const lineKey = (i) => (i.variant ? `${Number(i.id)}:${i.variant}` : String(Number(i.id)));
const cart = {
  key: lineKey,
  items() { return store.json(CART_KEY, []).filter((i) => i && Number(i.id) > 0); },
  save(items) {
    store.set(CART_KEY, JSON.stringify(items));
    document.cookie = items.length ? 'eo_cart=1; Path=/; SameSite=Lax; Max-Age=2592000' : 'eo_cart=; Path=/; Max-Age=0';
    renderCart();
  },
  add(item) {
    const items = this.items().filter((i) => lineKey(i) !== lineKey(item));
    items.push(item);
    this.save(items);
  },
  remove(key) { this.save(this.items().filter((i) => lineKey(i) !== String(key))); },
  checkoutUrl(base) {
    const ids = this.items().map(lineKey).join(',');
    return ids ? `${base}?items=${encodeURIComponent(ids)}` : base;
  },
};
window.eoCart = cart;

function renderCart() {
  const drawer = $('[data-cart-drawer]');
  const items = cart.items();
  $$('[data-cart-count]').forEach((el) => { el.textContent = String(items.length); el.hidden = items.length === 0; });
  if (!drawer) return;
  const list = $('[data-cart-items]', drawer);
  const tpl = $('#tpl-cart-item');
  list.replaceChildren();
  let total = 0;
  for (const item of items) {
    const node = tpl.content.firstElementChild.cloneNode(true);
    const img = $('.cart-item__img', node);
    if (item.img) img.src = item.img; else img.remove();
    const a = $('.cart-item__title', node);
    a.href = item.url; a.textContent = item.title;
    $('.cart-item__price', node).textContent = formatPrice(item);
    $('.cart-item__remove', node).addEventListener('click', () => cart.remove(lineKey(item)));
    list.append(node);
    total += locale === 'en' ? Number(item.usd) : Number(item.cop);
  }
  $('[data-cart-empty]', drawer).hidden = items.length > 0;
  $('[data-cart-foot]', drawer).hidden = items.length === 0;
  $('[data-cart-total]', drawer).textContent = locale === 'en' ? fmt.USD.format(total) : fmt.COP.format(total);
  const checkoutLink = $('[data-cart-foot] a', drawer);
  if (checkoutLink) checkoutLink.href = cart.checkoutUrl(drawer.dataset.checkout);
  document.dispatchEvent(new CustomEvent('eo:cart', { detail: items }));
}

function initCart() {
  const drawer = $('[data-cart-drawer]');
  if (!drawer) return;
  let lastFocus = null;
  const open = () => {
    lastFocus = document.activeElement;
    drawer.hidden = false;
    document.body.style.overflow = 'hidden';
    $('[data-cart-close].btn-icon', drawer)?.focus();
  };
  const close = () => {
    drawer.hidden = true;
    document.body.style.overflow = '';
    lastFocus?.focus?.();
  };
  document.addEventListener('click', (e) => {
    const add = e.target.closest('[data-add-to-cart]');
    if (add) {
      e.preventDefault();
      // Producto con variantes (p. ej. materia): sin elegir una, product.js muestra el aviso y no se agrega.
      if (add.dataset.requiresVariant && !add.dataset.variant) {
        add.dispatchEvent(new CustomEvent('eo:variant-missing', { bubbles: true }));
        return;
      }
      cart.add({
        id: Number(add.dataset.addToCart), title: add.dataset.title + (add.dataset.variantLabel ? ` — ${add.dataset.variantLabel}` : ''),
        url: add.dataset.url, img: add.dataset.img,
        cop: Number(add.dataset.priceCop), usd: Number(add.dataset.priceUsd),
        ...(add.dataset.variant ? { variant: add.dataset.variant } : {}),
      });
      open();
      return;
    }
    if (e.target.closest('[data-cart-open]')) { e.preventDefault(); open(); return; }
    if (e.target.closest('[data-cart-close]')) close();
  });
  drawer.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
    if (e.key === 'Tab') {
      const focusables = $$('a[href], button:not([disabled])', drawer).filter((el) => el.offsetParent !== null);
      if (!focusables.length) return;
      const first = focusables[0];
      const last = focusables[focusables.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  });
  window.addEventListener('storage', (e) => { if (e.key === CART_KEY) renderCart(); });
  renderCart();
}

/* ---------- Buscador instantáneo (espera 200 ms, teclado, atajo "/") ---------- */
function initSearch() {
  const dialog = $('[data-search-dialog]');
  if (!dialog || typeof dialog.showModal !== 'function') return;
  const input = $('[data-search-input]', dialog);
  const results = $('[data-search-results]', dialog);
  let timer = 0;
  let controller = null;
  let active = -1;

  const open = () => { dialog.showModal(); input.focus(); input.select(); };
  const options = () => $$('.search-result', results);
  const highlight = (index) => {
    const opts = options();
    opts.forEach((o, i) => o.setAttribute('aria-selected', String(i === index)));
    active = index;
    if (opts[index]) {
      input.setAttribute('aria-activedescendant', opts[index].id);
      opts[index].scrollIntoView({ block: 'nearest' });
    }
  };
  const render = (data) => {
    results.replaceChildren();
    active = -1;
    const groups = [['products', results.dataset.labelProducts], ['posts', results.dataset.labelPosts]];
    let n = 0;
    for (const [key, label] of groups) {
      if (!data[key]?.length) continue;
      const h = document.createElement('h3');
      h.textContent = label;
      results.append(h);
      for (const item of data[key]) {
        const a = document.createElement('a');
        a.className = 'search-result';
        a.href = item.url;
        a.id = `sr-${n++}`;
        a.setAttribute('role', 'option');
        a.append(document.createTextNode(item.title));
        const small = document.createElement('small');
        small.textContent = item.meta || '';
        a.append(small);
        results.append(a);
      }
    }
    if (n === 0) {
      const p = document.createElement('p');
      p.className = 'search-dialog__empty';
      p.textContent = results.dataset.labelEmpty;
      results.append(p);
    } else {
      const all = document.createElement('a');
      all.className = 'search-result';
      all.href = data.all;
      all.id = `sr-${n}`;
      all.setAttribute('role', 'option');
      all.textContent = results.dataset.labelAll;
      results.append(all);
    }
    input.setAttribute('aria-expanded', 'true');
  };
  const query = async (q) => {
    controller?.abort();
    if (q.trim().length < 2) { results.replaceChildren(); input.setAttribute('aria-expanded', 'false'); return; }
    controller = new AbortController();
    try {
      const res = await fetch(`/api/buscar?q=${encodeURIComponent(q)}&lang=${locale}`, { signal: controller.signal, headers: { Accept: 'application/json' } });
      if (res.ok) render(await res.json());
    } catch { /* abortado o sin red */ }
  };
  input.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(() => query(input.value), 200); });
  input.addEventListener('keydown', (e) => {
    const opts = options();
    if (e.key === 'ArrowDown') { e.preventDefault(); highlight(Math.min(active + 1, opts.length - 1)); }
    else if (e.key === 'ArrowUp') { e.preventDefault(); highlight(Math.max(active - 1, 0)); }
    else if (e.key === 'Enter' && active >= 0 && opts[active]) { e.preventDefault(); location.href = opts[active].href; }
  });
  $('[data-search-close]', dialog)?.addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
  document.addEventListener('click', (e) => {
    if (e.target.closest('[data-search-open]')) { e.preventDefault(); open(); }
  });
  document.addEventListener('keydown', (e) => {
    const tag = (e.target.tagName || '').toLowerCase();
    const typing = tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable;
    if (e.key === '/' && !typing && !dialog.open) { e.preventDefault(); open(); }
  });
}

/* ---------- Formularios asíncronos (suscripción, lista de espera) ---------- */
/* Suscripción: referencia externa (solo sitio y ruta) y UTM de la URL, para saber de dónde llegó cada persona. */
function fillSubscribeContext(form) {
  if (!form.matches('[data-sub-ctx]')) return;
  const set = (name, value) => { const f = form.elements.namedItem(name); if (f && value) f.value = String(value).slice(0, 255); };
  try {
    if (document.referrer) {
      const ref = new URL(document.referrer);
      if (ref.host !== location.host) set('ref', ref.origin + ref.pathname);
    }
    const params = new URLSearchParams(location.search);
    ['utm_source', 'utm_medium', 'utm_campaign'].forEach((k) => set(k, params.get(k) || ''));
  } catch { /* URL no válida */ }
}

function initAsyncForms() {
  document.addEventListener('submit', async (e) => {
    const form = e.target.closest('form[data-async-form]');
    if (!form || !window.fetch) return;
    e.preventDefault();
    fillSubscribeContext(form);
    const status = $('[data-form-status]', form);
    const button = $('button[type="submit"]', form);
    button && (button.disabled = true);
    try {
      const res = await fetch(form.action, {
        method: 'POST', body: new FormData(form), headers: { Accept: 'application/json', 'X-Requested-With': 'fetch' },
      });
      const data = await res.json().catch(() => ({}));
      if (status) {
        status.textContent = data.message || data.error || (res.ok ? '✓' : '×');
        status.dataset.state = res.ok && data.ok !== false ? 'ok' : 'error';
      }
      if (res.ok) form.reset();
      // Cloudflare Turnstile: cada token sirve una vez.
      const widget = $('.cf-turnstile', form);
      if (widget && window.turnstile) { try { window.turnstile.reset(widget); } catch { /* sin widget */ } }
    } catch {
      if (status) { status.textContent = document.body.dataset.labelNetwork || 'Error'; status.dataset.state = 'error'; }
    } finally {
      button && (button.disabled = false);
    }
  });
}

/* ---------- Consentimiento de cookies: GA4 y AdSense diferidos ---------- */
function loadScript(src) {
  const s = document.createElement('script');
  s.src = src; s.async = true;
  document.head.append(s);
  return s;
}
function enableTracking() {
  const body = document.body;
  const ga = body.dataset.ga;
  if (ga && !window.gtag) {
    window.dataLayer = window.dataLayer || [];
    window.gtag = function gtag() { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', ga, { anonymize_ip: true });
    loadScript(`https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(ga)}`);
  }
  const ads = body.dataset.adsense;
  const slots = $$('ins.adsbygoogle');
  if (ads && slots.length) {
    doc.classList.add('consent-ok');
    const s = loadScript(`https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=${encodeURIComponent(ads)}`);
    s.crossOrigin = 'anonymous';
    slots.forEach((slot) => {
      slot.dataset.adClient = ads;
      (window.adsbygoogle = window.adsbygoogle || []).push({});
    });
  }
}
function initConsent() {
  const banner = $('[data-consent]');
  const choice = store.get('eo-consent');
  const run = () => ('requestIdleCallback' in window ? requestIdleCallback(enableTracking, { timeout: 4000 }) : setTimeout(enableTracking, 2500));
  if (choice === 'all') {
    if (document.readyState === 'complete') run(); else addEventListener('load', run, { once: true });
  } else if (choice !== 'necessary' && banner) {
    banner.hidden = false;
  }
  banner?.addEventListener('click', (e) => {
    if (e.target.closest('[data-consent-accept]')) { store.set('eo-consent', 'all'); banner.hidden = true; doc.classList.add('consent-ok'); enableTracking(); }
    if (e.target.closest('[data-consent-reject]')) { store.set('eo-consent', 'necessary'); banner.hidden = true; doc.classList.remove('consent-ok'); }
  });
  document.addEventListener('click', (e) => {
    if (e.target.closest('[data-consent-open]') && banner) banner.hidden = false;
  });
}

/* ---------- Cabecera: sombra al desplazarse ---------- */
function initHeader() {
  const header = $('.site-header');
  if (!header) return;
  const sentinel = document.createElement('div');
  sentinel.setAttribute('aria-hidden', 'true');
  sentinel.style.cssText = 'position:absolute;top:0;left:0;width:1px;height:8px;pointer-events:none';
  document.body.prepend(sentinel);
  if (!('IntersectionObserver' in window)) return;
  new IntersectionObserver(([entry]) => header.classList.toggle('is-scrolled', !entry.isIntersecting)).observe(sentinel);
}

/* ---------- Menú móvil: panel lateral con foco atrapado, Esc y bloqueo del scroll ---------- */
function initMenu() {
  const menu = $('[data-menu]');
  const toggle = $('[data-menu-open]');
  if (!menu || !toggle) return;
  const panel = $('.mobile-menu__panel', menu);
  const outside = () => [$('.site-header'), $('main'), $('.site-footer'), $('.whatsapp-float'), $('[data-lang-banner]')].filter(Boolean);
  let closeTimer = 0;
  const syncTheme = () => {
    const current = doc.dataset.theme || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    $$('[data-theme-set]', menu).forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.themeSet === current)));
  };
  const isOpen = () => !menu.hidden && menu.classList.contains('is-open');
  const open = () => {
    clearTimeout(closeTimer);
    syncTheme();
    menu.hidden = false;
    doc.classList.add('menu-open');
    outside().forEach((el) => { el.inert = true; });
    toggle.setAttribute('aria-expanded', 'true');
    // Un cuadro después, para que la transición arranque desde fuera de la pantalla.
    requestAnimationFrame(() => requestAnimationFrame(() => menu.classList.add('is-open')));
    $('.mobile-menu__close', menu)?.focus({ preventScroll: true });
  };
  const close = (restoreFocus = true) => {
    if (menu.hidden) return;
    menu.classList.remove('is-open');
    doc.classList.remove('menu-open');
    outside().forEach((el) => { el.inert = false; });
    toggle.setAttribute('aria-expanded', 'false');
    if (restoreFocus) toggle.focus({ preventScroll: true });
    clearTimeout(closeTimer);
    closeTimer = setTimeout(() => { if (!menu.classList.contains('is-open')) menu.hidden = true; }, reducedMotion ? 0 : 340);
  };
  toggle.addEventListener('click', () => (isOpen() ? close() : open()));
  menu.addEventListener('click', (e) => {
    if (e.target.closest('[data-menu-close]')) { close(); return; }
    const themeBtn = e.target.closest('[data-theme-set]');
    if (themeBtn) {
      doc.dataset.theme = themeBtn.dataset.themeSet;
      store.set('eo-theme', themeBtn.dataset.themeSet);
      syncTheme();
      return;
    }
    // Al navegar se cierra. Si abre el buscador o el carrito, el foco vuelve antes al botón del menú
    // para que, al cerrarlos, regrese a un elemento visible.
    const link = e.target.closest('a[href]');
    if (link) close(Boolean(link.closest('[data-cart-open], [data-search-open]')));
  });
  menu.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') { e.preventDefault(); close(); return; }
    if (e.key !== 'Tab') return;
    const focusables = $$('a[href], button:not([disabled])', panel).filter((el) => el.offsetParent !== null);
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  });
  // Al pasar a escritorio (o volver con el botón Atrás desde la caché del navegador) el panel no queda abierto.
  matchMedia('(min-width: 1000px)').addEventListener('change', (e) => { if (e.matches) close(false); });
  addEventListener('pageshow', (e) => { if (e.persisted) close(false); });
}

/* ---------- Foco de luz que sigue al puntero ---------- */
function initSpotlight() {
  if (reducedMotion || !matchMedia('(hover: hover)').matches) return;
  document.addEventListener('pointermove', (e) => {
    const card = e.target.closest?.('[data-spotlight]');
    if (!card) return;
    const r = card.getBoundingClientRect();
    card.style.setProperty('--mx', `${e.clientX - r.left}px`);
    card.style.setProperty('--my', `${e.clientY - r.top}px`);
  }, { passive: true });
}

/* ---------- Contadores animados ---------- */
function initCounters() {
  const items = $$('[data-count]');
  if (!items.length || reducedMotion || !('IntersectionObserver' in window)) return;
  const nf = new Intl.NumberFormat(locale === 'es' ? 'es-CO' : 'en-US');
  const run = (el) => {
    const target = Number(el.dataset.count) || 0;
    const start = performance.now();
    const duration = 1400;
    const step = (now) => {
      const p = Math.min((now - start) / duration, 1);
      el.textContent = nf.format(Math.round(target * (1 - (1 - p) ** 3)));
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };
  const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue;
      io.unobserve(entry.target);
      run(entry.target);
    }
  }, { threshold: .6 });
  items.forEach((el) => io.observe(el));
}

/* ---------- Carrusel con botones anterior/siguiente ---------- */
function initCarousels() {
  for (const track of $$('[data-carousel]')) {
    const name = track.dataset.carousel;
    const prev = $(`[data-carousel-prev="${name}"]`);
    const next = $(`[data-carousel-next="${name}"]`);
    const page = () => Math.max(track.clientWidth * .85, 260);
    const sync = () => {
      const max = track.scrollWidth - track.clientWidth - 4;
      if (prev) prev.disabled = track.scrollLeft <= 4;
      if (next) next.disabled = track.scrollLeft >= max;
    };
    const behavior = reducedMotion ? 'auto' : 'smooth';
    prev?.addEventListener('click', () => track.scrollBy({ left: -page(), behavior }));
    next?.addEventListener('click', () => track.scrollBy({ left: page(), behavior }));
    track.addEventListener('scroll', () => requestAnimationFrame(sync), { passive: true });
    addEventListener('resize', sync, { passive: true });
    sync();
  }
}

/* ---------- Pestañas accesibles (flechas, Inicio, Fin) ---------- */
function initTabs() {
  for (const root of $$('[data-tabs-hubs]')) {
    const tabs = $$('[role="tab"]', root);
    const select = (tab, focus = false) => {
      for (const t of tabs) {
        const on = t === tab;
        t.setAttribute('aria-selected', String(on));
        t.tabIndex = on ? 0 : -1;
        const panel = document.getElementById(t.getAttribute('aria-controls'));
        if (panel) panel.toggleAttribute('data-inactive', !on);
      }
      if (focus) tab.focus();
    };
    root.addEventListener('click', (e) => {
      const tab = e.target.closest('[role="tab"]');
      if (tab) select(tab);
    });
    root.addEventListener('keydown', (e) => {
      const i = tabs.indexOf(document.activeElement);
      if (i < 0) return;
      const map = { ArrowRight: i + 1, ArrowLeft: i - 1, Home: 0, End: tabs.length - 1 };
      if (!(e.key in map)) return;
      e.preventDefault();
      select(tabs[(map[e.key] + tabs.length) % tabs.length], true);
    });
  }
}

/* ---------- Hoja de cálculo animada del encabezado ---------- */
function initSheet() {
  const sheet = $('[data-sheet]');
  if (!sheet) return;
  const cells = $$('[data-sheet-status]', sheet);
  const running = cells[0]?.textContent || '';
  const done = sheet.dataset.done || '✓';
  const paint = (n) => cells.forEach((c, i) => {
    const ok = i < n;
    c.textContent = ok ? done : running;
    c.classList.toggle('sheet__ok', ok);
    c.classList.toggle('sheet__run', !ok);
  });
  if (reducedMotion) { paint(cells.length); return; }
  let n = 0;
  const tick = () => {
    n = n > cells.length ? 0 : n + 1;
    paint(n);
    setTimeout(tick, n > cells.length - 1 ? 2400 : 900);
  };
  setTimeout(tick, 1200);
}

// Lo visible primero; el resto cuando el hilo principal esté libre.
initTheme();
initHeader();
initMenu();
initReveal();
initSheet();
initTabs();
initLiteYoutube();
initAsyncForms();
// Cada inicialización en su propia tarea corta para no bloquear la interacción.
const idle = window.requestIdleCallback ? (fn) => requestIdleCallback(fn, { timeout: 2000 }) : (fn) => setTimeout(fn, 50);
[initCounters, initCarousels, initSpotlight, initCurrency, initCart, initLangBanner, initSearch, initConsent].forEach((fn) => idle(fn));
