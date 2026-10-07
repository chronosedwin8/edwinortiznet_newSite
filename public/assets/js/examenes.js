// Generador de exámenes con IA: asistente por pasos con borrador local, contadores, totales en vivo, progreso de la
// generación, editor (vista previa de fórmulas y preguntas con IA) y detalles del simulador.
// Mejora progresiva: sin JavaScript, el asistente es un formulario largo y todo lo esencial funciona con formularios.

const $ = (s, r = document) => r.querySelector(s);
const $$ = (s, r = document) => [...r.querySelectorAll(s)];
const csrf = () => $('input[name="_csrf"]')?.value || '';

const store = (key) => ({
  get() { try { return JSON.parse(localStorage.getItem(key) || 'null'); } catch { return null; } },
  set(v) { try { localStorage.setItem(key, JSON.stringify(v)); return true; } catch { return false; } },
  clear() { try { localStorage.removeItem(key); } catch { /* sin almacenamiento */ } },
});

/* ---------- Cuadros que crecen y contadores ---------- */
function autogrow(el) {
  el.style.height = 'auto';
  el.style.height = `${Math.min(el.scrollHeight + 4, 560)}px`;
}
function initAutogrow(root = document) {
  $$('textarea[data-autogrow]', root).forEach((el) => {
    autogrow(el);
    el.addEventListener('input', () => autogrow(el));
  });
}
function initCounters(root = document) {
  $$('[data-count]', root).forEach((el) => {
    const max = Number(el.getAttribute('maxlength') || 0);
    const out = document.getElementById(el.getAttribute('aria-describedby')?.split(' ').find((id) => id.endsWith('-c')) || '');
    if (!out || !max) return;
    const update = () => {
      const n = el.value.length;
      out.textContent = `${n.toLocaleString('es-CO')} / ${max.toLocaleString('es-CO')}`;
      out.classList.toggle('is-near', n > max * 0.9);
    };
    el.addEventListener('input', update);
    update();
  });
}

/* ---------- Materia: ejemplos y «otra» ---------- */
function initSubject(form) {
  const select = $('[data-ex-subject]', form);
  if (!select) return;
  let examples = {};
  try { examples = JSON.parse($('[data-ex-examples]')?.textContent || '{}'); } catch { /* sin ejemplos */ }
  const other = $('[data-ex-other]', form);
  const topic = $('[data-ex-topic]', form);
  const context = $('[data-ex-context]', form);
  const update = () => {
    if (other) other.hidden = select.value !== 'otra';
    const ex = examples[select.value] || examples.matematicas;
    if (ex && topic) topic.placeholder = ex[0];
    if (ex && context) context.placeholder = ex[1];
  };
  select.addEventListener('change', update);
  update();
}

/* ---------- Tipos de pregunta, versiones y preguntas únicas ---------- */
function initCounts(form) {
  const inputs = $$('[data-type-count]', form);
  if (!inputs.length) return () => 0;
  const total = $('[data-ex-total]', form);
  const unique = $('[data-ex-unique]', form);
  const versions = $('[data-ex-versions]', form);
  const sum = () => inputs.reduce((n, el) => n + (el.disabled ? 0 : Math.max(0, Number(el.value) || 0)), 0);
  const refresh = () => {
    inputs.forEach((el) => el.closest('.ex-type')?.classList.toggle('is-on', Number(el.value) > 0));
    const n = sum();
    if (total) total.textContent = String(n);
    if (unique) {
      const mode = $('[data-ex-mode]:checked', form)?.value || 'barajar';
      const v = Number(versions?.value || 1);
      const u = mode === 'distintas' ? n * v : n;
      const max = Number(unique.dataset.max || 0);
      const over = max > 0 && u > max;
      unique.textContent = over
        ? unique.dataset.labelOver
        : (max > 0 ? unique.dataset.label.replace(':n', u).replace(':max', max) : unique.dataset.labelNomax.replace(':n', u));
      unique.classList.toggle('is-over', over);
      form.dataset.over = over ? '1' : '';
    }
    return n;
  };
  $$('[data-step]', form).forEach((btn) => btn.addEventListener('click', () => {
    const input = document.getElementById(btn.getAttribute('aria-controls'));
    if (!input || input.disabled) return;
    const max = Number(input.max || 99);
    input.value = String(Math.max(0, Math.min(max, (Number(input.value) || 0) + Number(btn.dataset.step))));
    input.dispatchEvent(new Event('input', { bubbles: true }));
  }));
  form.addEventListener('input', refresh);
  form.addEventListener('change', refresh);
  refresh();
  return sum;
}

