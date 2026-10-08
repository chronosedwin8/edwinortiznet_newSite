// Panel de edwinortiz.net — un solo módulo sin dependencias.
// (Los recursos se versionan con ?v= y se guardan en caché un año, por eso no hay imports entre archivos.)

const doc = document.documentElement;
const body = document.body;
const $ = (sel, root = document) => root.querySelector(sel);
const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
const CSRF = body.dataset.csrf || '';
const ICONS = body.dataset.icons || '/assets/img/icons.svg';
const icon = (name) => `<svg class="icon" aria-hidden="true" focusable="false"><use href="${ICONS}#${name}"></use></svg>`;
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
const debounce = (fn, ms) => { let t = 0; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; };
const store = {
  get(k) { try { return localStorage.getItem(k); } catch { return null; } },
  set(k, v) { try { localStorage.setItem(k, v); } catch { /* modo privado */ } },
  del(k) { try { localStorage.removeItem(k); } catch { /* modo privado */ } },
};
const fold = (s) => String(s || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');
const slugify = (s) => fold(s).replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 190);

// Textos del panel (solo español).
const T = {
  saved: 'Guardado', copied: 'Copiado', uploadError: 'No se pudo subir la imagen.', uploading: 'Subiendo…', network: 'Sin conexión con el servidor.',
  paragraph: 'Párrafo', h2: 'Título 2', h3: 'Título 3', h4: 'Título 4', pre: 'Código',
  bold: 'Negrita (Ctrl+B)', italic: 'Cursiva (Ctrl+I)', link: 'Enlace (Ctrl+K)', unlink: 'Quitar enlace', ul: 'Lista', ol: 'Lista numerada', quote: 'Cita',
  image: 'Imagen', video: 'Video de YouTube', table: 'Tabla', hr: 'Separador', notice: 'Recuadro de aviso', marker: 'Productos o artículos relacionados',
  undo: 'Deshacer', redo: 'Rehacer', source: 'Ver HTML', visual: 'Volver al editor', full: 'Pantalla completa',
  words: 'palabras', minutes: 'min de lectura', headings: 'subtítulos', links: 'enlaces', images: 'imágenes',
  placeholder: 'Empieza a escribir… Pega desde Word o Google Docs: el formato se limpia solo.',
  insertImage: 'Insertar imagen', library: 'Biblioteca', upload: 'Subir', fromUrl: 'Desde URL', search: 'Buscar imágenes…', more: 'Cargar más',
  drop: 'Arrastra imágenes aquí o', choose: 'elige archivos', dropHint: 'JPG, PNG, WebP o GIF hasta 12 MB. Se convierten a WebP (1600 y 800 px).',
  alt: 'Texto alternativo (describe la imagen)', caption: 'Pie de foto (opcional)', insert: 'Insertar', cancel: 'Cancelar', close: 'Cerrar', remove: 'Quitar',
  url: 'URL', linkTitle: 'Enlace', linkText: 'Texto del enlace', newTab: 'Abrir en una pestaña nueva', linkSearch: 'Escribe una URL o busca un artículo o producto',
  videoTitle: 'Video de YouTube', videoUrl: 'Enlace del video', videoBad: 'No reconozco ese enlace de YouTube.',
  markerTitle: 'Bloque dinámico', featured: 'Productos más vendidos', product: 'Un producto', hub: 'Últimos artículos de una sección', blog: 'Últimos artículos del blog',
  editImage: 'Editar imagen', emptyLib: 'Todavía no hay imágenes. Sube la primera.',
  draftFound: 'Hay cambios sin guardar de una sesión anterior.', restore: 'Recuperar', discard: 'Descartar',
  pick: 'Elegir imagen', noImage: 'Sin imagen', question: 'Pregunta', answer: 'Respuesta', addFaq: 'Agregar pregunta', up: 'Subir', down: 'Bajar',
  cmdNo: 'Sin resultados', ok: 'Aceptar',
  carousel: 'Carrusel de imágenes', carouselEdit: 'Editar carrusel', carouselRemove: 'Quitar', carouselRemoveQ: '¿Quitar este carrusel del contenido? Las imágenes siguen en la biblioteca.',
  carouselImages: ':n imágenes', carouselHint: 'Ordena las imágenes (arrastra o usa las flechas) y escribe el texto alternativo de cada una. El pie de foto es opcional.',
  carouselEmpty: 'Todavía no hay imágenes. Agrega al menos dos.', carouselMin: 'El carrusel necesita al menos dos imágenes.', addImages: 'Agregar imágenes',
  selectImages: 'Elegir imágenes para el carrusel', add: 'Agregar', addN: 'Agregar (:n)', insertCarousel: 'Insertar carrusel', saveCarousel: 'Guardar carrusel',
  autoplay: 'Avance automático', autoplayOff: 'Desactivado (recomendado)', autoplayEvery: 'Cada :n segundos', imageN: 'Imagen :n',
  seo: {
    title: 'Título SEO entre 50 y 60 caracteres', desc: 'Meta descripción entre 120 y 160 caracteres', kwTitle: 'Palabra clave en el título SEO',
    kwDesc: 'Palabra clave en la meta descripción', kwFirst: 'Palabra clave en el primer párrafo', kwH2: 'Palabra clave en algún H2',
    kwSlug: 'Palabra clave en la URL', words: 'Al menos 600 palabras', alt: 'Todas las imágenes con texto alternativo', internal: 'Dos o más enlaces internos',
    external: 'Al menos un enlace externo', h2: 'Dos o más subtítulos H2', cover: 'Imagen destacada', noKw: 'Define una palabra clave principal',
  },
};

/* ======================================================================
   Avisos, tema, barra lateral
   ====================================================================== */
function dismiss(el, ms = 5000) {
  setTimeout(() => {
    el.classList.add('is-out');
    setTimeout(() => el.remove(), 400);
  }, ms);
}
function toast(message, error = false) {
  const box = $('[data-toasts]');
  if (!box) return;
  const p = document.createElement('p');
  p.className = 'toast' + (error ? ' toast--error' : '');
  p.innerHTML = icon(error ? 'notice' : 'check') + '<span></span>';
  p.lastChild.textContent = message;
  box.append(p);
  dismiss(p, error ? 7000 : 3500);
}
$$('[data-toast]').forEach((t) => dismiss(t, t.classList.contains('toast--error') ? 8000 : 4500));

$('[data-theme-toggle]')?.addEventListener('click', () => {
  const current = doc.dataset.theme || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  const next = current === 'dark' ? 'light' : 'dark';
  doc.dataset.theme = next;
  store.set('eo-theme', next);
});

const side = $('#admin-side');
$('[data-side-toggle]')?.addEventListener('click', (e) => {
  const open = !side.classList.contains('is-open');
  side.classList.toggle('is-open', open);
  body.classList.toggle('side-open', open);
  e.currentTarget.setAttribute('aria-expanded', String(open));
});
document.addEventListener('click', (e) => {
  if (body.classList.contains('side-open') && !e.target.closest('#admin-side, [data-side-toggle]')) {
    side.classList.remove('is-open');
    body.classList.remove('side-open');
  }
});

async function api(url, options = {}) {
  const res = await fetch(url, {
    credentials: 'same-origin',
    ...options,
    headers: { Accept: 'application/json', 'X-Requested-With': 'fetch', 'X-CSRF-Token': CSRF, ...(options.headers || {}) },
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok && !data.items) throw new Error(data.message || (data.errors || []).join(' ') || res.statusText);
  return data;
}

/* ======================================================================
   Paleta de comandos (Ctrl+K)
   ====================================================================== */
function initCommandPalette() {
  const dlg = $('[data-cmd]');
  if (!dlg || typeof dlg.showModal !== 'function') return;
  const input = $('[data-cmd-input]', dlg);
  const list = $('[data-cmd-list]', dlg);
  const statics = JSON.parse($('[data-cmd-static]', dlg)?.textContent || '[]');
  const groupLabel = { actions: list.dataset.labelActions, go: list.dataset.labelGo };
  let items = [];
  let active = 0;
  let controller = null;

  const render = (remote = []) => {
    const q = fold(input.value.trim());
    const local = statics.filter((s) => !q || fold(s.title).includes(q)).map((s) => ({ ...s, group: groupLabel[s.group] || s.group }));
    items = [...remote.map((r) => ({ ...r, icon: 'arrow' })), ...local];
    list.replaceChildren();
    if (!items.length) {
      list.innerHTML = `<p class="cmd__empty">${esc(list.dataset.labelEmpty || T.cmdNo)}</p>`;
      return;
    }
    let group = null;
    items.forEach((item, i) => {
      if (item.group !== group) {
        group = item.group;
        const h = document.createElement('p');
        h.className = 'cmd__group';
        h.textContent = group;
        list.append(h);
      }
      const a = document.createElement('a');
      a.className = 'cmd__item';
      a.href = item.url;
      a.id = `cmd-${i}`;
      a.setAttribute('role', 'option');
      if (item.blank) a.target = '_blank';
      a.innerHTML = `${icon(item.icon || 'arrow')}<span>${esc(item.title)}</span>${item.meta ? `<small>${esc(item.meta)}</small>` : ''}`;
      list.append(a);
    });
    select(0);
  };
  const select = (i) => {
    const opts = $$('.cmd__item', list);
    if (!opts.length) return;
    active = (i + opts.length) % opts.length;
    opts.forEach((o, n) => o.setAttribute('aria-selected', String(n === active)));
    input.setAttribute('aria-activedescendant', opts[active].id);
    opts[active].scrollIntoView({ block: 'nearest' });
  };
  const search = debounce(async () => {
    const q = input.value.trim();
    controller?.abort();
    if (q.length < 2) { render(); return; }
    controller = new AbortController();
    try {
      const data = await api(`/admin/buscar/?q=${encodeURIComponent(q)}`, { signal: controller.signal });
      render(data.items || []);
    } catch { /* abortado */ }
  }, 160);

  const open = () => { input.value = ''; render(); dlg.showModal(); input.focus(); };
  input.addEventListener('input', () => { render(); search(); });
  input.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowDown') { e.preventDefault(); select(active + 1); }
    if (e.key === 'ArrowUp') { e.preventDefault(); select(active - 1); }
    if (e.key === 'Enter') {
      e.preventDefault();
      const opt = $$('.cmd__item', list)[active];
      if (opt) { if (opt.target === '_blank') window.open(opt.href, '_blank', 'noopener'); else location.href = opt.href; dlg.close(); }
    }
  });
  dlg.addEventListener('click', (e) => { if (e.target === dlg) dlg.close(); });
  $$('[data-cmd-open]').forEach((b) => b.addEventListener('click', open));
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k' && !e.defaultPrevented) { e.preventDefault(); open(); }
  });
}

