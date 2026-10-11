#!/usr/bin/env python3
"""
Medidor de homogeneidad de textos (edwinortiz.net).

Mide qué tan parecidos son entre sí los textos de un grupo (por ejemplo, las respuestas de un curso a la misma pregunta).
Solo usa la biblioteca estándar de Python (3.8 o superior). Sin argumentos, corre con dos grupos de ejemplo
(textos ficticios); con argumentos, lee carpetas con archivos .txt (un texto por archivo):

    python medidor_homogeneidad.py                      # ejemplo con datos ficticios
    python medidor_homogeneidad.py carpeta_a carpeta_b   # tus propios textos

Indicadores por grupo:
  - similitud media (Jaccard): promedio, sobre todos los pares de textos, de |palabras en común| / |palabras en total|,
    sin contar palabras vacías muy comunes. 0 = no comparten nada; 1 = idénticos.
  - diversidad de bigramas: bigramas distintos / bigramas totales del grupo (más alto = más variedad).
  - bigramas compartidos: cuántos bigramas distintos aparecen en la mitad o más de los textos.

Advertencias: es una medida simple, no un detector de IA. Un grupo con instrucciones muy cerradas tendrá textos parecidos
aunque los haya escrito cada persona. No pegues textos con datos personales de estudiantes en herramientas externas.
"""
import re
import sys
from itertools import combinations
from pathlib import Path

VACIAS = set("""a al algo ante con contra de del desde el en entre es esta este esto la las le les lo los me mi mis muy no o para pero por
porque que se si sin sobre su sus te tu un una uno unos unas y ya""".split())

EJEMPLO_A = [  # escritos con variedad
    "Lo que más me gusta es el patio de atrás, donde nos sentamos a comer las empanadas de doña Rosa. A veces llueve y nos toca correr.",
    "Mi profesor de física explica con ejemplos de fútbol y por eso entiendo. También me gusta la biblioteca porque huele a libro viejo.",
    "Del colegio extraño a mis amigos en las vacaciones. El timbre del descanso es mi sonido favorito, lo confieso.",
    "Me encanta el laboratorio aunque nunca nos dejan tocar nada. Una vez se nos quemó una pila y todo el curso se rió.",
    "En mi colegio hay un árbol gigante de mango donde hacemos las tareas. La coordinadora finge no vernos subir.",
    "Lo mejor son las tardes de teatro con la profe Marta, que nos hace gritar para perder la pena. Salgo ronco pero feliz.",
    "Me gusta la clase de matemáticas cuando resolvemos acertijos en grupo; cada quien lo ve distinto y se arma el debate.",
    "Vivo lejos, así que me gusta llegar temprano y ver cómo el vigilante barre la entrada mientras silba un vallenato.",
]
EJEMPLO_B = [  # con la misma plantilla
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que fomenta la colaboración entre estudiantes. Además, los docentes son muy comprometidos con nuestra formación integral.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que promueve el trabajo en equipo entre los estudiantes. Asimismo, los docentes están muy comprometidos con nuestra formación integral.",
    "Lo que más me gusta de mi colegio es su ambiente de aprendizaje, ya que fomenta la colaboración entre estudiantes. Por otro lado, los profesores son muy comprometidos con nuestra formación integral.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que fomenta la colaboración y el respeto entre los estudiantes. Además, los docentes tienen un gran compromiso con nuestra formación.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que fomenta la colaboración entre estudiantes. Adicionalmente, los docentes son muy comprometidos con la formación integral.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, pues fomenta la colaboración entre estudiantes. Además, los docentes son comprometidos con nuestra formación integral.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que fomenta la colaboración entre los estudiantes. Además, los docentes son muy comprometidos con nuestro desarrollo integral.",
    "Lo que más me gusta de mi colegio es el ambiente de aprendizaje, ya que fomenta la colaboración entre estudiantes. Igualmente, los docentes son muy comprometidos con nuestra formación integral.",
]


def palabras(texto):
    return re.findall(r"[a-záéíóúüñ]+", texto.lower())


def conjunto(texto):
    return {p for p in palabras(texto) if p not in VACIAS}


def bigramas(texto):
    p = palabras(texto)
    return list(zip(p, p[1:]))


def jaccard(a, b):
    union = a | b
    return len(a & b) / len(union) if union else 0.0


def medir(textos):
    conj = [conjunto(t) for t in textos]
    pares = list(combinations(range(len(textos)), 2))
    sim = sum(jaccard(conj[i], conj[j]) for i, j in pares) / len(pares)
    todos = [b for t in textos for b in bigramas(t)]
    div = len(set(todos)) / len(todos)
    por_texto = [set(bigramas(t)) for t in textos]
    cuenta = {}
    for s in por_texto:
        for b in s:
            cuenta[b] = cuenta.get(b, 0) + 1
    compartidos = sum(1 for c in cuenta.values() if c >= len(textos) / 2)
    return {'textos': len(textos), 'similitud_media': sim, 'diversidad_bigramas': div, 'bigramas_compartidos': compartidos}


def leer(carpeta):
    return [p.read_text(encoding='utf-8') for p in sorted(Path(carpeta).glob('*.txt'))]


def main(argv):
    if len(argv) == 0:
        grupos = [('Grupo A (escritos con variedad, ficticio)', EJEMPLO_A), ('Grupo B (misma plantilla, ficticio)', EJEMPLO_B)]
    else:
        grupos = [(c, leer(c)) for c in argv]
    for nombre, textos in grupos:
        if len(textos) < 2:
            print(f'{nombre}: se necesitan al menos 2 textos.')
            continue
        r = medir(textos)
        print(f"{nombre}: {r['textos']} textos | similitud media {r['similitud_media']:.3f} | "
              f"diversidad de bigramas {r['diversidad_bigramas']:.3f} | bigramas compartidos {r['bigramas_compartidos']}")


if __name__ == '__main__':
    main(sys.argv[1:])
