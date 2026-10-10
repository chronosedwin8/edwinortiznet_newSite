"""
Integración resiliente: demostración sin dependencias externas (Python 3.8+).

Simula un proveedor que envía eventos (webhooks) a tu sistema y muestra cuatro defensas:
  1. Idempotencia: un evento repetido se procesa una sola vez (se registra su id).
  2. Respuesta rápida: se guarda el evento y se confirma; el trabajo pesado va a una cola.
  3. Reintentos con espera exponencial y azar (jitter) para los fallos temporales.
  4. Cola de eventos fallidos (dead letter) y alerta cuando algo no se pudo procesar.

Todos los datos son ficticios. Ejecuta:  python integracion_resiliente.py
"""
import random
import sqlite3
import time

random.seed(7)  # resultados repetibles en la demostración

db = sqlite3.connect(":memory:")
db.executescript("""
CREATE TABLE procesados(evento_id TEXT PRIMARY KEY, procesado_en REAL);
CREATE TABLE fallidos(evento_id TEXT, motivo TEXT, intentos INT);
CREATE TABLE pagos(evento_id TEXT, pedido TEXT, valor INT);
""")
alertas = []


def alertar(mensaje):
    """En producción: correo, mensaje al equipo o sistema de monitoreo."""
    alertas.append(mensaje)
    print("  ALERTA:", mensaje)


def aplicar_pago(evento):
    """Trabajo real. Falla de forma temporal con el pedido 'P3' las dos primeras veces."""
    intentos[evento["id"]] = intentos.get(evento["id"], 0) + 1
    if evento["pedido"] == "P3" and intentos[evento["id"]] <= 2:
        raise ConnectionError("el sistema contable no respondió")
    if evento["pedido"] == "P5":
        raise ValueError("pedido inexistente en el sistema (error permanente)")
    db.execute("INSERT INTO pagos VALUES (?,?,?)", (evento["id"], evento["pedido"], evento["valor"]))


def con_reintentos(evento, maximo=4, base=0.01):
    """Reintenta solo errores temporales; los permanentes van directo a la cola de fallidos."""
    for n in range(1, maximo + 1):
        try:
            aplicar_pago(evento)
            return True
        except ConnectionError as e:  # temporal: vale la pena reintentar
            espera = base * (2 ** (n - 1)) + random.uniform(0, base)  # exponencial + jitter
            print(f"  intento {n} falló ({e}); espero {espera:.3f} s")
            time.sleep(espera)
            ultimo = str(e)
        except ValueError as e:  # permanente: reintentar no sirve
            db.execute("INSERT INTO fallidos VALUES (?,?,?)", (evento["id"], str(e), n))
            alertar(f"evento {evento['id']} a cola de fallidos: {e}")
            return False
    db.execute("INSERT INTO fallidos VALUES (?,?,?)", (evento["id"], ultimo, maximo))
    alertar(f"evento {evento['id']} agotó {maximo} intentos: {ultimo}")
    return False


def recibir(evento):
    """Punto de entrada del webhook: idempotente."""
    try:
        db.execute("INSERT INTO procesados VALUES (?,?)", (evento["id"], time.time()))
    except sqlite3.IntegrityError:
        print(f"{evento['id']}: duplicado, se ignora (ya procesado)")
        return
    print(f"{evento['id']}: nuevo, se procesa")
    con_reintentos(evento)


intentos = {}
entrega = [  # el proveedor puede enviar el mismo evento más de una vez y fuera de orden
    {"id": "evt_1", "pedido": "P1", "valor": 120000},
    {"id": "evt_2", "pedido": "P2", "valor": 80000},
    {"id": "evt_1", "pedido": "P1", "valor": 120000},  # duplicado
    {"id": "evt_3", "pedido": "P3", "valor": 50000},   # fallo temporal
    {"id": "evt_2", "pedido": "P2", "valor": 80000},   # duplicado
    {"id": "evt_5", "pedido": "P5", "valor": 30000},   # fallo permanente
]
for e in entrega:
    recibir(e)

print()
print("Pagos aplicados:", db.execute("SELECT COUNT(*), SUM(valor) FROM pagos").fetchone())
print("Eventos fallidos:", db.execute("SELECT evento_id, motivo FROM fallidos").fetchall())
print("Alertas enviadas:", len(alertas))
