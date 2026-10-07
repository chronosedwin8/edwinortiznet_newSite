// PIAR con IA: asistente por pasos con borrador local, ejemplo, progreso de la generación y detalles de la vista.
// Mejora progresiva: sin JavaScript el asistente es un formulario largo y la página de progreso se actualiza a mano.

const $ = (s, r = document) => r.querySelector(s);
const $$ = (s, r = document) => [...r.querySelectorAll(s)];
const DRAFT_KEY = 'eo-piar-draft-v1';

const store = {
  get() { try { return JSON.parse(localStorage.getItem(DRAFT_KEY) || 'null'); } catch { return null; } },
  set(v) { try { localStorage.setItem(DRAFT_KEY, JSON.stringify(v)); return true; } catch { return false; } },
  clear() { try { localStorage.removeItem(DRAFT_KEY); } catch { /* sin almacenamiento */ } },
};

/* ---------- Cuadros de texto que crecen ---------- */
function autogrow(el) {
  el.style.height = 'auto';
  el.style.height = `${Math.min(el.scrollHeight + 4, 640)}px`;
}
function initAutogrow(root = document) {
  $$('textarea[data-autogrow]', root).forEach((el) => {
    autogrow(el);
    el.addEventListener('input', () => autogrow(el));
  });
}

/* ---------- Progreso (capa al enviar y página "en preparación") ---------- */
function startProgress(box) {
  const messages = JSON.parse(box.dataset.messages || '[]');
  const msg = $('[data-progress-msg]', box);
  const bar = $('[data-progress-bar]', box);
  const time = $('[data-progress-time]', box);
  const started = Date.now();
  let i = 0;
  const tick = () => {
    const s = Math.floor((Date.now() - started) / 1000);
    time.textContent = `${Math.floor(s / 60)}:${String(s % 60).padStart(2, '0')}`;
    bar.style.width = `${Math.min(96, 4 + 92 * (1 - Math.exp(-s / 55)))}%`;
    if (s > 150 && box.dataset.labelSlow && msg.dataset.slow !== '1') {
      msg.dataset.slow = '1';
      msg.textContent = box.dataset.labelSlow;
    }
  };
  tick();
  setInterval(tick, 1000);
  setInterval(() => {
    if (msg.dataset.slow === '1' || messages.length < 2) return;
    msg.classList.add('is-fading');
    setTimeout(() => {
      i = (i + 1) % messages.length;
      msg.textContent = messages[i];
      msg.classList.remove('is-fading');
    }, 300);
  }, 7000);
}

function initPolling(box) {
  const url = box.dataset.statusUrl;
  startProgress(box);
  let wait = 3000;
  const poll = async () => {
    try {
      const res = await fetch(url, { headers: { Accept: 'application/json' }, cache: 'no-store', credentials: 'same-origin' });
      if (res.status === 404) { location.reload(); return; }
      const data = await res.json();
      if (data.status === 'done' || data.status === 'error') {
        location.replace(data.url || location.href);
        return;
      }
    } catch { /* sin conexión: se reintenta */ }
    wait = Math.min(wait + 500, 6000);
    setTimeout(poll, wait);
  };
  setTimeout(poll, wait);
}

/* ---------- Asistente ---------- */
function formFields(form) {
  const out = {};
  for (const el of form.elements) {
    if (!el.name || el.type === 'hidden' || el.type === 'file' || el.type === 'submit' || el.type === 'button' || el.hasAttribute('data-no-draft')) continue;
    if (el.type === 'checkbox') {
      if (el.name.endsWith('[]')) {
        out[el.name] ??= [];
        if (el.checked) out[el.name].push(el.value);
      } else {
        out[el.name] = el.checked;
      }
    } else if (el.type === 'radio') {
      if (el.checked) out[el.name] = el.value;
      else out[el.name] ??= '';
    } else {
      out[el.name] = el.value;
    }
  }
  return out;
}

