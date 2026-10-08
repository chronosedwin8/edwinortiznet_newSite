// Ficha de producto: carrusel de imágenes y botón de compra fijo en móvil.
// Sin JS la galería ya funciona (franja deslizable con scroll-snap y miniaturas que enlazan a cada imagen);
// aquí se añaden flechas, contador, teclado, miniatura activa y la ampliación en un <dialog>.
const carousel = document.querySelector('[data-pgallery]');
if (carousel) {
  const track = carousel.querySelector('[data-pgallery-track]');
  const slides = [...carousel.querySelectorAll('[data-pgallery-slide]')];
  const thumbs = [...carousel.querySelectorAll('[data-pgallery-thumb]')];
  const thumbList = thumbs[0]?.closest('ol, ul');
  const prev = carousel.querySelector('[data-pgallery-prev]');
  const next = carousel.querySelector('[data-pgallery-next]');
  const current = carousel.querySelector('[data-pgallery-current]');
  const status = carousel.querySelector('[data-pgallery-status]');
  const total = slides.length;
  let index = 0;

  const statusText = (i) => (carousel.dataset.labelStatus || '').replace(':n', String(i + 1)).replace(':total', String(total));
  const go = (i) => {
    const target = Math.max(0, Math.min(total - 1, i));
    track.scrollTo({ left: target * track.clientWidth });
    return target;
  };
  const setActive = (i, announce) => {
    index = i;
    if (current) current.textContent = String(i + 1);
    if (status && announce) status.textContent = statusText(i);
    if (prev) prev.disabled = i === 0;
    if (next) next.disabled = i === total - 1;
    thumbs.forEach((t, k) => t.setAttribute('aria-current', String(k === i)));
    // La miniatura activa queda a la vista dentro de su franja (sin mover la página).
    const thumb = thumbs[i]?.parentElement;
    if (thumbList && thumb) {
      const left = thumb.offsetLeft - thumbList.offsetLeft;
      if (left < thumbList.scrollLeft || left + thumb.offsetWidth > thumbList.scrollLeft + thumbList.clientWidth) {
        thumbList.scrollTo({ left: left - (thumbList.clientWidth - thumb.offsetWidth) / 2, behavior: 'smooth' });
      }
    }
  };

  if (total > 1) {
    let frame = 0;
    track.addEventListener('scroll', () => {
      cancelAnimationFrame(frame);
      frame = requestAnimationFrame(() => {
        const i = Math.round(track.scrollLeft / Math.max(1, track.clientWidth));
        if (i !== index) setActive(i, true);
      });
    }, { passive: true });
    prev?.addEventListener('click', () => go(index - 1));
    next?.addEventListener('click', () => go(index + 1));
    thumbs.forEach((t, k) => t.addEventListener('click', (e) => { e.preventDefault(); go(k); }));
    track.addEventListener('keydown', (e) => {
      const keys = { ArrowLeft: index - 1, ArrowRight: index + 1, Home: 0, End: total - 1 };
      if (!(e.key in keys) || e.altKey || e.ctrlKey || e.metaKey) return;
      e.preventDefault();
      go(keys[e.key]);
    });
    // Al cambiar el ancho (rotar el teléfono), conserva la imagen visible.
    window.addEventListener('resize', () => { track.scrollTo({ left: index * track.clientWidth, behavior: 'instant' }); }, { passive: true });
    setActive(0, false);
  }

  // Ampliación: la versión más grande de la imagen en un <dialog> (Esc o clic fuera para cerrar; flechas para cambiar).
  const zooms = [...carousel.querySelectorAll('[data-pgallery-zoom]')];
  let dialog = null;
  let shown = 0;
  const buildDialog = () => {
    const d = document.createElement('dialog');
    d.className = 'lightbox';
    const sprite = (carousel.querySelector('svg use') || document.querySelector('svg use'))?.getAttribute('href')?.split('#')[0] || '';
    const button = (name, label) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'lightbox__btn';
      b.setAttribute('aria-label', label);
      b.innerHTML = `<svg class="icon" aria-hidden="true" focusable="false"><use href="${sprite}#${name}"></use></svg>`;
      return b;
    };
    const img = document.createElement('img');
    img.className = 'lightbox__img';
    img.decoding = 'async';
    const bar = document.createElement('div');
    bar.className = 'lightbox__bar';
    const caption = document.createElement('p');
    caption.className = 'lightbox__caption';
    bar.append(caption);
    if (total > 1) {
      const p = button('chevron-left', carousel.dataset.labelPrev || '');
      const n = button('chevron-right', carousel.dataset.labelNext || '');
      p.addEventListener('click', () => show(shown - 1));
      n.addEventListener('click', () => show(shown + 1));
      bar.append(p, n);
    }
    const close = button('close', carousel.dataset.labelClose || '');
    close.addEventListener('click', () => d.close());
    bar.append(close);
    d.append(img, bar);
    d.addEventListener('click', (e) => { if (e.target === d) d.close(); });
    d.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') { e.preventDefault(); show(shown - 1); }
      if (e.key === 'ArrowRight') { e.preventDefault(); show(shown + 1); }
    });
    d.addEventListener('close', () => { go(shown); zooms[shown]?.focus({ preventScroll: true }); });
    document.body.append(d);
    return d;
  };
  const show = (i) => {
    shown = (i + total) % total;
    const link = zooms[shown];
    const source = link.querySelector('img');
    const img = dialog.querySelector('.lightbox__img');
    img.src = link.href;
    img.alt = source?.alt || '';
    dialog.querySelector('.lightbox__caption').textContent = source?.alt || '';
    dialog.setAttribute('aria-label', source?.alt || '');
  };
  zooms.forEach((link, k) => link.addEventListener('click', (e) => {
    if (typeof HTMLDialogElement !== 'function') return; // Navegadores muy antiguos: abre la imagen.
    e.preventDefault();
    dialog ??= buildDialog();
    show(k);
    dialog.showModal();
  }));
}

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
