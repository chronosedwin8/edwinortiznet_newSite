"""
Monitor básico de disponibilidad y latencia (Python 3, solo biblioteca estándar).

Hace N comprobaciones HTTP a una dirección, mide el tiempo de respuesta y calcula:
disponibilidad, mediana y percentil 95 de la latencia, y alerta si hay fallos consecutivos.
Es una demostración: para producción usa un servicio de monitoreo con varias ubicaciones y notificaciones reales.

Uso:  python monitor_basico.py https://tu-sitio.example/ [N] [segundos_entre_comprobaciones]
"""
import statistics
import sys
import time
import urllib.request
import urllib.error

FALLOS_PARA_ALERTA = 3
TIMEOUT = 5


def comprobar(url):
    t0 = time.perf_counter()
    try:
        with urllib.request.urlopen(url, timeout=TIMEOUT) as r:
            codigo = r.status
    except urllib.error.HTTPError as e:
        codigo = e.code
    except Exception as e:                      # sin conexión, tiempo agotado, DNS, certificado...
        return False, (time.perf_counter() - t0) * 1000, type(e).__name__
    ms = (time.perf_counter() - t0) * 1000
    return codigo < 400, ms, str(codigo)


def percentil(valores, p):
    v = sorted(valores)
    if not v:
        return float("nan")
    k = (len(v) - 1) * p / 100
    f = int(k)
    c = min(f + 1, len(v) - 1)
    return v[f] + (v[c] - v[f]) * (k - f)


def main(url, n=20, pausa=0.2):
    ok_n, latencias, seguidos, alertas = 0, [], 0, 0
    for i in range(n):
        ok, ms, detalle = comprobar(url)
        if ok:
            ok_n += 1
            latencias.append(ms)
            seguidos = 0
        else:
            seguidos += 1
            if seguidos == FALLOS_PARA_ALERTA:
                alertas += 1
                print(f"  ALERTA: {seguidos} fallos consecutivos ({detalle}) en {url}")
        time.sleep(pausa)
    disp = 100 * ok_n / n
    print(f"{url}")
    print(f"  comprobaciones: {n} | disponibilidad: {disp:.1f} % | alertas: {alertas}")
    if latencias:
        print(f"  latencia mediana: {statistics.median(latencias):.0f} ms | p95: {percentil(latencias, 95):.0f} ms")


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(__doc__)
        sys.exit(0)
    main(sys.argv[1], int(sys.argv[2]) if len(sys.argv) > 2 else 20, float(sys.argv[3]) if len(sys.argv) > 3 else 0.2)