function applyFields(form, map) {
  for (const el of form.elements) {
    if (!el.name || !(el.name in map) || el.type === 'hidden' || el.type === 'file' || el.hasAttribute('data-no-draft')) continue;
    const v = map[el.name];
    if (el.type === 'checkbox') {
      el.checked = Array.isArray(v) ? v.map(String).includes(el.value) : v === true || v === '1' || v === 1;
    } else if (el.type === 'radio') {
      el.checked = String(v ?? '') === el.value;
    } else {
      el.value = v ?? '';
    }
  }
}

/** Convierte el ejemplo anidado en nombres de campo: estudiante[nombre], condiciones[]… */
function flatten(obj, prefix = '', out = {}) {
  for (const [k, v] of Object.entries(obj)) {
    const name = prefix ? `${prefix}[${k}]` : k;
    if (Array.isArray(v)) out[`${name}[]`] = v.map(String);
    else if (v && typeof v === 'object') flatten(v, name, out);
    else out[name] = typeof v === 'boolean' ? v : String(v ?? '');
  }
  return out;
}

function hasContent(map, form) {
  return Object.entries(map).some(([name, v]) => {
    const el = form.elements[name];
    if (el && el.hasAttribute?.('data-keep')) return false;
    if (name === 'anio' || name === 'periodo' || name === 'nivel_apoyo') return false;
    return Array.isArray(v) ? v.length > 0 : v === true || (typeof v === 'string' && v.trim() !== '');
  });
}

