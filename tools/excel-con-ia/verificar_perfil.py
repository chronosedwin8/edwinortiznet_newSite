# -*- coding: utf-8 -*-
"""
Prueba de la macro PerfilarDatos: calcula con pandas el mismo perfil que el módulo VBA
y lo compara con lo que Excel escribió (JSON exportado por build.ps1).

    python verificar_perfil.py datos-ejemplo.xlsx perfil_excel.json

Replica las reglas del módulo (tipo inferido, únicos, moda con desempate por orden
binario, percentiles lineales como PERCENTIL.INC, alertas) con configuración es-CO.
"""
from __future__ import annotations

import json
import math
import sys

import numpy as np
import pandas as pd

UMBRAL_VACIOS = 0.10
EPOCH = pd.Timestamp("1899-12-30")


def num_cstr(x: float) -> str:
    """CStr(Double) de VBA con coma decimal (es-CO)."""
    return f"{x:.15g}".replace(".", ",")


def num_texto(x: float) -> str:
    """NumTexto del módulo: #,##0 o #,##0.00 con separadores es-CO."""
    if x == int(x):
        s = f"{x:,.0f}"
    else:
        s = f"{x:,.2f}"
    return s.replace(",", "\0").replace(".", ",").replace("\0", ".")


def clasificar(v):
    """Devuelve (categoría, clave) como el módulo: None si está vacío."""
    if v is None or (isinstance(v, float) and math.isnan(v)):
        return None, None
    if isinstance(v, str):
        if v.strip() == "":
            return None, None
        return "txt", "s" + v
    if isinstance(v, (pd.Timestamp,)) or hasattr(v, "year"):
        serial = (pd.Timestamp(v) - EPOCH) / pd.Timedelta(days=1)
        return "fec", "d" + num_cstr(serial)
    if isinstance(v, (bool, np.bool_)):
        return "txt", "b" + str(v)
    return "num", "n" + num_cstr(float(v))


def parece_numero(s: str) -> bool:
    s = s.strip(" ")
    if not s or len(s) > 30:
        return False
    digitos = 0
    for c in s:
        if c.isdigit():
            digitos += 1
        elif c not in ".,-+$ %":
            return False
    return digitos > 0


def percentil(a, p):
    return float(np.percentile(np.array(a, dtype=float), p * 100, method="linear"))


def mostrar(clave: str) -> str:
    t, resto = clave[0], clave[1:]
    if t == "n":
        return num_texto(float(resto.replace(",", ".")))
    if t == "d":
        return (EPOCH + pd.Timedelta(days=float(resto.replace(",", ".")))).strftime("%d/%m/%Y")
    return resto


