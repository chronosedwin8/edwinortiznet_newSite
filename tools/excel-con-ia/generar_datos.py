# -*- coding: utf-8 -*-
"""
Genera datos-ejemplo.xlsx: datos FICTICIOS para practicar «Excel con Inteligencia Artificial».

    python generar_datos.py [carpeta_salida]

Hojas:
  Inicio    instrucciones y fórmulas de ejemplo
  Ventas    pyme colombiana, ~800 filas con problemas de calidad a propósito
            (vacíos, tipos mezclados, espacios sobrantes, duplicados y atípicos)
  Notas     colegio: notas 1,0-5,0 por estudiante, área y periodo
  Encuesta  satisfacción de clientes con comentarios para clasificar con IA

Todo se genera con una semilla fija: ningún dato corresponde a personas reales.
"""
from __future__ import annotations

import random
import sys
from datetime import date, timedelta
from pathlib import Path

from openpyxl import Workbook
from openpyxl.styles import Alignment, Font, PatternFill
from openpyxl.utils import get_column_letter

SEMILLA = 2026
AZUL = "2350F0"

CIUDADES = [("Bogotá", 30), ("Medellín", 18), ("Cali", 12), ("Barranquilla", 11), ("Cartagena", 8),
            ("Bucaramanga", 7), ("Pereira", 5), ("Santa Marta", 4), ("Montería", 3), ("Sincelejo", 2)]
VENDEDORES = ["Laura Gómez", "Andrés Ríos", "Camila Herrera", "Julián Castro", "Valentina Ruiz",
              "Santiago Mejía", "Daniela Ortega", "Mateo Salazar"]
CANALES = [("Tienda física", 40), ("WhatsApp", 30), ("Sitio web", 20), ("Marketplace", 10)]
PRODUCTOS = [  # (producto, categoría, precio base COP, unidades típicas)
    ("Resma papel carta 500 h", "Papelería", 24900, 6),
    ("Cuaderno argollado 100 h", "Papelería", 12500, 8),
    ("Caja de lapiceros x12", "Papelería", 15800, 5),
    ("Marcadores borrables x4", "Papelería", 18200, 4),
    ("Mouse inalámbrico", "Tecnología", 45000, 2),
    ("Teclado USB", "Tecnología", 59900, 2),
    ("Memoria USB 64 GB", "Tecnología", 32000, 3),
    ("Audífonos Bluetooth", "Tecnología", 129000, 1),
    ("Cargador USB-C 20 W", "Tecnología", 54900, 2),
    ("Termo acero 1 L", "Hogar", 68000, 2),
    ("Lámpara LED de escritorio", "Hogar", 89900, 1),
    ("Organizador plástico", "Hogar", 27500, 3),
    ("Café molido 500 g", "Alimentos", 21900, 4),
    ("Panela pulverizada 1 kg", "Alimentos", 8900, 6),
    ("Chocolate de mesa 500 g", "Alimentos", 14500, 4),
]
COMENTARIOS_VENTA = [
    "Excelente atención, volveré a comprar", "Llegó rápido y bien empacado", "Buen precio",
    "El producto es de buena calidad", "Me atendieron por WhatsApp muy rápido", "Todo perfecto",
    "Demoraron en responder", "El envío tardó más de lo prometido", "Un poco caro",
    "La caja llegó golpeada", "No había el color que quería", "Me cobraron el domicilio dos veces",
    "Buena experiencia en general", "Recomendado", "Tuve que llamar varias veces",
    "Muy amables en la tienda", "El producto no era como en la foto", "Precio justo y entrega a tiempo",
]

