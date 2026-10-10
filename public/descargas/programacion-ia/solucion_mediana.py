"""Solución comentada del ejercicio de la mediana (no la abras antes de intentarlo)."""


def mediana(valores):
    if not valores:                      # caso borde: sin datos no hay mediana
        raise ValueError("La lista no puede estar vacía")
    ordenados = sorted(valores)          # sorted devuelve una copia: no se modifica la lista original
    n = len(ordenados)
    medio = n // 2
    if n % 2 == 1:                       # cantidad impar: el valor central
        return ordenados[medio]
    return (ordenados[medio - 1] + ordenados[medio]) / 2   # cantidad par: promedio de los dos centrales
