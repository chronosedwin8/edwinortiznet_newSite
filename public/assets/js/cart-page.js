// /carrito/: pinta el carrito de localStorage con precios validados por el servidor.
const root = document.querySelector('[data-cart-page]');

async function render() {
  const cart = window.eoCart;
  if (!root || !cart) return;
  const locale = document.documentElement.dataset.locale === 'en' ? 'en' : 'es';
  const ids = cart.items().map((i) => i.id);
  const list = root.querySelector('[data-cart-page-items]');
  const empty = root.querySelector('[data-cart-page-empty]');
  const foot = root.querySelector('[data-cart-page-foot]');
  const checkout = root.querySelector('[data-cart-page-checkout]');
  list.replaceChildren();
  if (!ids.length) {
    empty.hidden = false; foot.hidden = true; checkout.hidden = true;
    return;
  }
  const res = await fetch('/api/carrito', {
    method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify({ lang: locale, items: ids }),
  });
  if (!res.ok) return;
  const data = await res.json();
  const fmt = new Intl.NumberFormat(locale === 'en' ? 'en-US' : 'es-CO', { style: 'currency', currency: data.currency, maximumFractionDigits: data.currency === 'COP' ? 0 : 2, minimumFractionDigits: 0 });
  for (const item of data.items) {
    const li = document.createElement('li');
    const a = Object.assign(document.createElement('a'), { href: item.url, textContent: item.title });
    const strong = document.createElement('strong');
    strong.textContent = fmt.format(locale === 'en' ? item.usd : item.cop);
    li.append(a, strong);
    list.append(li);
  }
  // Sincroniza el carrito local con lo que realmente se puede comprar.
  if (data.removed) cart.save(cart.items().filter((i) => data.items.some((v) => v.id === Number(i.id))));
  empty.hidden = data.items.length > 0;
  foot.hidden = data.items.length === 0;
  checkout.hidden = data.items.length === 0;
  root.querySelector('[data-cart-page-total]').textContent = data.total_label;
  checkout.href = cart.checkoutUrl(root.dataset.checkout);
}

document.addEventListener('eo:cart', render);
if (window.eoCart) render();