/* ======================================================================
   Utilidades de formularios: contadores, pestañas, confirmación, Ctrl+S, cambios sin guardar
   ====================================================================== */
for (const out of $$('output[data-count-for]')) {
  const field = document.getElementById(out.dataset.countFor);
  if (!field) continue;
  const min = Number(out.dataset.min);
  const max = Number(out.dataset.max);
  const update = () => {
    const n = [...field.value].length;
    out.textContent = `${n} / ${min}–${max}`;
    out.dataset.state = n === 0 ? '' : n >= min && n <= max ? 'ok' : 'bad';
  };
  field.addEventListener('input', update);
  update();
}

for (const tabs of $$('[data-tabs]')) {
  tabs.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-tab]');
    if (!btn) return;
    for (const b of $$('[data-tab]', tabs)) {
      const on = b === btn;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-selected', String(on));
      const panel = document.getElementById(b.dataset.tab);
      if (panel) panel.hidden = !on;
    }
  });
}

/* Confirmación accesible (en lugar de window.confirm): <form data-confirm="¿Seguro…?" data-confirm-ok="Eliminar">.
   El foco empieza en "Cancelar"; Esc cancela y el navegador devuelve el foco al botón que abrió el diálogo. */
function confirmDialog(text, okLabel = T.ok) {
  const dlg = document.createElement('dialog');
  dlg.className = 'modal modal--sm';
  const id = `confirm-${Date.now()}`;
  dlg.setAttribute('aria-labelledby', id);
  dlg.innerHTML = `<div class="modal__body"><p class="confirm-text" id="${id}"></p></div>
    <div class="modal__foot"><button type="button" class="btn btn--ghost" data-no>${esc(T.cancel)}</button><button type="button" class="btn btn--danger" data-yes>${icon('trash')}${esc(okLabel)}</button></div>`;
  $(`#${id}`, dlg).textContent = text;
  body.append(dlg);
  return new Promise((resolve) => {
    let ok = false;
    $('[data-no]', dlg).addEventListener('click', () => dlg.close());
    $('[data-yes]', dlg).addEventListener('click', () => { ok = true; dlg.close(); });
    dlg.addEventListener('close', () => { dlg.remove(); resolve(ok); });
    dlg.showModal();
    $('[data-no]', dlg).focus();
  });
}
document.addEventListener('submit', async (e) => {
  const form = e.target.closest('form[data-confirm]');
  if (!form) return;
  if (form.dataset.confirmed === '1') { delete form.dataset.confirmed; return; }
  e.preventDefault();
  const submitter = e.submitter?.form === form ? e.submitter : undefined;
  const ok = typeof HTMLDialogElement === 'function'
    ? await confirmDialog(form.dataset.confirm, form.dataset.confirmOk || T.ok)
    : window.confirm(form.dataset.confirm);
  if (!ok) return;
  form.dataset.confirmed = '1';
  form.requestSubmit(submitter);
});

/* Artículos y páginas: selección múltiple con barra fija y diálogo de borrado (con opciones de traducción y 301).
   Sin JavaScript, los mismos formularios llevan a una página de confirmación en el servidor. */
(function initBulkDelete() {
  const bar = $('[data-bulk-bar]');
  if (bar) {
    const boxes = () => $$('[data-row-check]');
    const all = $('[data-select-all]');
    const count = $('[data-bulk-count]', bar);
    const clear = $('[data-bulk-clear]', bar);
    const update = () => {
      const list = boxes();
      const n = list.filter((b) => b.checked).length;
      bar.hidden = n === 0;
      count.textContent = n === 1 ? count.dataset.one : count.dataset.many.replace(':n', n);
      if (all) {
        all.checked = n > 0 && n === list.length;
        all.indeterminate = n > 0 && n < list.length;
      }
    };
    if (all) {
      all.hidden = false;
      all.disabled = boxes().length === 0;
      all.addEventListener('change', () => { boxes().forEach((b) => { b.checked = all.checked; }); update(); });
    }
    clear.hidden = false;
    clear.addEventListener('click', () => { boxes().forEach((b) => { b.checked = false; }); update(); all?.focus(); });
    let last = null;
    document.addEventListener('click', (e) => {
      const box = e.target.closest('[data-row-check]');
      if (!box) return;
      // Mayús + clic marca o desmarca el rango desde la última casilla.
      if (e.shiftKey && last && last !== box) {
        const list = boxes();
        const [a, b] = [list.indexOf(last), list.indexOf(box)].sort((x, y) => x - y);
        list.slice(a, b + 1).forEach((x) => { x.checked = box.checked; });
      }
      last = box;
      update();
    });
    document.addEventListener('change', (e) => { if (e.target.matches('[data-row-check]')) update(); });
    window.addEventListener('pageshow', update);
    update();
  }

  const dlg = $('[data-delete-dialog]');
  if (!dlg || typeof dlg.showModal !== 'function') return;
  const form = $('form', dlg);
  const heading = $('[data-delete-heading]', dlg);
  const list = $('[data-delete-list]', dlg);
  const ids = $('[data-delete-ids]', dlg);
  const trBox = $('[data-delete-tr]', dlg);
  const trLabel = $('[data-delete-tr-label]', dlg);
  const cancel = $('[data-delete-cancel]', dlg);
  cancel.addEventListener('click', () => dlg.close());
  form.addEventListener('submit', () => { $$('button', form).forEach((b) => { b.disabled = true; }); });
  document.addEventListener('submit', (e) => {
    const src = e.target.closest('form[data-delete-form]');
    if (!src) return;
    e.preventDefault();
    const items = [...src.elements].filter((el) => el.name === 'ids[]' && (el.type !== 'checkbox' || el.checked));
    if (!items.length) return;
    const n = items.length;
    heading.textContent = n === 1 ? heading.dataset.one.replace(':title', items[0].dataset.title || '') : heading.dataset.many.replace(':n', n);
    list.replaceChildren(...items.slice(0, 8).map((el) => Object.assign(document.createElement('li'), { textContent: el.dataset.title || `#${el.value}` })));
    if (n > 8) list.append(Object.assign(document.createElement('li'), { className: 'muted', textContent: list.dataset.more.replace(':n', n - 8) }));
    ids.replaceChildren(...items.map((el) => Object.assign(document.createElement('input'), { type: 'hidden', name: 'ids[]', value: el.value })));
    const withTr = items.filter((el) => el.dataset.translation === '1').length;
    trBox.hidden = withTr === 0;
    $('input', trBox).checked = false;
    trLabel.textContent = trLabel.dataset.text.replace(':n', withTr);
    const ret = $('[name="return"]', src);
    if (ret) $('[data-delete-return]', dlg).value = ret.value;
    dlg.showModal();
    cancel.focus();
  });
}());

for (const form of $$('form[data-editor]')) {
  let dirty = false;
  const state = $('[data-save-state]', form);
  form.addEventListener('input', () => { dirty = true; if (state) state.textContent = state.dataset.dirty || ''; });
  form.addEventListener('submit', (e) => {
    if (e.submitter?.formTarget) return;
    dirty = false;
    $$('button[type="submit"]:not([formtarget])', form).forEach((b) => { b.disabled = true; });
  });
  window.addEventListener('beforeunload', (e) => { if (dirty) e.preventDefault(); });
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
      e.preventDefault();
      form.dispatchEvent(new Event('eo:sync'));
      form.requestSubmit($('[data-save]', form) || undefined);
    }
  });
}

/* Slug a partir del título mientras el slug no se haya tocado */
for (const title of $$('[data-slug-source]')) {
  const slug = document.getElementById(title.dataset.slugSource);
  if (!slug) continue;
  let manual = slug.value !== '';
  slug.addEventListener('input', () => { manual = slug.value !== ''; });
  title.addEventListener('input', () => { if (!manual) slug.value = slugify(title.value); slug.dispatchEvent(new Event('input', { bubbles: true })); manual = false; });
}

/* Copiar al portapapeles */
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('[data-copy]');
  if (!btn) return;
  try { await navigator.clipboard.writeText(btn.dataset.copy); toast(T.copied); } catch { /* sin permiso */ }
});

/* Formularios en segundo plano (texto alternativo en la biblioteca, etc.) */
document.addEventListener('submit', async (e) => {
  const form = e.target.closest('form[data-async]');
  if (!form || e.defaultPrevented) return;
  e.preventDefault();
  try {
    await api(form.action, { method: 'POST', body: new FormData(form) });
    toast(form.dataset.ok || T.saved);
  } catch (err) {
    toast(err.message || T.network, true);
  }
});

/* ======================================================================
   Biblioteca de medios: subir, elegir
   ====================================================================== */
async function uploadFiles(files, alt = '') {
  const images = [...files].filter((f) => f.type.startsWith('image/'));
  if (!images.length) return [];
  const fd = new FormData();
  images.forEach((f) => fd.append('files[]', f, f.name || 'imagen.png'));
  if (alt) fd.append('alt', alt);
  fd.append('_csrf', CSRF);
  try {
    const data = await api('/admin/medios/subir/', { method: 'POST', body: fd });
    (data.errors || []).forEach((m) => toast(m, true));
    return data.items || [];
  } catch (err) {
    toast(err.message || T.uploadError, true);
    return [];
  }
}

function bindDropzone(zone, onFiles) {
  const input = $('input[type="file"]', zone);
  ['dragenter', 'dragover'].forEach((ev) => zone.addEventListener(ev, (e) => { e.preventDefault(); zone.classList.add('is-over'); }));
  ['dragleave', 'drop'].forEach((ev) => zone.addEventListener(ev, (e) => { e.preventDefault(); zone.classList.remove('is-over'); }));
  zone.addEventListener('drop', (e) => { if (e.dataTransfer?.files?.length) onFiles(e.dataTransfer.files); });
  input?.addEventListener('change', () => { if (input.files.length) onFiles(input.files); input.value = ''; });
}