# Comentarios de la encuesta por tema (la categoría NO se guarda: es lo que la IA debe clasificar)
ENCUESTA = {
    "Atención": [
        "La asesora fue muy amable y me explicó todo con paciencia",
        "Nadie contestó el WhatsApp en todo el día",
        "El vendedor me trató con indiferencia",
        "Me resolvieron la duda en dos minutos, excelente servicio",
        "Tuve que esperar media hora para que me atendieran en caja",
        "El personal de la tienda es muy atento",
    ],
    "Entrega": [
        "El pedido llegó dos días tarde",
        "El domiciliario llegó antes de la hora acordada",
        "Mi paquete llegó abierto y faltaba un producto",
        "La entrega fue rapidísima, al día siguiente",
        "Nunca me avisaron que el envío se había retrasado",
        "La transportadora perdió mi pedido y tocó repetirlo",
    ],
    "Precio": [
        "Está más caro que en otras tiendas del barrio",
        "Los precios son muy buenos y siempre hay descuentos",
        "Subieron los precios sin avisar",
        "Buena relación calidad precio",
        "El costo del envío es demasiado alto",
        "Me gustaría que hubiera más promociones",
    ],
    "Calidad del producto": [
        "Los audífonos dejaron de funcionar a la semana",
        "El café es delicioso, muy buena calidad",
        "El termo no conserva el calor como dice la publicidad",
        "Los cuadernos son de muy buen papel",
        "El cargador se calienta demasiado",
        "La lámpara llegó con un defecto en la base",
    ],
    "Pagos": [
        "No me dejó pagar con PSE",
        "Me cobraron dos veces en la tarjeta",
        "Deberían aceptar Nequi y Daviplata",
        "El pago contra entrega es muy cómodo",
        "La factura electrónica nunca me llegó al correo",
    ],
}
SEDES = [("Bogotá", 35), ("Medellín", 25), ("Barranquilla", 20), ("En línea", 20)]


def elegir(rnd: random.Random, pares):
    valores, pesos = zip(*pares)
    return rnd.choices(valores, weights=pesos, k=1)[0]


def meses(desde: date, n: int):
    y, m = desde.year, desde.month
    for _ in range(n):
        yield y, m
        m += 1
        if m == 13:
            y, m = y + 1, 1


def hoja_ventas(rnd: random.Random):
    filas = []
    inicio = date(2024, 1, 1)
    estacional = {1: 0.8, 2: 0.85, 3: 0.95, 4: 0.95, 5: 1.0, 6: 1.15, 7: 1.05, 8: 1.0, 9: 0.95, 10: 1.0, 11: 1.2, 12: 1.6}
    lista_meses = list(meses(inicio, 30))  # ene-2024 a jun-2026
    pesos = [(1 + 0.018 * i) * estacional[m] for i, (_, m) in enumerate(lista_meses)]
    total_pesos = sum(pesos)
    objetivo = 790
    for (y, m), p in zip(lista_meses, pesos):
        n = round(objetivo * p / total_pesos)
        dias = (date(y + (m == 12), m % 12 + 1, 1) - date(y, m, 1)).days
        inflacion = 1.0 + 0.07 * (y - 2024)  # ajuste anual de precios
        for _ in range(n):
            f = date(y, m, rnd.randint(1, dias))
            prod, cat, base, tipicas = rnd.choice(PRODUCTOS)
            precio = round(base * inflacion * rnd.uniform(0.97, 1.03) / 100) * 100
            unidades = max(1, int(rnd.gauss(tipicas, tipicas * 0.5) + 0.5))
            if cat == "Papelería" and rnd.random() < 0.06:
                unidades = rnd.randint(20, 40)  # compras de oficinas y colegios
            comentario = rnd.choice(COMENTARIOS_VENTA) if rnd.random() < 0.62 else None
            filas.append([f, elegir(rnd, CIUDADES), rnd.choice(VENDEDORES), prod, cat, unidades, precio,
                          unidades * precio, elegir(rnd, CANALES), comentario])
    filas.sort(key=lambda r: r[0])

    # ---- Problemas de calidad a propósito ----
    def al_azar(k):
        return rnd.sample(range(len(filas)), k)

    for i in al_azar(12):
        filas[i][1] = filas[i][1] + " "            # espacio sobrante al final
    for i in al_azar(6):
        filas[i][1] = filas[i][1].strip().lower()   # «medellín», «bogotá»...
    for i in al_azar(3):
        filas[i][1] = filas[i][1].strip().upper()
    for i in al_azar(15):
        filas[i][2] = None                          # vendedor sin registrar
    for i in al_azar(8):
        filas[i][5] = str(filas[i][5])              # unidades guardadas como texto
    for i in al_azar(6):
        filas[i][0] = filas[i][0].strftime("%d/%m/%Y")  # fecha escrita como texto
    for i in al_azar(10):
        filas[i][7] = None                          # total sin calcular
    for i, u in zip(al_azar(3), (250, 400, 300)):   # atípicos: unidades
        filas[i][5] = u
        filas[i][7] = u * filas[i][6]
    for i in al_azar(2):                            # error de digitación: un cero de más
        filas[i][6] *= 10
        if isinstance(filas[i][5], int):
            filas[i][7] = filas[i][5] * filas[i][6]
    for i in sorted(al_azar(10), reverse=True):     # filas duplicadas (doble registro)
        filas.insert(i + 1, list(filas[i]))
    encabezados = ["Fecha", "Ciudad", "Vendedor", "Producto", "Categoría", "Unidades", "Precio unitario",
                   "Total", "Canal", "Comentario del cliente"]
    return encabezados, filas


