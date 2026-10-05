// Artículo: barra de progreso de lectura y resaltado de la tabla de contenido.
const body = document.querySelector('[data-article-body]');
const bar = document.querySelector('[data-progress]');

if (body && bar) {
  let ticking = false;
  const update = () => {
    const rect = body.getBoundingClientRect();
    const total = rect.height - innerHeight * 0.6;
    const done = Math.min(1, Math.max(0, -rect.top / (total > 0 ? total : 1)));
    bar.style.transform = `scaleX(${done})`;
    ticking = false;
  };
  addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
  update();
}

const tocLinks = [...document.querySelectorAll('.toc a[href^="#"]')];
if (tocLinks.length && 'IntersectionObserver' in window) {
  const byId = new Map(tocLinks.map((a) => [decodeURIComponent(a.hash.slice(1)), a]));
  const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue;
      tocLinks.forEach((a) => a.removeAttribute('aria-current'));
      byId.get(entry.target.id)?.setAttribute('aria-current', 'true');
    }
  }, { rootMargin: '0px 0px -70% 0px' });
  byId.forEach((_, id) => { const h = document.getElementById(id); if (h) io.observe(h); });
}
// En pantallas pequeñas la tabla de contenido empieza cerrada.
const toc = document.querySelector('.toc__details');
if (toc && matchMedia('(max-width: 1099px)').matches) toc.open = false;
