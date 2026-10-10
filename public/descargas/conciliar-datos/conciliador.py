#!/usr/bin/env python3
"""Conciliador de listados: compara un mismo dato en dos sistemas (por ejemplo, el sistema de gestion escolar y el aula virtual).
Entradas: dos CSV (UTF-8) con una columna llave comun y columnas de datos.
Uso: python conciliador.py a.csv b.csv --llave documento --campos nombre,correo,curso [--nombres A B]
Normaliza mayusculas, espacios y tildes antes de comparar, para no reportar diferencias que no lo son.
Reporta: solo en A, solo en B, conflictos por campo y llaves que difieren solo por ceros a la izquierda.
Solo biblioteca estandar de Python 3.8+. No modifica los archivos."""
import argparse
import csv
import sys
import unicodedata


def norm(v):
    v = unicodedata.normalize('NFKD', (v or '').strip())
    v = ''.join(c for c in v if not unicodedata.combining(c))
    return ' '.join(v.casefold().split())


def leer(ruta, llave):
    filas, repetidas = {}, []
    with open(ruta, newline='', encoding='utf-8-sig') as f:
        for r in csv.DictReader(f):
            k = (r.get(llave) or '').strip()
            if k in filas: repetidas.append(k)
            filas[k] = r
    return filas, repetidas


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('a'); ap.add_argument('b')
    ap.add_argument('--llave', required=True)
    ap.add_argument('--campos', required=True, help='Campos a comparar, separados por coma')
    ap.add_argument('--nombres', nargs=2, default=['A', 'B'])
    a = ap.parse_args()
    na, nb = a.nombres
    campos = [c.strip() for c in a.campos.split(',')]
    A, repA = leer(a.a, a.llave)
    B, repB = leer(a.b, a.llave)
    solo_a = sorted(set(A) - set(B)); solo_b = sorted(set(B) - set(A))
    # llaves que difieren solo por ceros a la izquierda
    ceros = []
    for ka in list(solo_a):
        for kb in list(solo_b):
            if ka.lstrip('0') == kb.lstrip('0') and ka != kb:
                ceros.append((ka, kb)); solo_a.remove(ka); solo_b.remove(kb); break
    conflictos = {c: [] for c in campos}
    iguales_tras_normalizar = 0
    for k in sorted(set(A) & set(B)):
        for c in campos:
            va, vb = (A[k].get(c) or '').strip(), (B[k].get(c) or '').strip()
            if va == vb: continue
            if norm(va) == norm(vb): iguales_tras_normalizar += 1
            else: conflictos[c].append((k, va, vb))
    print(f'{na}: {len(A)} filas | {nb}: {len(B)} filas | en ambos: {len(set(A) & set(B))}')
    if repA or repB: print(f'ALTO: llaves repetidas dentro de un archivo: {na}={sorted(set(repA))} {nb}={sorted(set(repB))}')
    print(f'Solo en {na} ({len(solo_a)}): {solo_a}')
    print(f'Solo en {nb} ({len(solo_b)}): {solo_b}')
    if ceros: print(f'Posible cero inicial perdido ({len(ceros)}): ' + ', '.join(f'{x} / {y}' for x, y in ceros))
    print(f'Diferencias que desaparecen al normalizar tildes, mayusculas y espacios: {iguales_tras_normalizar}')
    total = 0
    for c in campos:
        total += len(conflictos[c])
        print(f'Conflictos en "{c}": {len(conflictos[c])}')
        for k, va, vb in conflictos[c]: print(f'   {k}: {na}="{va}" | {nb}="{vb}"')
    print(f'Total de conflictos reales: {total}')


if __name__ == '__main__':
    main()