/* ---------- Progreso ---------- */
function startProgress(box) {
  const messages = JSON.parse(box.dataset.messages || '[]');
  const msg = $('[data-progress-msg]', box);
  const bar = $('[data-progress-bar]', box);
  const time = $('[data-progress-time]', box);
  const started = Date.now();
  let i = 0;
  box.progress = 0;
  const tick = () => {
    const s = Math.floor((Date.now() - started) / 1000);
    time.textContent = `${Math.floor(s / 60)}:${String(s % 60).padStart(2, '0')}`;
    const guess = 4 + 92 * (1 - Math.exp(-s / 70));
    bar.style.width = `${Math.min(97, Math.max(guess, box.progress || 0))}%`;
    if (s > 200 && box.dataset.labelSlow && msg.dataset.slow !== '1') {
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
  }, 6500);
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
      if (typeof data.progress === 'number') box.progress = data.progress;
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
function fields(form) {
  const out = {};
  for (const el of form.elements) {
    if (!el.name || el.type === 'hidden' || el.type === 'submit' || el.type === 'button' || el.type === 'file') continue;
    if (el.type === 'checkbox') out[el.name] = el.checked;
    else if (el.type === 'radio') { if (el.checked) out[el.name] = el.value; } else out[el.name] = el.value;
  }
  return out;
}
function apply(form, map) {
  for (const el of form.elements) {
    if (!el.name || !(el.name in map) || el.type === 'hidden' || el.type === 'file') continue;
    const v = map[el.name];
    if (el.type === 'checkbox') el.checked = v === true;
    else if (el.type === 'radio') el.checked = String(v) === el.value;
    else el.value = v ?? '';
  }
}

function initWizard(root) {
  const form = $('[data-ex-form]', root);
  const steps = $$('.ex-step', form);
  const stepBtns = $$('[data-goto]', root);
  const prev = $('[data-prev]', root);
  const next = $('[data-next]', root);
  const countLabel = $('[data-count-label]', root);
  const banner = $('[data-draft-banner]', root);
  const overlay = $('[data-ex-overlay]');
  const submit = $('[data-submit]', form);
  const draft = store(root.dataset.draftKey || 'eo-examenes-draft');
  let current = 0;
  root.classList.add('is-steps');
  form.noValidate = true;
  const total = initCounts(form);

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
    if (current === steps.length - 1) review();
    $$('textarea[data-autogrow]', steps[current]).forEach(autogrow);
    if (scroll) {
      const top = root.getBoundingClientRect().top + window.scrollY - 80;
      if (window.scrollY > top) window.scrollTo({ top, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
      const legend = $('.ex-step__title', steps[current]);
      legend?.setAttribute('tabindex', '-1');
      legend?.focus({ preventScroll: true });
    }
  };

  const clearErrors = (step) => {
    $$('.ex-field-error', step).forEach((e) => e.remove());
    $$('[aria-invalid]', step).forEach((e) => e.removeAttribute('aria-invalid'));
  };
  const invalidIn = (i) => {
    const step = steps[i];
    clearErrors(step);
    for (const el of $$('input, select, textarea', step)) {
      if (el.closest('[hidden]')) continue;
      if (!el.checkValidity()) return el;
    }
    if (step.contains($('[data-type-count]', form)) && total() === 0) return $('[data-ex-types]', form);
    if (step.contains($('[data-ex-unique]', form)) && form.dataset.over === '1') return $('[data-ex-unique]', form);
    return null;
  };
  const flag = (el) => {
    if (el.matches?.('[data-ex-types], [data-ex-unique]')) {
      const p = document.createElement('p');
      p.className = 'ex-field-error';
      p.setAttribute('role', 'alert');
      p.textContent = el.matches('[data-ex-types]') ? root.dataset.labelTypes : el.textContent;
      el.after(p);
      el.scrollIntoView({ block: 'center' });
      return;
    }
    el.setAttribute('aria-invalid', 'true');
    el.reportValidity();
    el.focus();
  };

  const review = () => {
    const box = $('[data-review]', form);
    if (!box) return;
    box.textContent = '';
    steps.slice(0, -1).forEach((step, n) => {
      const rows = [];
      $$('.form__row', step).forEach((row) => {
        if (row.closest('[hidden]')) return;
        const el = $('input:not([type=checkbox]):not([type=radio]):not([type=number]), select, textarea', row);
        const lab = $('label', row);
        if (!el || !lab) return;
        const clone = lab.cloneNode(true);
        $$('.ex-req, .ex-opt-tag', clone).forEach((x) => x.remove());
        let value = el.tagName === 'SELECT' ? (el.value ? el.selectedOptions[0]?.textContent : '') : el.value.trim();
        const missing = el.required && !value;
        if (missing) value = root.dataset.labelEmpty || '';
        if (value) rows.push([clone.textContent.trim(), value, missing]);
      });
      const types = $$('[data-type-count]', step).filter((i) => Number(i.value) > 0)
        .map((i) => `${i.value} × ${(document.querySelector(`label[for="${i.id}"]`)?.textContent || '').trim()}`);
      if (types.length) rows.push(['', types.join(' · '), false]);
      $$('[data-ex-mode]:checked, .ex-paperopt input:checked', step).forEach((r) => {
        rows.push([r.closest('fieldset')?.querySelector('legend')?.textContent.trim() || '', (r.closest('label')?.querySelector('.ex-mode__title, .ex-paperopt__label')?.textContent || '').trim(), false]);
      });
      const unique = $('[data-ex-unique]', step);
      if (unique && unique.textContent) rows.push(['', unique.textContent, unique.classList.contains('is-over')]);
      const wrap = document.createElement('div');
      wrap.className = 'ex-review__step';
      const head = document.createElement('div');
      head.className = 'ex-review__head';
      const title = document.createElement('p');
      title.className = 'ex-review__title';
      title.textContent = `${n + 1}. ${stepBtns[n]?.querySelector('.ex-stepper__label')?.textContent || ''}`;
      const edit = document.createElement('button');
      edit.type = 'button';
      edit.className = 'link-button';
      edit.textContent = root.dataset.labelEdit || '';
      edit.addEventListener('click', () => show(n));
      head.append(title, edit);
      const dl = document.createElement('dl');
      if (!rows.length) rows.push(['', root.dataset.labelEmpty || '', false]);
      rows.forEach(([k, v, missing]) => {
        const d = document.createElement('div');
        const dt = document.createElement('dt');
        const dd = document.createElement('dd');
        dt.textContent = k;
        dd.textContent = v.length > 240 ? `${v.slice(0, 240)}…` : v;
        if (missing) dd.className = 'is-missing';
        d.append(dt, dd);
        dl.append(d);
      });
      wrap.append(head, dl);
      box.append(wrap);
    });
  };

  // Borrador local (no se usa si el asistente viene lleno desde «Duplicar»).
  let timer = 0;
  const save = () => draft.set({ v: 1, t: Date.now(), fields: fields(form) });
  form.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(save, 600); });
  form.addEventListener('change', () => { clearTimeout(timer); timer = setTimeout(save, 600); });
  const saved = draft.get();
  if (!root.hasAttribute('data-prefilled') && saved?.fields && String(saved.fields.tema || '').trim() !== '') {
    apply(form, saved.fields);
    if (banner) banner.hidden = false;
    form.dispatchEvent(new Event('change'));
  }
  $('[data-draft-discard]', root)?.addEventListener('click', () => {
    draft.clear();
    form.reset();
    if (banner) banner.hidden = true;
    form.dispatchEvent(new Event('change'));
    show(0);
  });

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
    draft.clear();
    submit.disabled = true;
    submit.querySelector('span').textContent = root.dataset.labelSubmitting || '';
    if (overlay) { overlay.hidden = false; startProgress(overlay); }
  });
  window.addEventListener('pageshow', (e) => {
    if (e.persisted) { submit.disabled = false; if (overlay) overlay.hidden = true; }
  });
  show(0, false);
}

