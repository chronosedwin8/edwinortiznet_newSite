import unittest
from ejercicio_mediana import mediana


class PruebasMediana(unittest.TestCase):
    def test_cantidad_impar(self):
        self.assertEqual(mediana([5, 1, 3]), 3)

    def test_un_solo_valor(self):
        self.assertEqual(mediana([4.5]), 4.5)

    def test_cantidad_par(self):
        # En una cantidad par de datos, la mediana es el promedio de los dos centrales
        self.assertEqual(mediana([1, 2, 3, 4]), 2.5)

    def test_par_sin_ordenar(self):
        self.assertEqual(mediana([4.0, 1.0, 3.0, 2.0]), 2.5)

    def test_lista_vacia(self):
        with self.assertRaises(ValueError):
            mediana([])

    def test_no_modifica_la_lista_original(self):
        datos = [3, 1, 2]
        mediana(datos)
        self.assertEqual(datos, [3, 1, 2])


if __name__ == "__main__":
    unittest.main()