function initWizard(root) {
  const form = $('[data-piar-form]', root);
  const steps = $$('.piar-step', form);
  const stepBtns = $$('[data-goto]', root);
  const prev = $('[data-prev]', root);
  const next = $('[data-next]', root);
  const countLabel = $('[data-count-label]', root);
  const status = $('[data-draft-status]', root);
  const banner = $('[data-draft-banner]', root);
  const overlay = $('[data-piar-overlay]');
  const submit = $('[data-submit]', form);
  const soporte = form.elements.soporte_clinico;
  const soporteWrap = $('#pf-soporte-wrap');
  let current = 0;

  root.classList.add('is-steps');
  form.noValidate = true;

  const label = (key, n) => (root.dataset[key] || '').replace(':n', n);

  const refresh = () => {
    $$('.piar-cgroup', form).forEach((g) => {
      const n = $$('input:checked', g).length;
      $('[data-count]', g).textContent = n ? String(n) : '';
    });
    if (soporte && soporteWrap) soporteWrap.hidden = !soporte.checked;
    $$('textarea[data-autogrow]', form).forEach(autogrow);
  };

  const show = (i, scroll = true) => {
    current = Math.max(0, Math.min(steps.length - 1, i));
    steps.forEach((s, n) => s.classList.toggle('is-current', n === current));
    stepBtns.forEach((b, n) => {
      if (n === current) b.setAttribute('aria-current', 'step'); else b.removeAttribute('aria-current');
      b.classList.toggle('is-done', n < current);
    });
    prev.hidden = current === 0;
    next.hidden = current === steps.length - 1;
    countLabel.textContent = (root.dataset.labelStep || '').replace(':n', current + 1).replace(':total', steps.length);
    if (current === steps.length - 1) renderReview();
    $$('textarea[data-autogrow]', steps[current]).forEach(autogrow);
    if (scroll) {
      const top = root.getBoundingClientRect().top + window.scrollY - 80;
      if (window.scrollY > top) window.scrollTo({ top, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
      const legend = $('.piar-step__title', steps[current]);
      legend?.setAttribute('tabindex', '-1');
      legend?.focus({ preventScroll: true });
    }
  };

  // Valida un paso: devuelve el primer campo con error (o null).
  const invalidIn = (i) => {
    const step = steps[i];
    $$('.piar-field-error', step).forEach((e) => e.remove());
    $$('[aria-invalid]', step).forEach((e) => e.removeAttribute('aria-invalid'));
    for (const el of $$('input, select, textarea', step)) {
      if (!el.checkValidity()) return el;
    }
    const group = $('[data-required-group]', step);
    if (group) {
      const any = $$('input[name="condiciones[]"]:checked', form).length > 0 || form.elements.otra_condicion.value.trim() !== '';
      group.classList.toggle('is-invalid', !any);
      if (!any) return group;
    }
    return null;
  };

  const flag = (el) => {
    if (el.matches?.('[data-required-group]')) {
      const p = document.createElement('p');
      p.className = 'piar-field-error';
      p.setAttribute('role', 'alert');
      p.textContent = $('.piar-label', el)?.textContent.replace(/\s+/g, ' ').trim() || '';
      el.prepend(p);
      el.querySelector('details')?.setAttribute('open', '');
      el.scrollIntoView({ block: 'center' });
      el.querySelector('input')?.focus({ preventScroll: true });
      return;
    }
    el.setAttribute('aria-invalid', 'true');
    el.reportValidity();
    el.focus();
  };

  // Resumen del último paso.
  const renderReview = () => {
    const box = $('[data-review]', form);
    if (!box) return;
    box.textContent = '';
    steps.slice(0, -1).forEach((step, n) => {
      const rows = [];
      $$('.form__row', step).forEach((row) => {
        const el = $('input:not([type=checkbox]):not([type=radio]), select, textarea', row);
        const lab = $('label', row);
        if (!el || !lab) return;
        const clone = lab.cloneNode(true);
        $$('.piar-opt-tag, .piar-req', clone).forEach((x) => x.remove());
        let value = el.tagName === 'SELECT' ? (el.value ? el.selectedOptions[0]?.textContent : '') : el.value.trim();
        const missing = el.required && !value;
        if (missing) value = root.dataset.labelEmpty || '';
        if (value) rows.push([clone.textContent.trim(), value, missing]);
      });
      $$('[data-review-group]', step).forEach((group) => {
        const picked = $$('input:checked', group).filter((i) => i.value !== '').map((i) => (i.closest('label')?.querySelector('.piar-opt__label, span')?.textContent || '').trim());
        const required = group.hasAttribute('data-required-group');
        const other = required ? form.elements.otra_condicion.value.trim() : '';
        if (picked.length) rows.push([group.dataset.reviewGroup, picked.join(' · '), false]);
        else if (required && !other) rows.push([group.dataset.reviewGroup, root.dataset.labelEmpty || '', true]);
      });
      if (soporte && step.contains(soporte) && soporte.checked) rows.push([$('label[for="' + soporte.id + '"]').textContent.trim(), '✓', false]);

      const wrap = document.createElement('div');
      wrap.className = 'piar-review__step';
      const head = document.createElement('div');
      head.className = 'piar-review__head';
      const title = document.createElement('p');
      title.className = 'piar-review__title';
      title.textContent = `${n + 1}. ${stepBtns[n]?.querySelector('.piar-stepper__label')?.textContent || ''}`;
      const edit = document.createElement('button');
      edit.type = 'button';
      edit.className = 'link-button';
      edit.textContent = root.dataset.labelEdit || '';
      edit.addEventListener('click', () => show(n));
      head.append(title, edit);
      wrap.append(head);
      const dl = document.createElement('dl');
      if (!rows.length) rows.push(['', root.dataset.labelEmpty || '', false]);
      rows.forEach(([k, v, missing]) => {
        const d = document.createElement('div');
        const dt = document.createElement('dt');
        const dd = document.createElement('dd');
        dt.textContent = k;
        dd.textContent = v.length > 220 ? `${v.slice(0, 220)}…` : v;
        if (missing) dd.className = 'is-missing';
        d.append(dt, dd);
        dl.append(d);
      });
      wrap.append(dl);
      box.append(wrap);
    });
  };

  // Borrador local.
  let timer = 0;
  const save = () => {
    const ok = store.set({ v: 1, t: Date.now(), fields: formFields(form) });
    if (ok && status) {
      const d = new Date();
      status.textContent = `${root.dataset.labelSaved || ''} · ${d.getHours()}:${String(d.getMinutes()).padStart(2, '0')}`;
    }
  };
  const queueSave = () => { clearTimeout(timer); timer = setTimeout(save, 600); };
  form.addEventListener('input', () => { queueSave(); refresh(); });
  form.addEventListener('change', () => { queueSave(); refresh(); });

  const draft = store.get();
  if (draft?.fields && hasContent(draft.fields, form)) {
    applyFields(form, draft.fields);
    if (banner) banner.hidden = false;
  }
  $('[data-draft-discard]', root)?.addEventListener('click', () => {
    store.clear();
    form.reset();
    if (banner) banner.hidden = true;
    if (status) status.textContent = '';
    refresh();
    show(0);
  });

  // Ejemplo.
  $('[data-piar-example]', root)?.addEventListener('click', () => {
    const script = $('[data-piar-example-json]');
    if (!script) return;
    if (hasContent(formFields(form), form) && !confirm(root.dataset.labelExample || '')) return;
    form.reset();
    applyFields(form, flatten(JSON.parse(script.textContent || '{}')));
    if (banner) banner.hidden = true;
    refresh();
    save();
    show(0);
  });

  // Navegación.
  next.addEventListener('click', () => {
    const bad = invalidIn(current);
    if (bad) { flag(bad); return; }
    show(current + 1);
  });
  prev.addEventListener('click', () => show(current - 1));
  stepBtns.forEach((b) => b.addEventListener('click', () => show(Number(b.dataset.goto))));

  form.addEventListener('submit', (ev) => {
    for (let i = 0; i < steps.length; i++) {
      const bad = invalidIn(i);
      if (bad) {
        ev.preventDefault();
        show(i, false);
        flag(bad);
        return;
      }
    }
    save();
    submit.disabled = true;
    submit.querySelector('span').textContent = root.dataset.labelSubmitting || '';
    if (overlay) {
      overlay.hidden = false;
      startProgress(overlay);
    }
  });
  // Si el navegador vuelve a esta página desde el historial, se reactiva el botón.
  window.addEventListener('pageshow', (e) => {
    if (e.persisted) { submit.disabled = false; if (overlay) overlay.hidden = true; }
  });

  refresh();
  show(0, false);
}

/* ---------- Vista del PIAR ---------- */
function initToc() {
  const links = $$('.piar-toc a');
  if (!links.length || !('IntersectionObserver' in window)) return;
  const byId = new Map(links.map((a) => [a.getAttribute('href').slice(1), a]));
  const io = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) {
        links.forEach((a) => a.classList.remove('is-active'));
        byId.get(en.target.id)?.classList.add('is-active');
      }
    });
  }, { rootMargin: '-20% 0px -70% 0px' });
  $$('.piar-section[id]').forEach((s) => io.observe(s));
}

