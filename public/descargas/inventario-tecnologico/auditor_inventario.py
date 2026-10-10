#!/usr/bin/env python3
"""Auditor de inventario tecnologico: revisa la calidad de los datos y la trazabilidad.
Entradas (CSV, UTF-8): inventario.csv (id,tipo,serie,compra,garantia_meses,ubicacion,responsable,estado)
                       movimientos.csv (fecha,id,tipo,destino,responsable)
Uso: python auditor_inventario.py inventario.csv movimientos.csv --fecha 2027-01-25
Solo biblioteca estandar de Python 3.8+. No modifica los archivos."""
import argparse
import calendar
import csv
from collections import Counter
from datetime import date

VIDA = {'Portátil': 4, 'Tableta': 3, 'Proyector': 5, 'Punto de acceso': 6, 'Impresora': 5, 'PC de escritorio': 5}  # años; editable


def sumar_meses(d, m):
    y = d.year + (d.month - 1 + m) // 12
    mes = (d.month - 1 + m) % 12 + 1
    return date(y, mes, min(d.day, calendar.monthrange(y, mes)[1]))


def leer(ruta):
    with open(ruta, newline='', encoding='utf-8') as f:
        return list(csv.DictReader(f))


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('inventario'); ap.add_argument('movimientos')
    ap.add_argument('--fecha', default=date.today().isoformat(), help='Fecha de revision AAAA-MM-DD')
    ap.add_argument('--aviso', type=int, default=60, help='Dias de aviso de garantia')
    a = ap.parse_args()
    hoy = date.fromisoformat(a.fecha)
    inv = leer(a.inventario); mov = leer(a.movimientos)
    hallazgos = []
    ids = [r['id'] for r in inv]
    for i, n in Counter(ids).items():
        if n > 1: hallazgos.append(('ALTO', f'ID repetido en el inventario: {i}'))
    for s, n in Counter(r['serie'] for r in inv if r['serie']).items():
        if n > 1: hallazgos.append(('ALTO', f'Serie duplicada: {s} ({n} filas)'))
    for r in inv:
        for campo in ('id', 'tipo', 'serie', 'compra', 'ubicacion', 'responsable', 'estado'):
            if not r.get(campo, '').strip(): hallazgos.append(('MEDIO', f'{r["id"] or "(sin id)"}: falta {campo}'))
    ultimo = {}
    for m in sorted(mov, key=lambda x: (x['fecha'], x['id'])):  # el ultimo de cada ID es su situacion actual
        ultimo[m['id']] = m
    for m in mov:
        if m['id'] not in ids: hallazgos.append(('MEDIO', f'Movimiento de un ID que no esta en el inventario: {m["id"]}'))
    contador = Counter()
    for r in inv:
        u = ultimo.get(r['id'])
        if not u:
            hallazgos.append(('MEDIO', f'{r["id"]}: sin movimientos registrados (no hay trazabilidad)')); continue
        if (u['destino'], u['responsable']) != (r['ubicacion'], r['responsable']):
            hallazgos.append(('ALTO', f'{r["id"]}: el inventario dice {r["ubicacion"]} / {r["responsable"]}, el ultimo movimiento ({u["fecha"]}, {u["tipo"]}) dice {u["destino"]} / {u["responsable"]}'))
        compra = date.fromisoformat(r['compra'])
        gar = sumar_meses(compra, int(r['garantia_meses']))
        if gar < hoy: contador['garantia vencida'] += 1
        elif (gar - hoy).days <= a.aviso:
            contador['garantia vence pronto'] += 1
            hallazgos.append(('BAJO', f'{r["id"]}: la garantia vence el {gar.isoformat()}'))
        if r['estado'] != 'Baja' and sumar_meses(compra, VIDA.get(r['tipo'], 5) * 12) <= hoy: contador['vida util cumplida (sin bajas)'] += 1
    print(f'Activos: {len(inv)} | movimientos: {len(mov)} | fecha de revision: {hoy}')
    print('Resumen:', dict(contador))
    orden = {'ALTO': 0, 'MEDIO': 1, 'BAJO': 2}
    for nivel, txt in sorted(hallazgos, key=lambda h: orden[h[0]]):
        print(f' - {nivel}: {txt}')
    if not hallazgos: print(' Sin hallazgos.')


if __name__ == '__main__':
    main()
