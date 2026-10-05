// Tienda: filtros por perfil y precio sin recargar; la URL se actualiza (?perfil=docente&precio=20-40).
const root = document.querySelector('[data-shop]');
if (root) {
  const grid = root.querySelector('[data-shop-grid]');
  const empty = root.querySelector('[data-shop-empty]');
  const count = root.querySelector('[data-shop-count]');
  const ranges = { 'hasta-20': [0, 20], '20-40': [20.01, 40], 'mas-de-40': [40.01, Infinity] };
  const cards = [...grid.querySelectorAll('.product-card')];
  const state = Object.fromEntries(new URLSearchParams(location.search));

  const apply = () => {
    let visible = 0;
    for (const card of cards) {
      const okAudience = !state.perfil || card.dataset.audience === state.perfil;
      const range = ranges[state.precio];
      const price = Number(card.dataset.price);
      const okPrice = !range || (price >= range[0] && price <= range[1]);
      card.hidden = !(okAudience && okPrice);
      if (!card.hidden) visible++;
    }
    empty.hidden = visible > 0;
    count.textContent = visible === 1 ? count.dataset.labelOne : count.dataset.labelMany.replace(':n', String(visible));
    root.querySelectorAll('[data-filter]').forEach((chip) => {
      chip.setAttribute('aria-current', String((state[chip.dataset.filter] || '') === chip.dataset.value));
    });
  };

  root.addEventListener('click', (e) => {
    const chip = e.target.closest('[data-filter]');
    if (!chip) return;
    e.preventDefault();
    if (chip.dataset.value) state[chip.dataset.filter] = chip.dataset.value; else delete state[chip.dataset.filter];
    const qs = new URLSearchParams(state).toString();
    history.replaceState(null, '', location.pathname + (qs ? `?${qs}` : ''));
    apply();
  });
}
