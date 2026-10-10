"""
Revisor de compatibilidad de un libro de Excel (.xlsx / .xlsm) sin abrir Excel (Python 3, solo biblioteca estándar).

Lee el archivo como lo que es (un ZIP de XML) y busca cosas que suelen dar problemas entre equipos:
  - funciones «nuevas» (guardadas con el prefijo _xlfn.), que dan #¿NOMBRE? en versiones antiguas de Excel;
  - vínculos a otros libros, conexiones de datos y macros (VBA);
  - hojas ocultas, rutas absolutas y metadatos (autor, carpeta donde se guardó).
Es una ayuda: no sustituye el Comprobador de compatibilidad de Excel ni probar el archivo en el equipo de destino.

Uso:  python revisar_compatibilidad_xlsx.py libro.xlsx [otro.xlsx ...]
"""
import re
import sys
import zipfile
from collections import Counter


def revisar(ruta):
    r = {"funciones": Counter(), "vinculos": 0, "conexiones": False, "macros": False, "ocultas": [], "rutas": 0}
    with zipfile.ZipFile(ruta) as z:
        nombres = z.namelist()
        r["macros"] = any(n.endswith("vbaProject.bin") for n in nombres)
        r["vinculos"] = sum(1 for n in nombres if n.startswith("xl/externalLinks/") and n.endswith(".xml"))
        r["conexiones"] = "xl/connections.xml" in nombres
        wb = z.read("xl/workbook.xml").decode("utf-8", "ignore")
        for m in re.finditer(r"<sheet [^>]*>", wb):
            tag = m.group(0)
            if re.search(r'state="(hidden|veryHidden)"', tag):
                r["ocultas"].append(re.search(r'name="([^"]+)"', tag).group(1))
        r["ruta_guardado"] = re.findall(r'absPath url="([^"]*)"', wb)
        core = z.read("docProps/core.xml").decode("utf-8", "ignore") if "docProps/core.xml" in nombres else ""
        r["autor"] = re.findall(r"<dc:creator>([^<]*)", core) + re.findall(r"<cp:lastModifiedBy>([^<]*)", core)
        for n in nombres:
            if n.startswith("xl/worksheets/") and n.endswith(".xml") or n in ("xl/workbook.xml",) or n.startswith("xl/externalLinks/_rels"):
                x = z.read(n).decode("utf-8", "ignore")
                for f in re.findall(r"_xlfn\.(?:_xlws\.)?([A-Z][A-Z0-9.]*)", x):
                    r["funciones"][f] += 1
                r["rutas"] += len(re.findall(r"[A-Za-z]:\\|file:///|\\\\\\\\", x))
    return r


def informe(ruta):
    r = revisar(ruta)
    print(ruta)
    print(f"  funciones recientes: {', '.join(f'{k} ({v})' for k, v in sorted(r['funciones'].items())) or 'ninguna'}")
    print(f"  vínculos a otros libros: {r['vinculos']} | conexiones de datos: {'sí' if r['conexiones'] else 'no'} | macros: {'sí' if r['macros'] else 'no'}")
    print(f"  hojas ocultas: {', '.join(r['ocultas']) or 'ninguna'} | referencias a rutas absolutas: {r['rutas']}")
    print(f"  autor y último en guardar: {', '.join(r['autor']) or 'sin dato'}")
    avisos = []
    if r["ruta_guardado"]:
        avisos.append("El archivo guarda la ruta de tu carpeta (" + r["ruta_guardado"][0] + "): puede revelar usuario y estructura de carpetas")
    if r["funciones"]:
        avisos.append("Usa funciones recientes: en versiones antiguas darán #¿NOMBRE?; confirma la versión mínima de cada una")
    if r["vinculos"]:
        avisos.append("Tiene vínculos a otros libros: se rompen si el otro archivo no está en la misma ruta")
    if r["macros"]:
        avisos.append("Tiene macros: Excel para la Web y Mac pueden comportarse distinto; revisa la política de macros del destino")
    if r["ocultas"]:
        avisos.append("Hay hojas ocultas: pueden contener datos que no quieres compartir")
    for a in avisos:
        print("  ! " + a)
    if not avisos:
        print("  Sin señales de incompatibilidad en esta revisión.")


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(__doc__)
        sys.exit(0)
    for archivo in sys.argv[1:]:
        informe(archivo)
