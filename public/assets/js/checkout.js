// Pago: si se llega sin ?items= y hay carrito en localStorage, se usa ese carrito.
const page = document.querySelector('[data-checkout-page]');
if (page && page.dataset.hasItems === '0' && !new URLSearchParams(location.search).has('items')) {
  const locale = document.documentElement.dataset.locale === 'en' ? 'en' : 'es';
  try {
    const items = JSON.parse(localStorage.getItem(`eo-cart-${locale}`) || '[]');
    // Cada línea es "id" o "id:variante" (la materia del kit, por ejemplo).
    const ids = items.filter((i) => Number(i.id) > 0).map((i) => (i.variant ? `${Number(i.id)}:${i.variant}` : String(Number(i.id))));
    if (ids.length) location.replace(`${location.pathname}?items=${encodeURIComponent(ids.join(','))}`);
  } catch { /* sin almacenamiento */ }
}

// Tras enviar el pago se vacía el carrito local (el pedido ya quedó creado en el servidor).
page?.querySelector('form.checkout')?.addEventListener('submit', (e) => {
  const form = e.currentTarget;
  if (!form.checkValidity()) return;
  const locale = document.documentElement.dataset.locale === 'en' ? 'en' : 'es';
  try { localStorage.removeItem(`eo-cart-${locale}`); } catch { /* */ }
  document.cookie = 'eo_cart=; Path=/; Max-Age=0';
});
