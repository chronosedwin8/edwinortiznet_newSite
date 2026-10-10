"""
Simulación: por qué una prueba pre/post sin grupo de comparación engaña (Python 3, solo biblioteca estándar).
Supuestos (ficticios y editables): nivel de los estudiantes ~ N(60, 12); error de medición de cada prueba ~ N(0, 6);
crecimiento natural en cuatro semanas: +4 puntos. Se asigna al azar a la herramienta o a la comparación.
Ejecuta: python simulacion-prueba-herramienta.py
"""
import random, statistics as st, math
random.seed(11)
def student(): return random.gauss(60, 12)           # nivel real
def test(true): return true + random.gauss(0, 6)       # medición con error
def run(n_per, effect=0.0, growth=4.0):
    # grupo A usa la herramienta, B no; asignación al azar; ambos crecen 'growth' por clase normal
    a_gain=[];b_gain=[]
    for _ in range(n_per):
        t=student(); pre=test(t); post=test(t+growth+effect); a_gain.append(post-pre)
    for _ in range(n_per):
        t=student(); pre=test(t); post=test(t+growth); b_gain.append(post-pre)
    return a_gain,b_gain
# 1) solo pre/post con la herramienta (sin efecto real): ¿cuántas veces 'mejora' >=3 puntos?
cnt=0;N=5000
for _ in range(N):
    a,_b=run(12,0.0); 
    if st.mean(a)>=3: cnt+=1
print('pre/post sin grupo de comparacion, efecto real 0: mejora media>=3 pts en', round(100*cnt/N,1),'% de las pruebas (12 estudiantes)')
# 2) con grupo de comparacion: diferencia de ganancias >=3 por azar
for n in (12,25,60):
    c=0
    for _ in range(N):
        a,b=run(n,0.0)
        if st.mean(a)-st.mean(b)>=3: c+=1
    print('con comparacion, n por grupo',n,': diferencia>=3 pts por azar en',round(100*c/N,1),'%')
# 3) potencia: efecto real de 5 puntos; ¿cuántas veces la diferencia observada >=3?
for n in (12,25,60):
    c=0
    for _ in range(N):
        a,b=run(n,5.0)
        if st.mean(a)-st.mean(b)>=3: c+=1
    print('efecto real 5, n',n,': se observa diferencia>=3 en',round(100*c/N,1),'%')
