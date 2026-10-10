"""
Anonimizador básico de texto antes de usar una herramienta de IA (Python 3, solo biblioteca estándar).

Sustituye por marcadores: correos, teléfonos, números de documento largos, fechas de nacimiento tipo dd/mm/aaaa
y los nombres que tú le indiques en el archivo de nombres. Es una AYUDA, no una garantía: no detecta todo
(apodos, direcciones, datos indirectos que identifican a alguien) y reemplazar un nombre no equivale a anonimizar.
Revisa SIEMPRE el resultado a mano antes de pegarlo.

Uso:  python anonimizar_texto.py texto.txt [nombres.txt]      (nombres.txt: un nombre por línea)
"""
import re
import sys

PATRONES = [
    (re.compile(r"[\w.+-]+@[\w-]+\.[\w.-]+"), "[CORREO]"),
    (re.compile(r"\b\d{1,2}/\d{1,2}/\d{4}\b"), "[FECHA]"),
    (re.compile(r"\b(?:\+?57[ -]?)?3\d{2}[ -]?\d{3}[ -]?\d{4}\b"), "[TELEFONO]"),
    (re.compile(r"\b\d{1,3}(?:\.\d{3}){2,3}\b|\b\d{8,10}\b"), "[DOCUMENTO]"),
]


def anonimizar(texto, nombres=()):
    resultado = texto
    for patron, marcador in PATRONES:      # primero correos, fechas, teléfonos y documentos
        resultado = patron.sub(marcador, resultado)
    for nombre in sorted(nombres, key=len, reverse=True):   # luego los nombres (los más largos primero)
        if nombre.strip():
            resultado = re.sub(re.escape(nombre.strip()), "[PERSONA]", resultado, flags=re.IGNORECASE)
    return resultado


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(__doc__)
        sys.exit(0)
    with open(sys.argv[1], encoding="utf-8") as f:
        texto = f.read()
    nombres = []
    if len(sys.argv) > 2:
        with open(sys.argv[2], encoding="utf-8") as f:
            nombres = [l.strip() for l in f if l.strip()]
    print(anonimizar(texto, nombres))