// Página de la biblioteca: subir sin recargar el formulario
for (const zone of $$('[data-dropzone]')) {
  const form = zone.closest('form');
  form?.addEventListener('submit', (e) => e.preventDefault());
  $('[data-dropzone-submit]', zone)?.remove();
  bindDropzone(zone, async (files) => {
    zone.setAttribute('aria-busy', 'true');
    const status = $('[data-dropzone-status]', zone);
    if (status) status.textContent = T.uploading;
    const items = await uploadFiles(files);
    zone.removeAttribute('aria-busy');
    if (items.length) location.reload();
    else if (status) status.textContent = '';
  });
}
if (location.hash === '#subir') $('[data-dropzone] input[type="file"]')?.click();

let mediaDialog = null;
function mediaPicker() {
  if (mediaDialog) return mediaDialog;
  const dlg = document.createElement('dialog');
  dlg.className = 'modal';
  dlg.innerHTML = `
    <div class="modal__head"><h2>${esc(T.insertImage)}</h2><button type="button" class="icon-btn" data-close aria-label="${esc(T.close)}">${icon('plus')}</button></div>
    <div class="modal__body">
      <div class="tabs" role="tablist">
        <button type="button" class="tab is-active" data-pane="lib">${esc(T.library)}</button>
        <button type="button" class="tab" data-pane="up">${esc(T.upload)}</button>
        <button type="button" class="tab" data-pane="url">${esc(T.fromUrl)}</button>
      </div>
      <section data-pane-id="lib">
        <input type="search" class="field" data-lib-q placeholder="${esc(T.search)}" aria-label="${esc(T.search)}">
        <div class="media-grid" data-lib-grid style="margin-top:10px"></div>
        <p style="text-align:center"><button type="button" class="btn btn--ghost btn--small" data-lib-more hidden>${esc(T.more)}</button></p>
      </section>
      <section data-pane-id="up" hidden>
        <div class="dropzone" data-up>${icon('upload')}<p><strong>${esc(T.drop)}</strong> <label class="link-button">${esc(T.choose)}<input type="file" accept="image/*" multiple hidden></label></p><p class="hint">${esc(T.dropHint)}</p><p data-up-status></p></div>
      </section>
      <section data-pane-id="url" hidden>
        <label for="mp-url">${esc(T.url)}</label><input id="mp-url" type="url" class="field" data-url placeholder="https://">
      </section>
      <div data-fields hidden>
        <label for="mp-alt">${esc(T.alt)}</label><input id="mp-alt" class="field" data-alt maxlength="255">
        <label for="mp-cap" data-cap-label>${esc(T.caption)}</label><input id="mp-cap" class="field" data-cap maxlength="255">
      </div>
    </div>
    <div class="modal__foot"><button type="button" class="btn btn--ghost" data-close>${esc(T.cancel)}</button><button type="button" class="btn" data-insert disabled>${esc(T.insert)}</button></div>`;
  $('[data-close] .icon', dlg).style.transform = 'rotate(45deg)';
  body.append(dlg);

  let selected = null;
  let page = 1;
  let resolver = null;
  // Selección múltiple (carrusel): se conserva el orden en que se eligen.
  let multi = false;
  const picked = new Map();
  const grid = $('[data-lib-grid]', dlg);
  const fields = $('[data-fields]', dlg);
  const insertBtn = $('[data-insert]', dlg);
  const altInput = $('[data-alt]', dlg);
  const heading = $('.modal__head h2', dlg);
  const urlTab = $('[data-pane="url"]', dlg);

  const paintPicked = () => {
    $$('button.media-card', grid).forEach((b) => b.setAttribute('aria-pressed', String(picked.has(Number(b.dataset.id)))));
    insertBtn.disabled = picked.size === 0;
    insertBtn.textContent = picked.size ? T.addN.replace(':n', picked.size) : T.add;
  };
  const choose = (item) => {
    if (multi) {
      if (item) { if (picked.has(item.id)) picked.delete(item.id); else picked.set(item.id, item); }
      paintPicked();
      return;
    }
    selected = item;
    $$('button.media-card', grid).forEach((b) => b.setAttribute('aria-pressed', String(Number(b.dataset.id) === item?.id)));
    fields.hidden = !item;
    if (item) altInput.value = item.alt || altInput.value;
    insertBtn.disabled = !item;
  };
  const card = (item) => {
    const b = document.createElement('button');
    b.type = 'button';
    b.className = 'media-card';
    b.dataset.id = item.id;
    b.setAttribute('aria-pressed', String(multi ? picked.has(item.id) : selected?.id === item.id));
    b.innerHTML = `<img src="${esc(item.thumb)}" alt="" loading="lazy"><span class="media-card__body"><span class="media-card__name">${esc(item.name || item.url)}</span><span class="media-card__meta">${item.width}×${item.height}</span></span>`;
    b.addEventListener('click', () => choose(item));
    b.addEventListener('dblclick', () => { if (multi) return; choose(item); if (altInput.value.trim()) insertBtn.click(); else altInput.focus(); });
    return b;
  };
  const load = async (reset = false) => {
    if (reset) { page = 1; grid.replaceChildren(); }
    const q = $('[data-lib-q]', dlg).value.trim();
    try {
      const data = await api(`/admin/medios/api/?q=${encodeURIComponent(q)}&page=${page}`);
      data.items.forEach((it) => grid.append(card(it)));
      if (!grid.children.length) grid.innerHTML = `<p class="muted">${esc(T.emptyLib)}</p>`;
      $('[data-lib-more]', dlg).hidden = grid.querySelectorAll('.media-card').length >= data.total;
    } catch { toast(T.network, true); }
  };
  $('[data-lib-q]', dlg).addEventListener('input', debounce(() => load(true), 250));
  $('[data-lib-more]', dlg).addEventListener('click', () => { page++; load(); });
  $$('[data-pane]', dlg).forEach((tab) => tab.addEventListener('click', () => {
    $$('[data-pane]', dlg).forEach((t) => t.classList.toggle('is-active', t === tab));
    $$('[data-pane-id]', dlg).forEach((p) => { p.hidden = p.dataset.paneId !== tab.dataset.pane; });
    if (tab.dataset.pane === 'url') { choose(null); $('[data-url]', dlg).focus(); }
  }));
  bindDropzone($('[data-up]', dlg), async (files) => {
    const status = $('[data-up-status]', dlg);
    status.textContent = T.uploading;
    const items = await uploadFiles(files);
    status.textContent = '';
    if (!items.length) return;
    $('[data-pane="lib"]', dlg).click();
    grid.querySelector('p.muted')?.remove();
    if (multi) items.forEach((it) => picked.set(it.id, it));
    [...items].reverse().forEach((it) => grid.prepend(card(it)));
    if (multi) { paintPicked(); insertBtn.focus(); return; }
    choose(items[0]);
    altInput.focus();
  });
  $('[data-url]', dlg).addEventListener('input', (e) => {
    const url = e.target.value.trim();
    const ok = /^(https?:\/\/|\/)/.test(url);
    selected = ok ? { url, alt: '', width: 0, height: 0, srcset: '' } : null;
    fields.hidden = !ok;
    insertBtn.disabled = !ok;
  });
  const finish = (value) => { const r = resolver; resolver = null; dlg.close(); r?.(value); };
  insertBtn.addEventListener('click', () => {
    if (multi) { if (picked.size) finish([...picked.values()]); return; }
    if (!selected) return;
    if (!altInput.value.trim()) { altInput.focus(); altInput.setCustomValidity(T.alt); altInput.reportValidity(); return; }
    altInput.setCustomValidity('');
    finish({ ...selected, alt: altInput.value.trim(), caption: $('[data-cap]', dlg).value.trim() });
  });
  $$('[data-close]', dlg).forEach((b) => b.addEventListener('click', () => finish(null)));
  dlg.addEventListener('close', () => { if (resolver) finish(null); });

  mediaDialog = {
    open({ caption = true, multiple = false } = {}) {
      multi = multiple;
      picked.clear();
      heading.textContent = multi ? T.selectImages : T.insertImage;
      urlTab.hidden = multi;
      insertBtn.textContent = multi ? T.add : T.insert;
      selected = null;
      choose(null);
      altInput.value = '';
      $('[data-cap]', dlg).value = '';
      $('[data-cap]', dlg).hidden = !caption;
      $('[data-cap-label]', dlg).hidden = !caption;
      $('[data-pane="lib"]', dlg).click();
      load(true);
      dlg.showModal();
      $('[data-lib-q]', dlg).focus();
      return new Promise((resolve) => { resolver = resolve; });
    },
  };
  return mediaDialog;
}
const pickImage = (opts) => mediaPicker().open(opts);

// Campos de imagen (portadas): vista previa + elegir de la biblioteca
for (const input of $$('input[data-media-input]')) {
  const wrap = document.createElement('div');
  wrap.className = 'media-field';
  wrap.innerHTML = `<div class="media-field__preview" data-preview>${esc(T.noImage)}</div><div class="media-field__row"></div>`;
  input.before(wrap);
  $('.media-field__row', wrap).append(input);
  const btn = document.createElement('button');
  btn.type = 'button';
  btn.className = 'btn btn--ghost btn--small';
  btn.innerHTML = `${icon('image')}${esc(T.pick)}`;
  $('.media-field__row', wrap).append(btn);
  const alt = input.dataset.altTarget ? document.getElementById(input.dataset.altTarget) : null;
  const preview = () => {
    const box = $('[data-preview]', wrap);
    const url = input.value.trim();
    box.innerHTML = url ? `<img src="${esc(url)}" alt="">` : esc(T.noImage);
  };
  input.addEventListener('input', preview);
  btn.addEventListener('click', async () => {
    const img = await pickImage({ caption: false });
    if (!img) return;
    input.value = img.url;
    if (alt && (!alt.value || alt.value === alt.dataset.lastAuto)) { alt.value = img.alt; alt.dataset.lastAuto = img.alt; }
    input.dispatchEvent(new Event('input', { bubbles: true }));
  });
  preview();
}

