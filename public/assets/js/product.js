// Ficha de producto: galería y botón de compra fijo en móvil.
const gallery = document.querySelector('[data-gallery]');
document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-gallery-show]');
  if (!btn || !gallery) return;
  const index = btn.dataset.galleryShow;
  gallery.querySelectorAll('[data-gallery-item]').forEach((fig) => { fig.hidden = fig.dataset.galleryItem !== index; });
  document.querySelectorAll('[data-gallery-show]').forEach((b) => b.setAttribute('aria-current', String(b === btn)));
});

const sticky = document.querySelector('[data-sticky-buy]');
const buyBox = document.getElementById('buy');
if (sticky && buyBox && 'IntersectionObserver' in window) {
  const io = new IntersectionObserver(([entry]) => {
    const show = !entry.isIntersecting && entry.boundingClientRect.top < 0;
    sticky.hidden = !show;
    document.body.classList.toggle('has-sticky-buy', show);
  });
  io.observe(buyBox);
}

// Producto con variantes (p. ej. la materia del kit): elegir una es obligatorio para comprar o agregar al carrito.
const variantForm = document.querySelector('[data-variant-form]');
if (variantForm) {
  const picker = variantForm.querySelector('.variant-picker');
  const error = variantForm.querySelector('[data-variant-error]');
  const radios = [...variantForm.querySelectorAll('input[name="items"]')];
  const addButton = variantForm.querySelector('[data-add-to-cart]');
  const showError = (show) => {
    error.hidden = !show;
    picker.classList.toggle('is-invalid', show);
    radios.forEach((r) => r.setAttribute('aria-invalid', String(show)));
  };
  const sync = () => {
    const checked = radios.find((r) => r.checked);
    if (addButton) {
      if (checked) {
        addButton.dataset.variant = checked.dataset.variant;
        addButton.dataset.variantLabel = checked.dataset.variantLabel;
      } else {
        delete addButton.dataset.variant;
        delete addButton.dataset.variantLabel;
      }
    }
    if (checked) showError(false);
  };
  const missing = () => {
    showError(true);
    picker.scrollIntoView({ behavior: 'smooth', block: 'center' });
    radios[0]?.focus({ preventScroll: true });
  };
  variantForm.addEventListener('change', sync);
  variantForm.addEventListener('eo:variant-missing', missing);
  // Envío sin elegir (incluido el botón fijo en móvil, que usa form="buy-form").
  variantForm.addEventListener('submit', (e) => {
    if (!radios.some((r) => r.checked)) { e.preventDefault(); missing(); }
  });
  radios[0]?.addEventListener('invalid', (e) => { e.preventDefault(); missing(); });
  sync();
}