def perfil_columna(nombre, valores):
    nF = len(valores)
    vac = n_num = n_fec = n_txt = n_esp = n_numtxt = 0
    claves, textos, nums, fechas = [], [], [], []
    enteros = True
    for v in valores:
        cat, k = clasificar(v)
        if cat is None:
            vac += 1
            continue
        claves.append(k)
        if cat == "txt":
            n_txt += 1
            s = v if isinstance(v, str) else str(v)
            textos.append(s.strip(" ").lower())
            if s != s.strip(" "):
                n_esp += 1
            if parece_numero(s):
                n_numtxt += 1
        elif cat == "fec":
            n_fec += 1
            fechas.append((pd.Timestamp(v) - EPOCH) / pd.Timedelta(days=1))
        else:
            n_num += 1
            nums.append(float(v))
            if float(v) != int(float(v)):
                enteros = False
    nn = len(claves)
    cats = sum(1 for x in (n_num, n_fec, n_txt) if x > 0)
    if nn == 0:
        tipo = "Vacía"
    elif cats != 1:
        tipo = "Mixto"
    elif n_num:
        tipo = "Número"
    elif n_fec:
        tipo = "Fecha"
    else:
        tipo = "Texto"

    unicos = moda_n = 0
    moda = None
    if nn:
        orden = sorted(claves)
        unicos, racha, moda_n, moda = 1, 1, 1, orden[0]
        for a, b in zip(orden, orden[1:]):
            if b == a:
                racha += 1
            else:
                unicos += 1
                racha = 1
            if racha > moda_n:
                moda_n, moda = racha, b
    distintos_txt = len({k for k in claves if k[0] in "sb"})
    distintos_norm = len(set(textos))

    minimo = maximo = promedio = mediana = None
    atipicos, q1, q3, riq = 0, 0.0, 0.0, 0.0
    formato = 0
    if n_num > 0 and n_num >= n_fec and n_num >= n_txt:
        nums.sort()
        minimo, maximo = nums[0], nums[-1]
        promedio = sum(nums) / len(nums)
        mediana = percentil(nums, 0.5)
        formato = 1 if enteros else 2
        if len(nums) >= 10:
            q1, q3 = percentil(nums, 0.25), percentil(nums, 0.75)
            riq = q3 - q1
            if riq > 0:
                atipicos = sum(1 for x in nums if x < q1 - 1.5 * riq or x > q3 + 1.5 * riq)
    elif n_fec > 0 and n_fec >= n_txt:
        minimo, maximo = min(fechas), max(fechas)
        formato = 3

    alertas = []
    if nn == 0:
        alertas.append("columna vacía")
    if nF > 0 and nn > 0 and vac / nF > UMBRAL_VACIOS:
        alertas.append(">10 % vacíos")
    if cats > 1:
        partes = []
        if n_num:
            partes.append(f"{n_num:,}".replace(",", ".") + (" número" if n_num == 1 else " números"))
        if n_fec:
            partes.append(f"{n_fec:,}".replace(",", ".") + (" fecha" if n_fec == 1 else " fechas"))
        if n_txt:
            partes.append(f"{n_txt:,}".replace(",", ".") + (" texto" if n_txt == 1 else " textos"))
        alertas.append("tipos mezclados (" + ", ".join(partes) + ")")
    if n_numtxt > 0 and n_num > 0:
        alertas.append(f"números guardados como texto: {n_numtxt}")
    if nn >= 10 and unicos == nn and (tipo == "Texto" or (tipo == "Número" and enteros)):
        alertas.append("posible ID (todos distintos)")
    if n_esp:
        alertas.append(f"espacios sobrantes: {n_esp}")
    if distintos_norm > 0 and distintos_txt > distintos_norm:
        alertas.append(f"variantes de mayúsculas o espacios: {distintos_txt - distintos_norm}")
    if atipicos:
        alertas.append(f"valores atípicos (1,5×IQR): {atipicos}, fuera de {num_texto(q1 - 1.5 * riq)} a {num_texto(q3 + 1.5 * riq)}")
    if nn > 1 and unicos == 1:
        alertas.append("un solo valor")

    if nn == 0:
        frecuente = ""
    elif moda_n > 1:
        frecuente = f"{mostrar(moda)} ({moda_n})"
    else:
        frecuente = "(sin repetidos)"
    return {
        "Columna": nombre, "Tipo inferido": tipo, "Con dato": nn, "Vacíos": vac,
        "% vacíos": vac / nF if nF else 0, "Únicos": unicos, "Mínimo": minimo, "Máximo": maximo,
        "Promedio": promedio, "Mediana": mediana, "Más frecuente": frecuente, "Alertas": "; ".join(alertas),
    }


def perfil_hoja(ruta, hoja):
    df = pd.read_excel(ruta, sheet_name=hoja, dtype=object)
    # Solo la región contigua a A1 (como CurrentRegion): hasta la primera columna sin encabezado
    cols = []
    for c in df.columns:
        if str(c).startswith("Unnamed"):
            break
        cols.append(c)
    df = df[cols]
    filas = [list(r) for r in df.itertuples(index=False, name=None)]
    claves_filas = [tuple(clasificar(v)[1] or "" for v in r) for r in filas]
    vistos, duplicadas = set(), 0
    for k in claves_filas:
        if k in vistos:
            duplicadas += 1
        vistos.add(k)
    return {
        "filas": len(df), "columnas": len(cols), "duplicadas": duplicadas,
        "perfil": [perfil_columna(c, list(df[c])) for c in cols],
    }


def iguales(a, b):
    if a is None or a == "":
        return b is None or b == ""
    if isinstance(a, (int, float)) and isinstance(b, (int, float)):
        return math.isclose(a, b, rel_tol=1e-9, abs_tol=1e-9)
    return str(a) == str(b)


def main():
    ruta, json_excel = sys.argv[1], sys.argv[2]
    with open(json_excel, encoding="utf-8-sig") as f:
        excel = json.load(f)
    errores = 0
    for hoja, ex in excel.items():
        ref = perfil_hoja(ruta, hoja)
        for clave in ("filas", "columnas", "duplicadas"):
            if int(ex[clave]) != ref[clave]:
                errores += 1
                print(f"  {hoja}: {clave} Excel={ex[clave]} pandas={ref[clave]}")
        for fe, fr in zip(ex["perfil"], ref["perfil"]):
            for campo, vr in fr.items():
                ve = fe.get(campo)
                if not iguales(vr, ve):
                    errores += 1
                    print(f"  {hoja}/{fr['Columna']}/{campo}: Excel={ve!r} pandas={vr!r}")
        print(f"{hoja}: {ref['filas']} filas, {ref['columnas']} columnas, {ref['duplicadas']} duplicadas, "
              f"{len(ref['perfil']) * 12} valores comparados")
    print("PERFIL OK: Excel coincide con pandas" if errores == 0 else f"PERFIL CON {errores} DIFERENCIAS")
    sys.exit(1 if errores else 0)


if __name__ == "__main__":
    main()
