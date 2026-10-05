// Pedido pendiente: consulta el estado cada 3 s y recarga cuando cambia.
const root = document.querySelector('[data-order]');
if (root && root.dataset.status === 'pending') {
  let tries = 0;
  const tick = async () => {
    tries++;
    try {
      const res = await fetch(root.dataset.statusUrl, { headers: { Accept: 'application/json' }, cache: 'no-store' });
      if (res.ok) {
        const data = await res.json();
        if (data.status && data.status !== 'pending') {
          location.replace(location.pathname);
          return;
        }
      }
    } catch { /* sin red: se reintenta */ }
    // Cada 3 s durante 10 minutos; luego cada 30 s.
    setTimeout(tick, tries < 200 ? 3000 : 30000);
  };
  setTimeout(tick, 3000);
}