/* ======================================================================
   Diálogos pequeños reutilizables (enlace, video, bloque dinámico, imagen)
   ====================================================================== */
function smallDialog(title, html, onOpen) {
  const dlg = document.createElement('dialog');
  dlg.className = 'modal modal--sm';
  dlg.innerHTML = `<form method="dialog"><div class="modal__head"><h2>${esc(title)}</h2></div><div class="modal__body">${html}</div>
    <div class="modal__foot"><button type="button" class="btn btn--ghost" value="cancel" data-cancel>${esc(T.cancel)}</button><button class="btn" value="ok">${esc(T.insert)}</button></div></form>`;
  body.append(dlg);
  return new Promise((resolve) => {
    const form = $('form', dlg);
    $('[data-cancel]', dlg).addEventListener('click', () => dlg.close('cancel'));
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!form.reportValidity()) return;
      dlg.close('ok');
    });
    dlg.addEventListener('close', () => {
      const data = dlg.returnValue === 'ok' ? Object.fromEntries(new FormData(form)) : null;
      if (data) $$('input[type="checkbox"]', form).forEach((c) => { data[c.name] = c.checked; });
      dlg.remove();
      resolve(data);
    });
    dlg.showModal();
    onOpen?.(dlg);
  });
}

function linkDialog(current = {}) {
  return smallDialog(T.linkTitle, `
    <label for="ld-url">${esc(T.url)}</label><input id="ld-url" name="url" class="field" required value="${esc(current.url || '')}" placeholder="${esc(T.linkSearch)}" autocomplete="off">
    <ul class="suggest" data-suggest></ul>
    ${current.askText ? `<label for="ld-text">${esc(T.linkText)}</label><input id="ld-text" name="text" class="field" value="${esc(current.text || '')}">` : ''}
    <label class="check"><input type="checkbox" name="blank"${current.blank ? ' checked' : ''}> ${esc(T.newTab)}</label>`, (dlg) => {
    const url = $('#ld-url', dlg);
    const list = $('[data-suggest]', dlg);
    url.focus();
    url.select();
    url.addEventListener('input', debounce(async () => {
      const q = url.value.trim();
      list.replaceChildren();
      if (q.length < 2 || /^(https?:|\/|#|mailto:)/.test(q)) return;
      try {
        const data = await api(`/admin/buscar/?q=${encodeURIComponent(q)}`);
        for (const it of data.items || []) {
          const href = it.public || (it.slug ? `/producto/${it.slug}/` : null);
          if (!href) continue;
          const li = document.createElement('li');
          li.innerHTML = `<button type="button"><span>${esc(it.title)}</span><small>${esc(href)}</small></button>`;
          li.firstChild.addEventListener('click', () => {
            url.value = href;
            const text = $('#ld-text', dlg);
            if (text && !text.value) text.value = it.title;
            list.replaceChildren();
          });
          list.append(li);
        }
      } catch { /* sin red */ }
    }, 200));
  });
}

const ytId = (url) => (String(url).match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/))([A-Za-z0-9_-]{11})/) || [])[1] || null;
const liteYoutube = (id, title = '') => `<figure class="lite-yt" data-yt="${id}" contenteditable="false"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=${id}" data-yt="${id}"><img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg" alt="${esc(('Video: ' + title).trim())}" width="480" height="360"><span class="lite-yt__play"></span></a></figure><p><br></p>`;
const figureHtml = (img) => {
  const dims = img.width ? ` width="${img.width}" height="${img.height}"` : '';
  const srcset = img.srcset ? ` srcset="${esc(img.srcset)}" sizes="(min-width: 760px) 720px, 100vw"` : '';
  const tag = `<img src="${esc(img.url)}" alt="${esc(img.alt)}"${dims}${srcset} loading="lazy" decoding="async">`;
  return (img.caption ? `<figure>${tag}<figcaption>${esc(img.caption)}</figcaption></figure>` : `<figure>${tag}</figure>`) + '<p><br></p>';
};

/* ======================================================================
   Carrusel de imágenes (.carousel-gallery): marcado, lectura y diálogo
   Forma guardada (la misma que acepta HtmlCleaner y muestra carousel.js en el sitio):
   <div class="carousel-gallery" [data-autoplay="s"]><figure class="carousel-gallery__item"><img …><figcaption>…</figcaption></figure>…</div>
   ====================================================================== */
const carouselHtml = (items, autoplay = 0) => `<div class="carousel-gallery"${autoplay ? ` data-autoplay="${Number(autoplay)}"` : ''}>${items.map((it) => {
  const dims = it.width && it.height ? ` width="${Number(it.width)}" height="${Number(it.height)}"` : '';
  const srcset = it.srcset ? ` srcset="${esc(it.srcset)}" sizes="(min-width: 760px) 720px, 100vw"` : '';
  // El pie que no se tocó conserva su formato (negritas, enlaces); el editado se guarda como texto.
  const cap = it.captionHtml && it.caption === it.captionText ? it.captionHtml : esc(it.caption || '');
  return `\n<figure class="carousel-gallery__item"><img src="${esc(it.url)}" alt="${esc(it.alt)}"${dims}${srcset} loading="lazy" decoding="async">${cap.trim() ? `<figcaption>${cap}</figcaption>` : ''}</figure>`;
}).join('')}\n</div>`;

function readCarousel(gallery) {
  const items = $$('figure', gallery).map((f) => {
    const img = $('img', f);
    if (!img) return null;
    const cap = $('figcaption', f);
    const caption = (cap?.textContent || '').replace(/\s+/g, ' ').trim();
    return {
      url: img.getAttribute('src') || '', thumb: img.getAttribute('src') || '', alt: (img.getAttribute('alt') || '').trim(),
      width: Number(img.getAttribute('width')) || 0, height: Number(img.getAttribute('height')) || 0, srcset: img.getAttribute('srcset') || '',
      caption, captionText: caption, captionHtml: cap ? cap.innerHTML.trim() : '',
    };
  }).filter(Boolean);
  return { items, autoplay: Number(gallery.dataset.autoplay) || 0 };
}

const fromMedia = (it) => ({ url: it.url, thumb: it.thumb || it.url, alt: it.alt || '', caption: '', width: it.width || 0, height: it.height || 0, srcset: it.srcset || '' });

/** Ordenar, texto alternativo y pie por imagen, agregar más (subir o biblioteca) y avance automático. */
function carouselDialog(initial = [], autoplay = 0, editing = false) {
  const dlg = document.createElement('dialog');
  dlg.className = 'modal cg-dialog';
  dlg.setAttribute('aria-labelledby', 'cgd-title');
  dlg.innerHTML = `
    <div class="modal__head"><h2 id="cgd-title">${esc(T.carousel)}</h2><button type="button" class="icon-btn" data-close aria-label="${esc(T.close)}">${icon('close')}</button></div>
    <div class="modal__body">
      <p class="hint" id="cgd-hint">${esc(T.carouselHint)}</p>
      <ol class="cg-list" data-list aria-describedby="cgd-hint"></ol>
      <p class="muted cg-empty" data-empty>${esc(T.carouselEmpty)}</p>
      <div class="cg-dialog__opts">
        <button type="button" class="btn btn--ghost btn--small" data-add>${icon('plus')}${esc(T.addImages)}</button>
        <div><label for="cgd-auto">${esc(T.autoplay)}</label><select id="cgd-auto" class="field" data-auto>
          <option value="0">${esc(T.autoplayOff)}</option>${[5, 8, 12].map((n) => `<option value="${n}">${esc(T.autoplayEvery.replace(':n', n))}</option>`).join('')}</select></div>
      </div>
    </div>
    <div class="modal__foot"><span class="muted cg-dialog__count" data-count aria-live="polite"></span><button type="button" class="btn btn--ghost" data-close>${esc(T.cancel)}</button><button type="button" class="btn" data-ok>${esc(editing ? T.saveCarousel : T.insertCarousel)}</button></div>`;
  body.append(dlg);
  const list = $('[data-list]', dlg);
  const auto = $('[data-auto]', dlg);
  if ([...auto.options].some((o) => Number(o.value) === autoplay)) auto.value = String(autoplay);
  else if (autoplay) auto.insertAdjacentHTML('beforeend', `<option value="${autoplay}" selected>${esc(T.autoplayEvery.replace(':n', autoplay))}</option>`);
  let seq = 0;

  const renumber = () => {
    const rows = $$('.cg-row', list);
    rows.forEach((li, i) => {
      const n = T.imageN.replace(':n', i + 1);
      $('.cg-row__num', li).textContent = i + 1;
      $('[data-up]', li).setAttribute('aria-label', `${T.up}: ${n}`);
      $('[data-down]', li).setAttribute('aria-label', `${T.down}: ${n}`);
      $('[data-del]', li).setAttribute('aria-label', `${T.remove}: ${n}`);
      $('[data-up]', li).disabled = i === 0;
      $('[data-down]', li).disabled = i === rows.length - 1;
    });
    $('[data-empty]', dlg).hidden = rows.length > 0;
    $('[data-count]', dlg).textContent = rows.length ? T.carouselImages.replace(':n', rows.length) : '';
  };
  const row = (item) => {
    const k = ++seq;
    const li = document.createElement('li');
    li.className = 'cg-row';
    li.item = item;
    li.innerHTML = `<span class="cg-row__handle" title="${esc(T.carouselHint)}">${icon('drag')}<b class="cg-row__num"></b></span>
      <img class="cg-row__thumb" src="${esc(item.thumb || item.url)}" alt="">
      <div class="cg-row__fields">
        <label for="cgd-alt-${k}">${esc(T.alt)}</label><input id="cgd-alt-${k}" class="field" data-alt maxlength="255" required value="${esc(item.alt)}">
        <label for="cgd-cap-${k}">${esc(T.caption)}</label><input id="cgd-cap-${k}" class="field" data-cap maxlength="255" value="${esc(item.caption)}">
      </div>
      <div class="cg-row__tools"><button type="button" class="icon-btn icon-btn--sm" data-up>${icon('arrow-up')}</button><button type="button" class="icon-btn icon-btn--sm" data-down>${icon('arrow-down')}</button><button type="button" class="icon-btn icon-btn--sm" data-del>${icon('trash')}</button></div>`;
    list.append(li);
  };
  const add = (items) => { items.forEach(row); renumber(); };
  add(initial);

  list.addEventListener('click', (e) => {
    const li = e.target.closest('.cg-row');
    if (!li) return;
    const btn = e.target.closest('button');
    if (!btn) return;
    if (btn.matches('[data-del]')) {
      const focusTo = li.nextElementSibling || li.previousElementSibling;
      li.remove();
      renumber();
      ($('[data-del]', focusTo || dlg) || $('[data-add]', dlg)).focus();
      return;
    }
    if (btn.matches('[data-up]') && li.previousElementSibling) li.previousElementSibling.before(li);
    if (btn.matches('[data-down]') && li.nextElementSibling) li.nextElementSibling.after(li);
    renumber();
    if (btn.disabled) $(btn.matches('[data-up]') ? '[data-down]' : '[data-up]', li).focus(); else btn.focus();
  });
  // Arrastrar para ordenar: solo desde el asa (así se puede seleccionar texto en los campos).
  let dragging = null;
  list.addEventListener('pointerdown', (e) => { const h = e.target.closest('.cg-row__handle'); if (h) h.closest('.cg-row').draggable = true; });
  list.addEventListener('dragstart', (e) => {
    dragging = e.target.closest('.cg-row');
    if (!dragging) return;
    dragging.classList.add('is-drag');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', '');
  });
  list.addEventListener('dragover', (e) => {
    if (!dragging) return;
    e.preventDefault();
    const li = e.target.closest('.cg-row');
    if (!li || li === dragging) return;
    const r = li.getBoundingClientRect();
    if (e.clientY > r.top + r.height / 2) li.after(dragging); else li.before(dragging);
  });
  list.addEventListener('dragend', () => {
    if (!dragging) return;
    dragging.classList.remove('is-drag');
    dragging.draggable = false;
    dragging = null;
    renumber();
  });

  $('[data-add]', dlg).addEventListener('click', async () => {
    const items = await pickImage({ multiple: true });
    if (items?.length) {
      add(items.map(fromMedia));
      const first = $$('.cg-row', list)[$$('.cg-row', list).length - items.length];
      $('[data-alt]', first)?.focus();
    }
  });

  return new Promise((resolve) => {
    let result = null;
    $$('[data-close]', dlg).forEach((b) => b.addEventListener('click', () => dlg.close()));
    $('[data-ok]', dlg).addEventListener('click', () => {
      const rows = $$('.cg-row', list);
      if (rows.length < 2) { toast(T.carouselMin, true); $('[data-add]', dlg).focus(); return; }
      const missing = rows.map((li) => $('[data-alt]', li)).find((input) => !input.value.trim());
      if (missing) { missing.setCustomValidity(T.alt); missing.reportValidity(); missing.addEventListener('input', () => missing.setCustomValidity(''), { once: true }); return; }
      result = {
        autoplay: Number(auto.value) || 0,
        items: rows.map((li) => ({ ...li.item, alt: $('[data-alt]', li).value.trim(), caption: $('[data-cap]', li).value.replace(/\s+/g, ' ').trim() })),
      };
      dlg.close();
    });
    dlg.addEventListener('close', () => { dlg.remove(); resolve(result); });
    dlg.showModal();
    ($('[data-alt]', list) && initial.length ? $$('[data-alt]', list).find((i) => !i.value.trim()) || $('[data-ok]', dlg) : $('[data-add]', dlg)).focus();
  });
}