/* ---------- Logo del perfil ---------- */
function initLogo(input) {
  const preview = $('[data-logo-preview]');
  input.addEventListener('change', () => {
    const file = input.files?.[0];
    if (!file) return;
    if (file.size > Number(input.dataset.max || 1048576)) {
      alert(input.dataset.labelSize || '');
      input.value = '';
      return;
    }
    if (preview) {
      const img = document.createElement('img');
      img.alt = '';
      img.src = URL.createObjectURL(file);
      preview.replaceChildren(img);
    }
  });
}

/* ---------- "Redactar con IA" en cada campo del editor ---------- */
const PREFS_KEY = 'eo-piar-assist-v1';
const prefs = {
  get() { try { return JSON.parse(localStorage.getItem(PREFS_KEY) || '{}') || {}; } catch { return {}; } },
  set(v) { try { localStorage.setItem(PREFS_KEY, JSON.stringify(v)); } catch { /* sin almacenamiento */ } },
};

function el(tag, attrs = {}, children = []) {
  const node = document.createElement(tag);
  Object.entries(attrs).forEach(([k, v]) => {
    if (k === 'text') node.textContent = v;
    else if (v !== false && v !== null && v !== undefined) node.setAttribute(k, v === true ? '' : v);
  });
  children.forEach((c) => node.append(c));
  return node;
}