def hoja_notas(rnd: random.Random):
    areas = {"Matemáticas": -0.25, "Lenguaje": 0.05, "Ciencias Naturales": -0.1, "Ciencias Sociales": 0.1,
             "Inglés": -0.15, "Tecnología e Informática": 0.3}
    cursos = [(9, "901"), (9, "902"), (10, "1001"), (10, "1002"), (11, "1101"), (11, "1102")]
    filas = []
    codigo = 0
    for grado, curso in cursos:
        for _ in range(15):
            codigo += 1
            est = f"EST-{codigo:04d}"
            habilidad = rnd.gauss(3.75, 0.5)
            faltador = rnd.random() < 0.08
            for periodo in (1, 2, 3):
                for area, ajuste in areas.items():
                    nota = min(5.0, max(1.0, round(rnd.gauss(habilidad + ajuste, 0.4), 1)))
                    inas = min(15, int(rnd.expovariate(1 / (5 if faltador else 0.8))))
                    obs = None
                    if nota < 3.0:
                        obs = rnd.choice(["Debe presentar plan de mejoramiento", "No entrega las tareas a tiempo",
                                          "Requiere acompañamiento de la familia", "Bajo rendimiento en evaluaciones"])
                    elif nota >= 4.6 and rnd.random() < 0.5:
                        obs = rnd.choice(["Excelente desempeño", "Participa activamente en clase",
                                          "Lidera el trabajo en equipo"])
                    elif inas >= 6:
                        obs = "Inasistencias frecuentes sin justificar"
                    elif rnd.random() < 0.12:
                        obs = rnd.choice(["Buen proceso", "Puede mejorar la ortografía", "Se distrae con el celular"])
                    filas.append([est, grado, curso, area, periodo, nota, inas, obs])
    for i in rnd.sample(range(len(filas)), 4):
        filas[i][5] = None                     # nota pendiente
    for i in rnd.sample(range(len(filas)), 3):
        filas[i][5] = f"{filas[i][5]:.1f}".replace(".", ",") if filas[i][5] else "3,5"  # nota como texto
    filas[rnd.randrange(len(filas))][5] = 45.0  # error de digitación (era 4,5)
    encabezados = ["Código estudiante", "Grado", "Curso", "Área", "Periodo", "Nota", "Inasistencias",
                   "Observación docente"]
    return encabezados, filas


def hoja_encuesta(rnd: random.Random):
    positivos = {"La asesora fue muy amable y me explicó todo con paciencia",
                 "Me resolvieron la duda en dos minutos, excelente servicio", "El personal de la tienda es muy atento",
                 "El domiciliario llegó antes de la hora acordada", "La entrega fue rapidísima, al día siguiente",
                 "Los precios son muy buenos y siempre hay descuentos", "Buena relación calidad precio",
                 "El café es delicioso, muy buena calidad", "Los cuadernos son de muy buen papel",
                 "El pago contra entrega es muy cómodo"}
    filas = []
    inicio = date(2026, 1, 5)
    for n in range(1, 161):
        tema = rnd.choice(list(ENCUESTA))
        comentario = rnd.choice(ENCUESTA[tema])
        bueno = comentario in positivos
        calif = rnd.choice([4, 5, 5]) if bueno else rnd.choice([1, 2, 2, 3])
        nps = min(10, max(0, calif * 2 + rnd.choice([-1, 0, 0, 1])))
        filas.append([f"R-{n:04d}", inicio + timedelta(days=rnd.randint(0, 250)), elegir(rnd, SEDES),
                      calif, "Sí" if nps >= 8 else "No", nps, comentario])
    filas.sort(key=lambda r: r[1])
    encabezados = ["Respuesta", "Fecha", "Sede", "Satisfacción (1-5)", "¿Recomendaría?",
                   "Probabilidad de recomendar (0-10)", "Comentario"]
    return encabezados, filas