/* ======================================================================
   Editor de texto enriquecido
   ====================================================================== */
const ALLOWED = new Set(['P', 'H2', 'H3', 'H4', 'UL', 'OL', 'LI', 'A', 'STRONG', 'EM', 'BLOCKQUOTE', 'PRE', 'CODE', 'BR', 'HR', 'TABLE', 'THEAD', 'TBODY', 'TFOOT', 'TR', 'TH', 'TD', 'CAPTION', 'IMG', 'FIGURE', 'FIGCAPTION']);
const RENAME = { B: 'STRONG', I: 'EM', H1: 'H2', H5: 'H4', H6: 'H4', KBD: 'CODE', TT: 'CODE' };
const DROP = new Set(['SCRIPT', 'STYLE', 'META', 'LINK', 'TITLE', 'NOSCRIPT', 'IFRAME', 'OBJECT', 'EMBED', 'SVG', 'FORM', 'INPUT', 'BUTTON', 'SELECT', 'TEXTAREA', 'TEMPLATE', 'HEAD']);
const KEEP_ATTRS = { A: ['href', 'target'], IMG: ['src', 'alt', 'width', 'height', 'srcset', 'sizes'], TD: ['colspan', 'rowspan'], TH: ['colspan', 'rowspan', 'scope'], OL: ['start'] };

/** Limpia HTML pegado desde Word, Google Docs o páginas web. */
function cleanPaste(html) {
  const tpl = new DOMParser().parseFromString(html, 'text/html');
  const walk = (node) => {
    for (const child of [...node.childNodes]) {
      if (child.nodeType === Node.COMMENT_NODE) { child.remove(); continue; }
      if (child.nodeType !== Node.ELEMENT_NODE) continue;
      let el = child;
      let tag = el.tagName.toUpperCase();
      if (DROP.has(tag) || tag.includes(':')) { el.remove(); continue; }
      const style = el.getAttribute('style') || '';
      if (tag === 'SPAN' || (tag === 'B' && /font-weight:\s*(normal|400)/.test(style))) {
        const bold = /font-weight:\s*(bold|[6-9]00)/.test(style);
        const italic = /font-style:\s*italic/.test(style);
        if (tag === 'SPAN' && (bold || italic)) {
          const wrap = document.createElement(bold ? 'strong' : 'em');
          wrap.append(...el.childNodes);
          el.replaceWith(wrap);
          el = wrap;
          tag = wrap.tagName;
        } else {
          walk(el);
          el.replaceWith(...el.childNodes);
          continue;
        }
      }
      if (tag === 'DIV' || tag === 'SECTION' || tag === 'ARTICLE') {
        const hasBlock = [...el.children].some((c) => /^(P|H\d|UL|OL|TABLE|DIV|BLOCKQUOTE|PRE|FIGURE)$/.test(c.tagName));
        if (hasBlock) { walk(el); el.replaceWith(...el.childNodes); continue; }
        const p = document.createElement('p');
        p.append(...el.childNodes);
        el.replaceWith(p);
        el = p;
        tag = 'P';
      }
      if (RENAME[tag]) {
        const n = document.createElement(RENAME[tag]);
        n.append(...el.childNodes);
        [...el.attributes].forEach((a) => n.setAttribute(a.name, a.value));
        el.replaceWith(n);
        el = n;
        tag = n.tagName;
      }
      if (!ALLOWED.has(tag)) { walk(el); el.replaceWith(...el.childNodes); continue; }
      const keep = KEEP_ATTRS[tag] || [];
      [...el.attributes].forEach((a) => { if (!keep.includes(a.name)) el.removeAttribute(a.name); });
      if (tag === 'A' && /^\s*javascript:/i.test(el.getAttribute('href') || '')) el.removeAttribute('href');
      walk(el);
    }
  };
  walk(tpl.body);
  $$('p, h2, h3, h4, li', tpl.body).forEach((el) => { if (!el.textContent.trim() && !el.querySelector('img, br')) el.remove(); });
  return tpl.body.innerHTML;
}

function textToHtml(text) {
  return text.split(/\n{2,}/).map((block) => block.trim()).filter(Boolean)
    .map((block) => `<p>${esc(block).replace(/\n/g, '<br>').replace(/(https?:\/\/[^\s<]+)/g, '<a href="$1">$1</a>')}</p>`).join('');
}

const MARKER = /^\s*\{\{(productos|articulos):[^}]*\}\}\s*$/;

class RichEditor {
  constructor(textarea, data) {
    this.ta = textarea;
    this.basic = textarea.dataset.rte === 'basic';
    this.data = data;
    this.range = null;
    this.build();
    this.load(textarea.value);
    textarea.addEventListener('eo:refresh', () => this.load(textarea.value));
    textarea.form?.addEventListener('submit', () => this.sync(), true);
    textarea.form?.addEventListener('eo:sync', () => this.sync());
  }

