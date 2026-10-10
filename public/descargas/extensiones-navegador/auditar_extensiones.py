"""
Auditor básico de extensiones de Chrome o Edge (Python 3, solo biblioteca estándar).

Lee los archivos manifest.json de las extensiones instaladas en un perfil y muestra, para cada una:
nombre, versión, permisos «delicados», si puede actuar sobre TODOS los sitios web y una puntuación de riesgo.
No se conecta a internet, no cambia nada y no envía datos a ningún lado.

Es una ayuda para hacer un inventario: la puntuación mide cuánto PODRÍA hacer una extensión, no si es mala.
Una extensión con muchos permisos puede ser legítima (un gestor de contraseñas los necesita) y una con pocos puede ser un problema.

Uso:  python auditar_extensiones.py [ruta_a_la_carpeta_Extensions]
      Sin ruta, busca la carpeta del perfil «Default» de Chrome y de Edge en Windows.
"""
import json
import os
import sys

DELICADOS = {
    "cookies": 3, "history": 3, "webRequest": 3, "webRequestBlocking": 3, "debugger": 4, "nativeMessaging": 3,
    "clipboardRead": 3, "clipboardWrite": 1, "tabs": 2, "management": 3, "downloads": 2, "proxy": 4,
    "privacy": 2, "scripting": 2, "declarativeNetRequest": 1, "storage": 0, "activeTab": 0, "alarms": 0,
}
TODOS_LOS_SITIOS = {"<all_urls>", "*://*/*", "http://*/*", "https://*/*"}


def texto_localizado(carpeta, valor):
    """Resuelve nombres como __MSG_appName__ leyendo _locales."""
    if not (isinstance(valor, str) and valor.startswith("__MSG_")):
        return valor
    clave = valor[6:-2]
    for idioma in ("es", "es_419", "en", "en_US"):
        ruta = os.path.join(carpeta, "_locales", idioma, "messages.json")
        if os.path.exists(ruta):
            try:
                datos = json.load(open(ruta, encoding="utf-8"))
                for k, v in datos.items():
                    if k.lower() == clave.lower():
                        return v.get("message", valor)
            except Exception:
                pass
    return valor


def evaluar(carpeta):
    with open(os.path.join(carpeta, "manifest.json"), encoding="utf-8-sig") as f:
        m = json.load(f)
    perms = [p for p in m.get("permissions", []) if isinstance(p, str)]
    hosts = [h for h in m.get("host_permissions", []) if isinstance(h, str)]
    hosts += [h for p in perms for h in [p] if "://" in p or p == "<all_urls>"]
    hosts += [h for cs in m.get("content_scripts", []) for h in cs.get("matches", [])]
    todos = any(h in TODOS_LOS_SITIOS for h in hosts)
    delicados = sorted({p for p in perms if DELICADOS.get(p, 0) >= 2})
    puntos = sum(DELICADOS.get(p, 0) for p in perms) + (4 if todos else 0)
    nivel = "ALTO" if puntos >= 9 else "MEDIO" if puntos >= 4 else "BAJO"
    return {"nombre": texto_localizado(carpeta, m.get("name", "?")), "version": m.get("version", "?"), "mv": m.get("manifest_version"),
            "todos": todos, "delicados": delicados, "puntos": puntos, "nivel": nivel}


def buscar(raiz):
    for id_ext in sorted(os.listdir(raiz)):
        base = os.path.join(raiz, id_ext)
        if not os.path.isdir(base):
            continue
        versiones = sorted(d for d in os.listdir(base) if os.path.exists(os.path.join(base, d, "manifest.json")))
        if versiones:
            yield id_ext, os.path.join(base, versiones[-1])


def main(raiz):
    filas = []
    for id_ext, carpeta in buscar(raiz):
        try:
            r = evaluar(carpeta)
            r["id"] = id_ext
            filas.append(r)
        except Exception as e:
            print(f"  (no se pudo leer {id_ext}: {type(e).__name__})")
    filas.sort(key=lambda r: -r["puntos"])
    print(f"{len(filas)} extensiones en {raiz}")
    for r in filas:
        print(f"  [{r['nivel']:5}] {r['puntos']:2} pts | {str(r['nombre'])[:34]:34} v{r['version']:<8} MV{r['mv']} | todos los sitios: {'SÍ' if r['todos'] else 'no':2} | {', '.join(r['delicados']) or '-'}")
    altos = sum(1 for r in filas if r["nivel"] == "ALTO")
    print(f"Resumen: {altos} de riesgo alto, {sum(1 for r in filas if r['todos'])} con acceso a todos los sitios.")


if __name__ == "__main__":
    if len(sys.argv) > 1:
        main(sys.argv[1])
    else:
        local = os.environ.get("LOCALAPPDATA", "")
        for nav in ("Google/Chrome", "Microsoft/Edge"):
            ruta = os.path.join(local, nav, "User Data", "Default", "Extensions")
            if os.path.isdir(ruta):
                main(ruta)
        if not local:
            print(__doc__)
