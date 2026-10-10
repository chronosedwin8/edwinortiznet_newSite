#!/usr/bin/env python3
"""Analizador de aprobaciones: lee el CSV exportado de tu formulario o lista y mide tiempos de respuesta.
Columnas: id,tipo,solicitante,aprobador,creada,respondida,estado  (fechas AAAA-MM-DD HH:MM; respondida vacia = pendiente)
Uso: python analizador_aprobaciones.py solicitudes.csv --sla Compra=48 Permiso=24 --ahora "2027-01-12 07:00"
Solo usa la biblioteca estandar de Python 3.8+. Calcula horas de calendario (no horas habiles)."""
import argparse
import csv
import statistics
from datetime import datetime

FMT = '%Y-%m-%d %H:%M'


def p90(valores):
    """Percentil 90 por el metodo del rango mas cercano."""
    v = sorted(valores)
    k = max(0, -(-len(v) * 90 // 100) - 1)  # ceil(0.9*n)-1
    return v[k]


def leer(ruta):
    filas = []
    with open(ruta, newline='', encoding='utf-8') as f:
        for r in csv.DictReader(f):
            r['creada'] = datetime.strptime(r['creada'], FMT)
            r['respondida'] = datetime.strptime(r['respondida'], FMT) if r['respondida'].strip() else None
            filas.append(r)
    return filas


def analizar(filas, sla, ahora):
    res = {'por_tipo': {}, 'por_aprobador': {}, 'vencidas': []}
    grupos = {}
    for r in filas:
        if r['respondida']:
            h = (r['respondida'] - r['creada']).total_seconds() / 3600
            grupos.setdefault(('tipo', r['tipo']), []).append(h)
            grupos.setdefault(('aprobador', r['aprobador']), []).append(h)
        else:
            h = (ahora - r['creada']).total_seconds() / 3600
            limite = sla.get(r['tipo'])
            if limite is not None and h > limite:
                res['vencidas'].append((r['id'], r['tipo'], r['aprobador'], round(h, 1), limite))
    for (clase, nombre), horas in grupos.items():
        res['por_tipo' if clase == 'tipo' else 'por_aprobador'][nombre] = {
            'n': len(horas), 'mediana': round(statistics.median(horas), 1), 'p90': round(p90(horas), 1)}
    return res


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('csv')
    ap.add_argument('--sla', nargs='*', default=[], help='Tipo=horas, p. ej. Compra=48')
    ap.add_argument('--ahora', default=datetime.now().strftime(FMT))
    a = ap.parse_args()
    sla = {k: float(v) for k, v in (x.split('=') for x in a.sla)}
    filas = leer(a.csv)
    res = analizar(filas, sla, datetime.strptime(a.ahora, FMT))
    print(f'Solicitudes: {len(filas)} | pendientes: {sum(1 for r in filas if not r["respondida"])}')
    print('\nPor tipo (horas de respuesta):')
    for k, v in sorted(res['por_tipo'].items()):
        print(f'  {k:<12} n={v["n"]:<3} mediana={v["mediana"]:<6} p90={v["p90"]}')
    print('\nPor aprobador (posibles cuellos de botella):')
    for k, v in sorted(res['por_aprobador'].items(), key=lambda x: -x[1]['mediana']):
        print(f'  {k:<14} n={v["n"]:<3} mediana={v["mediana"]:<6} p90={v["p90"]}')
    print('\nPendientes que ya superaron su plazo:')
    for v in res['vencidas'] or []:
        print(f'  {v[0]} ({v[1]}, {v[2]}): {v[3]} h de espera; plazo {v[4]:g} h')
    if not res['vencidas']:
        print('  ninguna')


if __name__ == '__main__':
    main()