def escribir(ws, encabezados, filas, formatos: dict[int, str], anchos: list[int]):
    ws.append(encabezados)
    for c in ws[1]:
        c.font = Font(bold=True, color="FFFFFF")
        c.fill = PatternFill("solid", fgColor=AZUL)
        c.alignment = Alignment(vertical="center")
    for fila in filas:
        ws.append(fila)
    for col, fmt in formatos.items():
        for (celda,) in ws.iter_rows(min_row=2, min_col=col, max_col=col):
            if not isinstance(celda.value, str):
                celda.number_format = fmt
    for i, ancho in enumerate(anchos, start=1):
        ws.column_dimensions[get_column_letter(i)].width = ancho
    ws.freeze_panes = "A2"


def texto(ws, celda: str, valor: str, **fuente):
    ws[celda] = valor
    ws[celda].data_type = "s"  # aunque empiece por «=», se guarda como texto
    if fuente:
        ws[celda].font = Font(**fuente)


def hoja_inicio(ws):
    ws.title = "Inicio"
    texto(ws, "A1", "Excel con Inteligencia Artificial — datos de ejemplo", bold=True, size=16, color=AZUL)
    texto(ws, "A2", "edwinortiz.net · Datos ficticios generados por computador: ninguno corresponde a personas reales.",
          color="606060")
    lineas = [
        ("A4", "1. Importa el módulo: Alt+F11 > Archivo > Importar archivo… > ExcelConIA.bas. Guarda como .xlsm.", {}),
        ("A5", "2. Ve a la hoja Ventas, Notas o Encuesta, haz clic en cualquier celda de la tabla y ejecuta", {}),
        ("A6", "    la macro PerfilarDatos (Alt+F8). Obtienes la hoja «Perfil de datos» y un prompt listo para tu IA.", {}),
        ("A7", "3. Para usar las funciones con IA, ejecuta la macro ConfigurarIA y pega tu clave de Google AI Studio.", {}),
        ("A9", "Fórmulas para probar (Excel en español usa punto y coma):", {"bold": True}),
        ("A10", '=IA("Resume en una frase este comentario"; Encuesta!G2)', {}),
        ("A11", "=IA_CLASIFICAR(Encuesta!G2; Encuesta!$K$2:$K$6)", {}),
        ("A12", '=IA_CLASIFICAR(Ventas!J2; "Positivo, Negativo, Neutro")', {}),
        ("A13", '=IA_EXTRAER("Escríbeme a ana@ejemplo.com, soy de Cali"; "ciudad")', {}),
        ("A15", "Hojas: Ventas (pyme, 800 filas con errores a propósito: vacíos, espacios, textos donde van", {}),
        ("A16", "números, duplicados y valores atípicos), Notas (colegio, escala 1,0 a 5,0) y Encuesta (comentarios).", {}),
        ("A18", "Privacidad: las funciones IA envían a Google el texto de las celdas que uses. No envíes datos personales.",
         {"color": "B00020"}),
    ]
    for celda, valor, fuente in lineas:
        texto(ws, celda, valor, **fuente)
    ws.column_dimensions["A"].width = 110


def main():
    salida = Path(sys.argv[1]) if len(sys.argv) > 1 else Path(__file__).resolve().parent
    salida.mkdir(parents=True, exist_ok=True)
    rnd = random.Random(SEMILLA)
    wb = Workbook()
    hoja_inicio(wb.active)

    enc, filas = hoja_ventas(rnd)
    escribir(wb.create_sheet("Ventas"), enc, filas, {1: "dd/mm/yyyy", 7: "#,##0", 8: "#,##0"},
             [12, 15, 17, 28, 13, 10, 15, 13, 14, 40])
    enc, filas = hoja_notas(rnd)
    escribir(wb.create_sheet("Notas"), enc, filas, {6: "0.0"}, [18, 8, 8, 25, 9, 7, 14, 40])
    enc, filas = hoja_encuesta(rnd)
    ws = wb.create_sheet("Encuesta")
    escribir(ws, enc, filas, {2: "dd/mm/yyyy"}, [11, 12, 14, 18, 15, 18, 60])
    # Lista de categorías para IA_CLASIFICAR, separada de la tabla por una columna vacía
    ws["K1"] = "Categorías"
    ws["K1"].font = Font(bold=True)
    for i, cat in enumerate(ENCUESTA, start=2):
        ws[f"K{i}"] = cat
    ws.column_dimensions["K"].width = 22

    destino = salida / "datos-ejemplo.xlsx"
    wb.properties.title = "Excel con IA — datos de ejemplo (edwinortiz.net)"
    wb.properties.creator = "Edwin Ortiz Herazo"
    wb.save(destino)
    print(f"{destino} ({destino.stat().st_size:,} bytes)")


if __name__ == "__main__":
    main()
