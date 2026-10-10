#!/usr/bin/env python3
"""Auditor de dominio: revisa NS, MX, SPF, DMARC, CAA y DNSSEC con DNS sobre HTTPS (dns.google).
Solo lee registros publicos. Uso: python auditor_dominio.py ejemplo.edu.co otro.com
Requiere Python 3.8+ y conexion a internet. No modifica nada."""
import json
import sys
import urllib.parse
import urllib.request

DOH = 'https://dns.google/resolve'
TYPES = {'NS': 2, 'MX': 15, 'TXT': 16, 'DS': 43, 'CAA': 257}


def consulta(nombre, tipo):
    url = DOH + '?' + urllib.parse.urlencode({'name': nombre, 'type': tipo})
    req = urllib.request.Request(url, headers={'Accept': 'application/dns-json'})
    with urllib.request.urlopen(req, timeout=15) as r:
        datos = json.load(r)
    return [a['data'] for a in datos.get('Answer', []) if a.get('type') == TYPES[tipo]]


def txt(nombre):
    return [t.replace('" "', '').strip('"') for t in consulta(nombre, 'TXT')]


def contar_consultas_spf(spf):
    """Cuenta los mecanismos que obligan a consultar DNS (limite de 10 segun RFC 7208)."""
    n = 0
    for parte in spf.split()[1:]:
        p = parte.lstrip('+-~?').lower()
        if p.startswith(('include:', 'exists:', 'redirect=', 'ptr')) or p in ('a', 'mx') or p.startswith(('a:', 'a/', 'mx:', 'mx/')):
            n += 1
    return n


def revisar(dominio):
    hallazgos = []
    ns = consulta(dominio, 'NS')
    mx = consulta(dominio, 'MX')
    print(f'\n== {dominio} ==')
    print('NS :', ', '.join(sorted(ns)) or '(ninguno)')
    print('MX :', ', '.join(sorted(mx)) or '(ninguno)')
    if len(ns) < 2:
        hallazgos.append('ALTO: menos de dos servidores de nombres (NS); una falla deja el dominio sin resolver')
    spf = [t for t in txt(dominio) if t.lower().startswith('v=spf1')]
    if not spf:
        hallazgos.append('ALTO: no hay registro SPF')
    elif len(spf) > 1:
        hallazgos.append('ALTO: hay mas de un registro SPF (el resultado es un error permanente)')
    else:
        s = spf[0]
        print('SPF:', s)
        n = contar_consultas_spf(s)
        if n > 10:
            hallazgos.append(f'ALTO: el SPF requiere {n} consultas DNS (el limite es 10)')
        fin = s.split()[-1].lower() if s.split() else ''
        if fin == '+all' or fin == 'all':
            hallazgos.append('ALTO: SPF termina en +all (autoriza a cualquiera)')
        elif fin not in ('-all', '~all') and 'redirect=' not in s.lower():
            hallazgos.append('MEDIO: el SPF no termina en -all ni ~all')
    dm = [t for t in txt('_dmarc.' + dominio) if t.lower().startswith('v=dmarc1')]
    if not dm:
        hallazgos.append('ALTO: no hay registro DMARC')
    else:
        d = dm[0]
        print('DMARC:', d)
        pol = [x.split('=')[1].strip().lower() for x in d.split(';') if x.strip().lower().startswith('p=')]
        pol = pol[0] if pol else ''
        if pol == 'none':
            hallazgos.append('MEDIO: DMARC en p=none (solo monitorea; no protege contra suplantacion)')
        elif pol not in ('quarantine', 'reject'):
            hallazgos.append('ALTO: DMARC sin politica p= valida')
        if 'rua=' not in d.lower():
            hallazgos.append('BAJO: DMARC sin rua= (no recibes reportes)')
    if not consulta(dominio, 'CAA'):
        hallazgos.append('BAJO: sin registros CAA (cualquier autoridad podria emitir certificados)')
    if not consulta(dominio, 'DS'):
        hallazgos.append('BAJO: sin DNSSEC (DS) en la zona padre; evaluar si tu registrador y tu DNS lo soportan')
    if not hallazgos:
        print('Sin hallazgos.')
    for h in hallazgos:
        print(' -', h)
    return hallazgos


if __name__ == '__main__':
    if len(sys.argv) < 2:
        sys.exit('Uso: python auditor_dominio.py dominio1 [dominio2 ...]')
    for d in sys.argv[1:]:
        try:
            revisar(d.strip().lower())
        except Exception as e:  # red caida, dominio inexistente, etc.
            print(f'\n== {d} ==\nNo se pudo revisar: {e}')