function initAssist(form) {
  let cfg;
  try { cfg = JSON.parse(form.dataset.piarAssist); } catch { return; }
  const T = cfg.text;
  const csrf = $('input[name="_csrf"]', form)?.value || '';
  let dirty = false;
  form.addEventListener('input', () => { dirty = true; });
  form.addEventListener('submit', () => { dirty = false; });
  window.addEventListener('beforeunload', (ev) => {
    if (dirty) { ev.preventDefault(); ev.returnValue = T.unsaved; }
  });

  const select = (name, id, current) => {
    const s = el('select', { id, 'data-ai-opt': name });
    Object.entries(cfg.options[name]).forEach(([k, label]) => {
      const o = el('option', { value: k, text: label });
      if (k === current) o.selected = true;
      s.append(o);
    });
    return s;
  };

  // Datos de los demás campos del mismo elemento de una tabla (área, objetivo…), para dar contexto.
  const siblings = (field) => {
    const item = field.closest('.piar-edit__item');
    if (!item) return '';
    return $$('input[type="text"], textarea[data-ai-field], select:not([data-ai-opt])', item)
      .filter((f) => f !== field && f.value.trim() !== '')
      .map((f) => `${(item.querySelector(`label[for="${f.id}"]`)?.textContent || '').trim()}: ${f.value.trim()}`)
      .join('\n')
      .slice(0, 1500);
  };

  $$('textarea[data-ai-field]', form).forEach((field, n) => {
    const row = field.closest('.form__row') || field.parentElement;
    const label = row.querySelector(`label[for="${field.id}"]`);
    const toggle = el('button', { type: 'button', class: 'piar-ai-toggle', 'aria-expanded': 'false', 'aria-controls': `ai-${n}` }, [
      el('span', { 'aria-hidden': 'true', text: '✨' }), T.button,
    ]);
    (label || field).after(toggle);
    let panel = null;

    const build = () => {
      const p = prefs.get();
      const id = (k) => `ai-${n}-${k}`;
      const status = el('p', { class: 'piar-ai__status', role: 'status', 'aria-live': 'polite' });
      const instruction = el('textarea', { id: id('i'), rows: '3', maxlength: '1500', placeholder: T.placeholder });
      const actionSel = select('accion', id('a'), field.value.trim() === '' ? 'redactar' : 'mejorar');
      const toneSel = select('tono', id('t'), p.tono || 'formal');
      const langSel = select('lenguaje', id('l'), p.lenguaje || 'tecnico');
      const lenSel = select('extension', id('e'), p.extension || 'media');
      const generate = el('button', { type: 'button', class: 'btn btn--primary btn--sm' }, [T.generate]);
      const close = el('button', { type: 'button', class: 'btn btn--ghost btn--sm' }, [T.close]);
      const result = el('textarea', { id: id('r'), rows: '5' });
      const resultBox = el('div', { class: 'piar-ai__result', hidden: true }, [
        el('label', { class: 'piar-ai__label', for: result.id, text: T.result }), result,
        el('div', { class: 'piar-ai__actions' }, [
          el('button', { type: 'button', class: 'btn btn--primary btn--sm', 'data-do': 'replace' }, [T.replace]),
          el('button', { type: 'button', class: 'btn btn--ghost btn--sm', 'data-do': 'append' }, [T.append]),
          el('button', { type: 'button', class: 'btn btn--ghost btn--sm', 'data-do': 'retry' }, [T.retry]),
          el('button', { type: 'button', class: 'btn btn--ghost btn--sm', 'data-do': 'discard' }, [T.discard]),
        ]),
      ]);
      const pair = (key, control) => el('div', { class: 'piar-ai__opt' }, [el('label', { for: control.id, text: T[key] }), control]);
      panel = el('div', { class: 'piar-ai', id: `ai-${n}`, role: 'group', 'aria-label': T.title }, [
        el('label', { class: 'piar-ai__label', for: instruction.id, text: T.instruction }), instruction,
        el('div', { class: 'piar-ai__opts' }, [pair('accion', actionSel), pair('tono', toneSel), pair('lenguaje', langSel), pair('extension', lenSel)]),
        el('div', { class: 'piar-ai__actions' }, [generate, close]),
        status, resultBox,
      ]);
      field.after(panel);

      const run = async () => {
        const empty = field.value.trim() === '';
        if (instruction.value.trim() === '' && (actionSel.value === 'redactar' || empty)) {
          status.textContent = T.need;
          instruction.focus();
          return;
        }
        prefs.set({ tono: toneSel.value, lenguaje: langSel.value, extension: lenSel.value });
        const body = new FormData();
        const data = {
          _csrf: csrf, field: field.name, current: field.value, instruction: instruction.value,
          accion: actionSel.value, tono: toneSel.value, lenguaje: langSel.value, extension: lenSel.value, siblings: siblings(field),
        };
        Object.entries(data).forEach(([k, v]) => body.append(k, v));
        generate.disabled = true;
        panel.classList.add('is-busy');
        status.textContent = T.working;
        try {
          const res = await fetch(cfg.url, { method: 'POST', body, credentials: 'same-origin', headers: { Accept: 'application/json' } });
          const json = await res.json().catch(() => ({}));
          if (!res.ok || !json.ok) throw new Error(json.error || T.error);
          result.value = json.texto;
          resultBox.hidden = false;
          status.textContent = '';
          autogrow(result);
          result.focus();
        } catch (e) {
          status.textContent = e.message || T.error;
        } finally {
          generate.disabled = false;
          panel.classList.remove('is-busy');
        }
      };

      generate.addEventListener('click', run);
      instruction.addEventListener('keydown', (ev) => {
        if (ev.key === 'Enter' && (ev.ctrlKey || ev.metaKey)) run();
      });
      close.addEventListener('click', () => {
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      });
      result.addEventListener('input', () => autogrow(result));
      instruction.addEventListener('input', () => autogrow(instruction));
      resultBox.addEventListener('click', (ev) => {
        const what = ev.target.closest('[data-do]')?.dataset.do;
        if (!what) return;
        if (what === 'retry') { run(); return; }
        if (what !== 'discard') {
          const text = result.value.trim();
          const keep = what === 'append' && field.value.trim() !== '';
          field.value = keep ? `${field.value.replace(/\s+$/, '')}\n${text}` : text;
          field.dispatchEvent(new Event('input', { bubbles: true }));
          status.textContent = T.applied;
          field.classList.add('is-ai-applied');
          setTimeout(() => field.classList.remove('is-ai-applied'), 1600);
          field.focus();
        }
        resultBox.hidden = true;
        result.value = '';
      });
      return instruction;
    };

    toggle.addEventListener('click', () => {
      if (!panel) {
        const first = build();
        toggle.setAttribute('aria-expanded', 'true');
        first.focus();
        return;
      }
      const open = panel.hidden;
      panel.hidden = !open;
      toggle.setAttribute('aria-expanded', String(open));
      if (open) panel.querySelector('textarea')?.focus();
    });
  });
}

/* ---------- Arranque ---------- */
initAutogrow();
const wizard = $('[data-piar-wizard]');
if (wizard) initWizard(wizard);
const polling = $('.piar-progress[data-status-url]');
if (polling) initPolling(polling);
if ($('[data-piar-done]')) {
  store.clear();
  initToc();
}
const assist = $('form[data-piar-assist]');
if (assist) initAssist(assist);
const logo = $('[data-logo-input]');
if (logo) initLogo(logo);