/* ---------- PDF: aviso mientras se prepara ---------- */
function initPdfButtons() {
  $$('[data-ex-pdf]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const span = btn.querySelector('span');
      if (!span || btn.dataset.busy === '1') return;
      const old = span.textContent;
      btn.dataset.busy = '1';
      span.textContent = btn.dataset.labelBusy || old;
      setTimeout(() => { span.textContent = old; btn.dataset.busy = ''; }, 9000);
    });
  });
}

/* ---------- Confirmaciones ---------- */
function initConfirms() {
  $$('form[data-confirm]').forEach((f) => f.addEventListener('submit', (ev) => {
    if (!confirm(f.dataset.confirm)) ev.preventDefault();
  }));
}

/* ---------- Editor ---------- */
function initEditor(root) {
  const renderUrl = root.dataset.renderUrl;
  // Vista previa de fórmulas bajo cada campo marcado.
  $$('textarea[data-ex-preview]', root).forEach((field) => {
    const out = document.createElement('div');
    out.className = 'ex-livepreview';
    out.setAttribute('aria-live', 'polite');
    field.after(out);
    let timer = 0;
    let last = '';
    const run = async () => {
      const text = field.value;
      if (text === last) return;
      last = text;
      if (!/[$\\]/.test(text)) { out.textContent = ''; return; }
      const body = new FormData();
      body.append('_csrf', csrf());
      body.append('text', text);
      try {
        const res = await fetch(renderUrl, { method: 'POST', body, credentials: 'same-origin', headers: { Accept: 'application/json' } });
        const json = await res.json();
        if (json.ok) out.innerHTML = json.html; // HTML generado y escapado por el servidor
      } catch { out.textContent = root.dataset.labelPreviewError || ''; }
    };
    field.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(run, 900); });
    field.closest('details')?.addEventListener('toggle', () => { if (field.closest('details').open) run(); });
  });

  // Diálogo «Preguntas con IA» (agregar o reemplazar).
  const dialog = $('[data-ai-dialog]', root);
  if (!dialog || typeof dialog.showModal !== 'function') return;
  const form = $('[data-ai-form]', dialog);
  const title = $('[data-ai-title]', dialog);
  const status = $('[data-ai-status]', dialog);
  const slot = $('[data-ai-slot]', dialog);
  const countRow = $('[data-ai-count]', dialog);
  const typeSel = form.elements.type;
  const submit = $('[data-ai-submit]', dialog);
  let busy = false;
  $$('[data-ai-open]', root).forEach((btn) => btn.addEventListener('click', () => {
    const replace = btn.dataset.mode === 'replace';
    title.textContent = replace ? dialog.dataset.labelReplace : dialog.dataset.labelAdd;
    slot.value = replace ? btn.dataset.slot : '';
    countRow.hidden = replace;
    if (replace && btn.dataset.type) typeSel.value = btn.dataset.type;
    status.textContent = '';
    status.classList.remove('is-error');
    dialog.showModal();
    typeSel.focus();
  }));
  $('[data-ai-close]', dialog).addEventListener('click', () => { if (!busy) dialog.close(); });
  dialog.addEventListener('cancel', (ev) => { if (busy) ev.preventDefault(); });
  submit.addEventListener('click', async () => {
    if (busy) return;
    busy = true;
    dialog.classList.add('is-busy');
    submit.disabled = true;
    status.classList.remove('is-error');
    status.textContent = dialog.dataset.labelWorking || '';
    const body = new FormData(form);
    body.append('_csrf', csrf());
    try {
      const res = await fetch(dialog.dataset.url, { method: 'POST', body, credentials: 'same-origin', headers: { Accept: 'application/json' } });
      const json = await res.json().catch(() => ({}));
      if (!res.ok || !json.ok) throw new Error(json.error || dialog.dataset.labelError);
      location.href = json.url || location.href;
    } catch (e) {
      status.textContent = e.message || dialog.dataset.labelError;
      status.classList.add('is-error');
      busy = false;
      dialog.classList.remove('is-busy');
      submit.disabled = false;
    }
  });
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

/* ---------- Arranque ---------- */
initAutogrow();
initCounters();
initConfirms();
initPdfButtons();
$$('form').forEach((f) => { if ($('[data-ex-subject]', f)) initSubject(f); });
const wizard = $('[data-ex-wizard]');
if (wizard) initWizard(wizard);
const demo = $('form[data-ex-demo]');
if (demo) initCounts(demo);
const polling = $('.ex-progress[data-status-url]');
if (polling) initPolling(polling);
const editor = $('[data-ex-editor]');
if (editor) initEditor(editor);
const logo = $('[data-logo-input]');
if (logo) initLogo(logo);
