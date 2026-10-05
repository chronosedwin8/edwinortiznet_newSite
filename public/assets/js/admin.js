// Panel: contadores de caracteres SEO, pestañas ES/EN y confirmación al eliminar.
for (const out of document.querySelectorAll('output[data-count-for]')) {
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

for (const tabs of document.querySelectorAll('[data-tabs]')) {
  tabs.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-tab]');
    if (!btn) return;
    for (const b of tabs.querySelectorAll('[data-tab]')) {
      const active = b === btn;
      b.classList.toggle('is-active', active);
      b.setAttribute('aria-selected', String(active));
      document.getElementById(b.dataset.tab).hidden = !active;
    }
  });
}

document.addEventListener('submit', (e) => {
  const form = e.target.closest('form[data-confirm]');
  if (form && !window.confirm(form.dataset.confirm)) e.preventDefault();
});

// Aviso al salir con cambios sin guardar en los editores.
for (const form of document.querySelectorAll('form[data-editor]')) {
  let dirty = false;
  form.addEventListener('input', () => { dirty = true; });
  form.addEventListener('submit', (e) => { if (!e.submitter?.formTarget) dirty = false; });
  window.addEventListener('beforeunload', (e) => { if (dirty) e.preventDefault(); });
}
