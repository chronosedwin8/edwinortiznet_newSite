"""
Ejercicio de depuración: «código que parece correcto».
Una IA generó esta función de mediana para las notas de un curso. Parece correcta y funciona con los ejemplos
que se suelen probar primero. Tu tarea: ejecutar las pruebas (python -m unittest pruebas_mediana -v),
explicar POR QUÉ falla y corregirla. No cambies las pruebas.
"""


def mediana(valores):
    ordenados = sorted(valores)
    n = len(ordenados)
    return ordenados[n // 2]