  build() {
    const wrap = document.createElement('div');
    wrap.className = 'rte' + (this.basic ? ' rte--basic' : '');
    const bar = document.createElement('div');
    bar.className = 'rte__bar';
    bar.setAttribute('role', 'toolbar');
    const area = document.createElement('div');
    area.className = 'rte__area';
    area.contentEditable = 'true';
    area.spellcheck = true;
    area.lang = this.ta.closest('[lang]')?.lang || 'es';
    area.setAttribute('role', 'textbox');
    area.setAttribute('aria-multiline', 'true');
    area.dataset.placeholder = this.basic ? '' : T.placeholder;
    const label = this.ta.id ? $(`label[for="${this.ta.id}"]`) : null;
    if (label) { area.id = this.ta.id + '-rte'; label.htmlFor = area.id; area.setAttribute('aria-label', label.textContent.trim()); }
    const source = document.createElement('textarea');
    source.className = 'rte__source';
    source.hidden = true;
    source.spellcheck = false;
    source.setAttribute('aria-label', T.source);
    const status = document.createElement('div');
    status.className = 'rte__status';
    status.setAttribute('aria-live', 'off');
    wrap.append(bar, area, source);
    if (!this.basic) wrap.append(status);
    this.ta.hidden = true;
    this.ta.after(wrap);
    Object.assign(this, { wrap, bar, area, source, status });

    const tools = this.basic
      ? ['bold', 'italic', 'link', '|', 'ul', 'ol', '~', 'source']
      : ['block', '|', 'bold', 'italic', '|', 'link', 'unlink', '|', 'ul', 'ol', 'quote', '|', 'image', 'carousel', 'video', 'table', 'hr', 'notice', 'marker', '|', 'undo', 'redo', '~', 'source', 'full'];
    const icons = { bold: 'bold', italic: 'italic', link: 'link', unlink: 'unlink', ul: 'list', ol: 'list-ol', quote: 'quote', image: 'image', carousel: 'grid', video: 'video', table: 'table', hr: 'minus', notice: 'notice', marker: 'layers', undo: 'undo', redo: 'redo', source: 'code', full: 'maximize' };
    for (const t of tools) {
      if (t === '|') { bar.insertAdjacentHTML('beforeend', '<span class="rte__sep"></span>'); continue; }
      if (t === '~') { bar.insertAdjacentHTML('beforeend', '<span class="rte__spacer"></span>'); continue; }
      if (t === 'block') {
        const sel = document.createElement('select');
        sel.setAttribute('aria-label', T.paragraph);
        sel.innerHTML = [['p', T.paragraph], ['h2', T.h2], ['h3', T.h3], ['h4', T.h4], ['pre', T.pre]].map(([v, l]) => `<option value="${v}">${esc(l)}</option>`).join('');
        sel.addEventListener('change', () => { this.restore(); this.exec('formatBlock', `<${sel.value}>`); });
        bar.append(sel);
        this.blockSelect = sel;
        continue;
      }
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'rte__btn';
      b.dataset.cmd = t;
      b.title = T[t];
      b.setAttribute('aria-label', T[t]);
      b.innerHTML = icon(icons[t]);
      if (['bold', 'italic', 'ul', 'ol', 'quote', 'source', 'full'].includes(t)) b.setAttribute('aria-pressed', 'false');
      bar.append(b);
    }
    bar.addEventListener('mousedown', (e) => { if (e.target.closest('.rte__btn')) e.preventDefault(); });
    bar.addEventListener('click', (e) => { const b = e.target.closest('.rte__btn'); if (b) this.command(b.dataset.cmd); });

    document.execCommand('defaultParagraphSeparator', false, 'p');
    area.addEventListener('input', debounce(() => this.sync(), 200));
    area.addEventListener('keyup', () => this.state());
    area.addEventListener('mouseup', () => this.state());
    area.addEventListener('blur', () => this.save());
    area.addEventListener('paste', (e) => this.paste(e));
    area.addEventListener('drop', (e) => this.drop(e));
    area.addEventListener('click', (e) => {
      $$('img.is-selected', area).forEach((i) => i.classList.remove('is-selected'));
      const cg = e.target.closest('[data-cg-edit], [data-cg-remove]');
      if (cg) { e.preventDefault(); this.carouselAction(cg); return; }
      const img = e.target.closest('img');
      if (img && !img.closest('.rte-carousel')) img.classList.add('is-selected');
      const a = e.target.closest('a');
      if (a && (e.ctrlKey || e.metaKey)) window.open(a.href, '_blank', 'noopener');
    });
    area.addEventListener('dblclick', (e) => {
      const block = e.target.closest('.rte-carousel');
      if (block) { this.editCarousel(block); return; }
      const img = e.target.closest('img');
      if (img && !img.closest('.lite-yt')) this.editImage(img);
    });
    area.addEventListener('keydown', (e) => {
      const mod = e.ctrlKey || e.metaKey;
      if (mod && e.key.toLowerCase() === 'k') { e.preventDefault(); this.command('link'); }
      if (e.key === 'Delete' || e.key === 'Backspace') {
        const img = $('img.is-selected', area);
        if (img) { e.preventDefault(); (img.closest('figure') || img).remove(); this.sync(); }
      }
    });
    source.addEventListener('input', debounce(() => { this.ta.value = source.value; this.changed(); }, 200));
  }

  load(html) {
    this.area.innerHTML = html.trim() || '<p><br></p>';
    this.decorate();
    if (!this.basic) this.stats();
  }

  /** HTML limpio que se guarda en el textarea original. */
  serialize() {
    const root = this.area.cloneNode(true);
    $$('.rte-carousel', root).forEach((block) => {
      const gallery = $('.carousel-gallery', block);
      const data = gallery ? readCarousel(gallery) : { items: [] };
      const tpl = document.createElement('template');
      tpl.innerHTML = data.items.length ? carouselHtml(data.items, data.autoplay) : '';
      block.replaceWith(...tpl.content.childNodes);
    });
    $$('[contenteditable]', root).forEach((el) => el.removeAttribute('contenteditable'));
    $$('.is-selected', root).forEach((el) => el.classList.remove('is-selected'));
    $$('p.marker', root).forEach((el) => el.removeAttribute('class'));
    $$('[style]', root).forEach((el) => el.removeAttribute('style'));
    $$('div:not(.carousel-gallery)', root).forEach((d) => { const p = document.createElement('p'); p.append(...d.childNodes); d.replaceWith(p); });
    // Un párrafo no puede contener bloques (el navegador a veces deja <p><ul>…</ul></p>): se separan.
    const BLOCK = /^(P|UL|OL|TABLE|H2|H3|H4|FIGURE|BLOCKQUOTE|PRE|HR|DIV)$/;
    [...root.querySelectorAll('p')].reverse().forEach((p) => {
      if (![...p.children].some((c) => BLOCK.test(c.tagName))) return;
      const out = [];
      let inline = null;
      for (const node of [...p.childNodes]) {
        if (node.nodeType === 1 && BLOCK.test(node.tagName)) { inline = null; out.push(node); continue; }
        if (!inline) { inline = document.createElement('p'); out.push(inline); }
        inline.append(node);
      }
      p.replaceWith(...out);
    });
    $$('span:not([class])', root).forEach((s) => s.replaceWith(...s.childNodes));
    $$('b', root).forEach((b) => { const s = document.createElement('strong'); s.append(...b.childNodes); b.replaceWith(s); });
    $$('i', root).forEach((i) => { const s = document.createElement('em'); s.append(...i.childNodes); i.replaceWith(s); });
    $$('p, h2, h3, h4', root).forEach((el) => {
      if (!el.textContent.trim() && !el.querySelector('img')) el.remove();
      else if (el.lastChild?.nodeName === 'BR') el.lastChild.remove();
    });
    $$('[class=""]', root).forEach((el) => el.removeAttribute('class'));
    return root.innerHTML.replace(/<(p|h2|h3|h4|ul|ol|figure|blockquote|table|pre|hr|div)([\s>])/g, '\n<$1$2').replace(/\n{2,}(<figure class="carousel-gallery__item")/g, '\n$1').trim();
  }

  sync() {
    if (!this.source.hidden) { this.ta.value = this.source.value; return; }
    const html = this.serialize();
    if (html !== this.ta.value) { this.ta.value = html; this.changed(); }
    if (!this.basic) this.stats();
  }

  changed() { this.ta.dispatchEvent(new Event('input', { bubbles: true })); }

  exec(cmd, value = null) {
    this.area.focus();
    document.execCommand(cmd, false, value);
    this.sync();
    this.state();
  }

  save() {
    const sel = getSelection();
    if (sel.rangeCount && this.area.contains(sel.anchorNode)) this.range = sel.getRangeAt(0).cloneRange();
  }

  restore() {
    this.area.focus();
    if (!this.range) return;
    const sel = getSelection();
    sel.removeAllRanges();
    sel.addRange(this.range);
  }

  insert(html) {
    this.restore();
    document.execCommand('insertHTML', false, html);
    this.decorate();
    this.sync();
  }

  /** Bloques (imagen, video, tabla, marcador): se insertan tras el bloque del cursor, sin execCommand,
      que en Chrome descarta imágenes dentro de <figure>. */
  insertBlock(html) {
    this.restore();
    const tpl = document.createElement('template');
    tpl.innerHTML = html;
    const nodes = [...tpl.content.childNodes].filter((n) => n.nodeType === 1 || n.textContent.trim());
    const sel = getSelection();
    const start = sel.rangeCount ? sel.getRangeAt(0).startContainer : null;
    let block = start && (start.nodeType === 1 ? start : start.parentElement);
    while (block && block.parentElement !== this.area) block = block.parentElement;
    if (!block || block === this.area) this.area.append(...nodes);
    else if (!block.textContent.trim() && !block.querySelector('img')) block.replaceWith(...nodes);
    else block.after(...nodes);
    const last = nodes[nodes.length - 1];
    if (last?.tagName === 'P') {
      const r = document.createRange();
      r.setStart(last, 0);
      r.collapse(true);
      sel.removeAllRanges();
      sel.addRange(r);
      this.range = r.cloneRange();
    }
    this.decorate();
    this.sync();
  }

  decorate() {
    $$('.lite-yt', this.area).forEach((f) => { f.contentEditable = 'false'; });
    // Carrusel: bloque no editable con vista previa en tira y botones «Editar carrusel» / «Quitar».
    $$('.carousel-gallery', this.area).forEach((g) => {
      let block = g.closest('.rte-carousel');
      if (!block) {
        block = document.createElement('div');
        block.className = 'rte-carousel';
        block.contentEditable = 'false';
        block.innerHTML = `<div class="rte-carousel__bar">${icon('grid')}<strong>${esc(T.carousel)}</strong><span class="muted" data-cg-count></span>
          <span class="rte-carousel__actions"><button type="button" class="btn btn--ghost btn--small" data-cg-edit>${esc(T.carouselEdit)}</button><button type="button" class="btn btn--ghost btn--small" data-cg-remove>${icon('trash')}${esc(T.carouselRemove)}</button></span></div>`;
        g.before(block);
        block.append(g);
      }
      $('[data-cg-count]', block).textContent = `· ${T.carouselImages.replace(':n', $$('figure', g).length)}`;
      $$('img', g).forEach((img) => { img.draggable = false; });
      if (block.parentElement === this.area && !block.nextElementSibling) block.after(Object.assign(document.createElement('p'), { innerHTML: '<br>' }));
    });
    $$('p', this.area).forEach((p) => { if (MARKER.test(p.textContent)) p.classList.add('marker'); });
  }

