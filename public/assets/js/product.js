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