  state() {
    this.save();
    for (const [cmd, q] of [['bold', 'bold'], ['italic', 'italic'], ['ul', 'insertUnorderedList'], ['ol', 'insertOrderedList']]) {
      const b = $(`[data-cmd="${cmd}"]`, this.bar);
      if (b) b.setAttribute('aria-pressed', String(document.queryCommandState(q)));
    }
    const node = getSelection().anchorNode;
    const block = node && (node.nodeType === 1 ? node : node.parentElement)?.closest('p, h2, h3, h4, pre, blockquote, li');
    if (this.blockSelect && block && this.area.contains(block)) {
      const tag = block.tagName.toLowerCase();
      if (['p', 'h2', 'h3', 'h4', 'pre'].includes(tag)) this.blockSelect.value = tag;
    }
    const q = $('[data-cmd="quote"]', this.bar);
    if (q) q.setAttribute('aria-pressed', String(!!block?.closest('blockquote')));
  }

  stats() {
    const text = this.area.innerText || '';
    const words = (text.match(/[\p{L}\p{N}]+/gu) || []).length;
    const h = $$('h2, h3', this.area).length;
    const links = $$('a[href]', this.area).length;
    const imgs = $$('img', this.area).length;
    this.status.innerHTML = `<span><b>${words.toLocaleString('es-CO')}</b> ${T.words}</span><span><b>${Math.max(1, Math.round(words / 200))}</b> ${T.minutes}</span><span><b>${h}</b> ${T.headings}</span><span><b>${links}</b> ${T.links}</span><span><b>${imgs}</b> ${T.images}</span>`;
    document.dispatchEvent(new CustomEvent('eo:content', { detail: { editor: this } }));
  }

  async command(cmd) {
    this.save();
    switch (cmd) {
      case 'bold': case 'italic': case 'undo': case 'redo': case 'unlink': this.exec(cmd); break;
      case 'ul': this.exec('insertUnorderedList'); break;
      case 'ol': this.exec('insertOrderedList'); break;
      case 'quote': {
        const node = getSelection().anchorNode;
        const inQuote = node && (node.nodeType === 1 ? node : node.parentElement)?.closest('blockquote');
        this.exec('formatBlock', inQuote ? '<p>' : '<blockquote>');
        break;
      }
      case 'hr': this.insertBlock('<hr><p><br></p>'); break;
      case 'notice': {
        this.restore();
        const node = getSelection().anchorNode;
        const block = node && (node.nodeType === 1 ? node : node.parentElement)?.closest('p');
        if (block && this.area.contains(block)) block.classList.toggle('notice');
        else this.insert('<p class="notice">…</p>');
        this.sync();
        break;
      }
      case 'table':
        this.insertBlock('<table><thead><tr><th>Columna 1</th><th>Columna 2</th><th>Columna 3</th></tr></thead><tbody><tr><td>…</td><td>…</td><td>…</td></tr><tr><td>…</td><td>…</td><td>…</td></tr></tbody></table><p><br></p>');
        break;
      case 'link': {
        const sel = getSelection();
        const node = sel.anchorNode;
        const a = node && (node.nodeType === 1 ? node : node.parentElement)?.closest('a');
        const range = this.range;
        const collapsed = !range || range.collapsed;
        const data = await linkDialog({ url: a?.getAttribute('href') || '', blank: a?.target === '_blank', askText: collapsed && !a, text: '' });
        this.range = range;
        if (!data || !data.url) { this.restore(); return; }
        const url = data.url.trim();
        if (a) {
          a.setAttribute('href', url);
          if (data.blank) { a.target = '_blank'; } else { a.removeAttribute('target'); }
          this.sync();
        } else if (collapsed) {
          this.insert(`<a href="${esc(url)}"${data.blank ? ' target="_blank"' : ''}>${esc(data.text || url)}</a>&nbsp;`);
        } else {
          this.restore();
          document.execCommand('createLink', false, url);
          if (data.blank) $$(`a[href="${CSS.escape(url)}"]`, this.area).forEach((l) => { l.target = '_blank'; });
          this.sync();
        }
        break;
      }
      case 'image': {
        const range = this.range;
        const img = await pickImage({ caption: true });
        this.range = range;
        if (img) this.insertBlock(figureHtml(img));
        else this.restore();
        break;
      }
      case 'carousel': {
        const range = this.range;
        const picked = await pickImage({ multiple: true });
        const data = picked?.length ? await carouselDialog(picked.map(fromMedia)) : null;
        this.range = range;
        if (data) this.insertBlock(carouselHtml(data.items, data.autoplay) + '<p><br></p>');
        else this.restore();
        break;
      }
      case 'video': {
        const range = this.range;
        const data = await smallDialog(T.videoTitle, `<label for="vd-url">${esc(T.videoUrl)}</label><input id="vd-url" name="url" class="field" required placeholder="https://www.youtube.com/watch?v=…">`, (d) => $('#vd-url', d).focus());
        this.range = range;
        if (!data) { this.restore(); return; }
        const id = ytId(data.url);
        if (!id) { toast(T.videoBad, true); return; }
        this.insertBlock(liteYoutube(id, $('#p-title')?.value || ''));
        break;
      }
      case 'marker': {
        const range = this.range;
        const products = (this.data.products || []).map((p) => `<option value="productos:${esc(p.slug)}">${esc(p.title)}</option>`).join('');
        const hubs = (this.data.hubs || []).map((h) => `<option value="articulos:${esc(h.key)}">${esc(T.hub)}: ${esc(h.title)}</option>`).join('');
        const data = await smallDialog(T.markerTitle, `<label for="mk">${esc(T.markerTitle)}</label><select id="mk" name="marker" class="field">
          <option value="productos:destacados">${esc(T.featured)}</option>${products ? `<optgroup label="${esc(T.product)}">${products}</optgroup>` : ''}
          <option value="articulos:blog">${esc(T.blog)}</option>${hubs}</select>`);
        this.range = range;
        if (data?.marker) this.insertBlock(`<p class="marker">{{${esc(data.marker)}}}</p><p><br></p>`);
        else this.restore();
        break;
      }
      case 'source': {
        const toSource = this.source.hidden;
        if (toSource) {
          this.sync();
          this.source.value = this.ta.value;
          this.source.style.minHeight = Math.max(this.area.offsetHeight, 300) + 'px';
        } else {
          this.ta.value = this.source.value;
          this.load(this.source.value);
          this.changed();
        }
        this.source.hidden = !toSource;
        this.area.hidden = toSource;
        $$('.rte__btn, select', this.bar).forEach((b) => { if (!['source', 'full'].includes(b.dataset.cmd)) b.disabled = toSource; });
        const b = $('[data-cmd="source"]', this.bar);
        b.setAttribute('aria-pressed', String(toSource));
        b.title = toSource ? T.visual : T.source;
        (toSource ? this.source : this.area).focus();
        break;
      }
      case 'full': {
        const on = !this.wrap.classList.contains('is-full');
        this.wrap.classList.toggle('is-full', on);
        body.classList.toggle('rte-full', on);
        $('[data-cmd="full"]', this.bar).setAttribute('aria-pressed', String(on));
        if (on) {
          const exit = (e) => { if (e.key === 'Escape') { this.command('full'); document.removeEventListener('keydown', exit); } };
          document.addEventListener('keydown', exit);
        }
        break;
      }
      default: break;
    }
  }

  async paste(e) {
    const dt = e.clipboardData;
    if (!dt) return;
    const files = [...dt.files].filter((f) => f.type.startsWith('image/'));
    const html = dt.getData('text/html');
    const text = dt.getData('text/plain');
    e.preventDefault();
    this.save();
    if (files.length && !html) {
      const items = await uploadFiles(files);
      items.forEach((it) => this.insertBlock(figureHtml({ ...it, alt: it.alt || '' })));
      return;
    }
    if (!html && ytId(text) && /^\S+$/.test(text.trim())) { this.insertBlock(liteYoutube(ytId(text))); return; }
    if (this.basic || !html) { document.execCommand('insertHTML', false, html ? cleanPaste(html) : textToHtml(text)); this.sync(); return; }
    document.execCommand('insertHTML', false, cleanPaste(html));
    this.sync();
  }

  async drop(e) {
    const files = [...(e.dataTransfer?.files || [])].filter((f) => f.type.startsWith('image/'));
    if (!files.length) return;
    e.preventDefault();
    const pos = document.caretRangeFromPoint?.(e.clientX, e.clientY);
    if (pos) { const sel = getSelection(); sel.removeAllRanges(); sel.addRange(pos); this.save(); }
    const items = await uploadFiles(files);
    for (const it of items) this.insertBlock(figureHtml({ ...it, alt: it.alt || '' }));
  }

  async carouselAction(btn) {
    const block = btn.closest('.rte-carousel');
    if (!block) return;
    if (btn.matches('[data-cg-edit]')) { this.editCarousel(block); return; }
    const ok = typeof HTMLDialogElement === 'function' ? await confirmDialog(T.carouselRemoveQ, T.carouselRemove) : window.confirm(T.carouselRemoveQ);
    if (!ok) return;
    block.remove();
    this.sync();
  }

  async editCarousel(block) {
    const gallery = $('.carousel-gallery', block);
    if (!gallery) return;
    const { items, autoplay } = readCarousel(gallery);
    const data = await carouselDialog(items, autoplay, true);
    if (!data) return;
    const tpl = document.createElement('template');
    tpl.innerHTML = carouselHtml(data.items, data.autoplay);
    gallery.replaceWith(tpl.content.firstElementChild);
    this.decorate();
    this.sync();
    $('[data-cg-edit]', block)?.focus();
  }

  async editImage(img) {
    const fig = img.closest('figure');
    const cap = fig?.querySelector('figcaption');
    const data = await smallDialog(T.editImage, `
      <label for="ei-alt">${esc(T.alt)}</label><input id="ei-alt" name="alt" class="field" value="${esc(img.getAttribute('alt') || '')}" required>
      <label for="ei-cap">${esc(T.caption)}</label><input id="ei-cap" name="caption" class="field" value="${esc(cap?.textContent || '')}">
      <label class="check"><input type="checkbox" name="remove"> ${esc(T.remove)}</label>`, (d) => $('#ei-alt', d).focus());
    if (!data) return;
    if (data.remove) { (fig || img).remove(); this.sync(); return; }
    img.setAttribute('alt', data.alt.trim());
    if (data.caption.trim()) {
      let host = fig;
      if (!host) { host = document.createElement('figure'); img.replaceWith(host); host.append(img); }
      let fc = host.querySelector('figcaption');
      if (!fc) { fc = document.createElement('figcaption'); host.append(fc); }
      fc.textContent = data.caption.trim();
    } else {
      cap?.remove();
    }
    this.sync();
  }
}

const rteData = (() => { try { return JSON.parse($('#rte-data')?.textContent || '{}'); } catch { return {}; } })();
const editors = $$('textarea[data-rte]').map((ta) => new RichEditor(ta, rteData));

/* ======================================================================
   Asistente SEO (vista de Google, puntuación, esquema de títulos)
   ====================================================================== */
function initSeo() {
  const panel = $('[data-seo-panel]');
  if (!panel) return;
  const f = (id) => document.getElementById(id);
  const fields = { title: f('p-title'), seoTitle: f('p-seo-title'), desc: f('p-seo-desc'), excerpt: f('p-excerpt'), slug: f('p-slug'), kw: f('p-kw'), cover: f('p-cover'), content: f('p-content') };
  const editor = editors.find((ed) => ed.ta === fields.content);
  const host = location.host.replace(/^localhost(:\d+)?$/, 'edwinortiz.net');
  const prefix = panel.dataset.prefix || '/';

  const update = () => {
    const title = (fields.seoTitle.value || fields.title.value).trim();
    const desc = (fields.desc.value || fields.excerpt?.value || '').trim();
    const slug = fields.slug.value.trim() || slugify(fields.title.value);
    $('[data-serp-title]', panel).textContent = title || '—';
    $('[data-serp-desc]', panel).textContent = desc || '—';
    $('[data-serp-url]', panel).textContent = `${host} › ${(prefix + slug).replace(/^\/+/, '').replace(/\//g, ' › ')}`;

    const root = editor ? editor.area : new DOMParser().parseFromString(fields.content.value, 'text/html').body;
    const text = root.innerText || root.textContent || '';
    const words = (text.match(/[\p{L}\p{N}]+/gu) || []).length;
    const kw = fold(fields.kw.value.trim());
    const has = (s) => kw !== '' && fold(s).includes(kw);
    const firstP = [...root.querySelectorAll('p')].find((p) => p.textContent.trim().length > 30)?.textContent || '';
    const h2s = [...root.querySelectorAll('h2')];
    const links = [...root.querySelectorAll('a[href]')].map((a) => a.getAttribute('href'));
    const internal = links.filter((h) => h.startsWith('/') || h.includes('edwinortiz.net')).length;
    const external = links.filter((h) => /^https?:/.test(h) && !h.includes('edwinortiz.net')).length;
    const imgs = [...root.querySelectorAll('img')];
    const checks = [
      [T.seo.title, title.length >= 50 && title.length <= 60],
      [T.seo.desc, desc.length >= 120 && desc.length <= 160],
      ...(kw ? [
        [T.seo.kwTitle, has(title)], [T.seo.kwDesc, has(desc)], [T.seo.kwFirst, has(firstP)],
        [T.seo.kwH2, h2s.some((h) => has(h.textContent))], [T.seo.kwSlug, slug.includes(slugify(kw))],
      ] : [[T.seo.noKw, false]]),
      [T.seo.words, words >= 600], [T.seo.h2, h2s.length >= 2], [T.seo.internal, internal >= 2], [T.seo.external, external >= 1],
      [T.seo.alt, imgs.every((i) => (i.getAttribute('alt') || '').trim() !== '')], [T.seo.cover, !!fields.cover?.value.trim()],
    ];
    const ok = checks.filter(([, pass]) => pass).length;
    const pct = Math.round((ok / checks.length) * 100);
    const ring = $('[data-score]', panel);
    ring.style.setProperty('--p', pct);
    ring.style.setProperty('--c', pct >= 80 ? 'var(--ok)' : pct >= 50 ? 'var(--warn)' : 'var(--err)');
    $('span', ring).textContent = pct;
    $('[data-checks]', panel).innerHTML = checks.map(([label, pass]) => `<li data-ok="${pass ? 1 : 0}">${esc(label)}</li>`).join('');

    const outline = $('[data-outline]');
    const heads = [...root.querySelectorAll('h2, h3, h4')];
    outline.innerHTML = heads.map((h, i) => `<li class="${h.tagName.toLowerCase()}"><button type="button" data-i="${i}">${esc(h.textContent.trim() || '…')}</button></li>`).join('');
    outline.onclick = (e) => {
      const b = e.target.closest('button[data-i]');
      if (!b || !editor) return;
      const h = editor.area.querySelectorAll('h2, h3, h4')[Number(b.dataset.i)];
      h?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };
  };
  const later = debounce(update, 250);
  panel.closest('form')?.addEventListener('input', later);
  document.addEventListener('eo:content', later);
  update();
}
initSeo();

/* ======================================================================
   Preguntas frecuentes: filas en lugar de "Pregunta | Respuesta"
   ====================================================================== */
for (const ta of $$('textarea[data-faq]')) {
  const wrap = document.createElement('div');
  wrap.className = 'faq-rep';
  const list = document.createElement('div');
  list.className = 'faq-rep__list';
  list.style.display = 'grid';
  list.style.gap = '10px';
  const add = document.createElement('button');
  add.type = 'button';
  add.className = 'btn btn--ghost btn--small faq-rep__add';
  add.innerHTML = `${icon('plus')}${esc(T.addFaq)}`;
  wrap.append(list, add);
  ta.hidden = true;
  const hint = ta.nextElementSibling?.classList.contains('hint') ? ta.nextElementSibling : null;
  if (hint) hint.hidden = true;
  ta.after(wrap);
  const label = ta.id ? $(`label[for="${ta.id}"]`) : null;

  const sync = () => {
    ta.value = $$('.faq-rep__item', list).map((row) => {
      const q = $('input', row).value.replace(/\|/g, '/').replace(/\s+/g, ' ').trim();
      const a = $('textarea', row).value.replace(/\s+/g, ' ').trim();
      return q && a ? `${q} | ${a}` : '';
    }).filter(Boolean).join('\n');
    ta.dispatchEvent(new Event('input', { bubbles: true }));
  };
  const row = (q = '', a = '') => {
    const n = list.children.length + 1;
    const item = document.createElement('div');
    item.className = 'faq-rep__item';
    item.innerHTML = `<div class="faq-rep__fields"><input class="field" aria-label="${esc(T.question)} ${n}" placeholder="${esc(T.question)}" value="${esc(q)}"><textarea class="field" aria-label="${esc(T.answer)} ${n}" placeholder="${esc(T.answer)}" rows="2">${esc(a)}</textarea></div>
      <div class="faq-rep__tools"><button type="button" class="icon-btn icon-btn--sm" data-up aria-label="${esc(T.up)}">${icon('arrow-up')}</button><button type="button" class="icon-btn icon-btn--sm" data-down aria-label="${esc(T.down)}">${icon('arrow-down')}</button><button type="button" class="icon-btn icon-btn--sm" data-del aria-label="${esc(T.remove)}">${icon('trash')}</button></div>`;
    item.addEventListener('input', sync);
    item.addEventListener('click', (e) => {
      if (e.target.closest('[data-del]')) { item.remove(); sync(); }
      if (e.target.closest('[data-up]') && item.previousElementSibling) { item.previousElementSibling.before(item); sync(); }
      if (e.target.closest('[data-down]') && item.nextElementSibling) { item.nextElementSibling.after(item); sync(); }
    });
    list.append(item);
    return item;
  };
  const fill = () => {
    list.replaceChildren();
    ta.value.split(/\n/).map((l) => l.split('|')).filter((p) => p[0]?.trim()).forEach(([q, ...a]) => row(q.trim(), a.join('|').trim()));
  };
  fill();
  ta.addEventListener('eo:refresh', fill);
  add.addEventListener('click', () => { $('input', row()).focus(); });
  if (label) label.htmlFor = '';
}

/* ======================================================================
   Borradores locales (recupera lo escrito si el navegador se cierra)
   ====================================================================== */
for (const form of $$('form[data-autosave]')) {
  const key = `eo-draft:${form.dataset.autosave}`;
  const named = () => $$('input[name], textarea[name], select[name]', form).filter((el) => !['hidden', 'file', 'submit'].includes(el.type) && el.name !== '_csrf');
  const snapshot = () => Object.fromEntries(named().map((el) => [el.name, el.type === 'checkbox' ? el.checked : el.value]));
  const initial = JSON.stringify(snapshot());
  const raw = store.get(key);
  if (raw) {
    try {
      const draft = JSON.parse(raw);
      if (draft && JSON.stringify(draft.values) !== initial && Date.now() - draft.at < 14 * 864e5) {
        const banner = document.createElement('div');
        banner.className = 'draft-banner';
        banner.innerHTML = `${icon('notice')}<p>${esc(T.draftFound)} <small class="muted">${new Date(draft.at).toLocaleString('es-CO')}</small></p><button type="button" class="btn btn--small" data-restore>${esc(T.restore)}</button><button type="button" class="btn btn--ghost btn--small" data-discard>${esc(T.discard)}</button>`;
        form.before(banner);
        $('[data-restore]', banner).addEventListener('click', () => {
          for (const el of named()) {
            if (!(el.name in draft.values)) continue;
            if (el.type === 'checkbox') el.checked = !!draft.values[el.name]; else el.value = draft.values[el.name];
            el.dispatchEvent(new Event('eo:refresh'));
          }
          form.dispatchEvent(new Event('input', { bubbles: true }));
          banner.remove();
        });
        $('[data-discard]', banner).addEventListener('click', () => { store.del(key); banner.remove(); });
      } else {
        store.del(key);
      }
    } catch { store.del(key); }
  }
  form.addEventListener('input', debounce(() => {
    const values = snapshot();
    if (JSON.stringify(values) !== initial) store.set(key, JSON.stringify({ at: Date.now(), values }));
  }, 1500));
  form.addEventListener('submit', (e) => { if (!e.submitter?.formTarget) store.del(key); });
}

initCommandPalette();
