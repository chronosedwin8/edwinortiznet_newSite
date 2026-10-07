# -*- coding: utf-8 -*-
"""
Excel con Inteligencia Artificial: análisis completo con Python (pandas + openpyxl + Gemini)
edwinortiz.net · uso libre personal y educativo

Qué hace, en orden:
  1. Carga datos-ejemplo.xlsx (hojas Ventas, Notas y Encuesta).
  2. Limpia Ventas: espacios, mayúsculas, fechas escritas como texto, números guardados
     como texto, totales vacíos y filas duplicadas. Deja una bitácora de cada cambio.
  3. KPI: ventas por mes, ciudad, producto, canal y categoría; crecimiento mensual y anual.
  4. Valores atípicos: rango intercuartílico (IQR), puntaje z robusto y precios fuera de
     lo normal para cada producto.
  5. Pronóstico de 6 meses: Holt-Winters (statsmodels) si está instalado; si no, tendencia
     lineal con numpy.
  6. Clasifica los comentarios de la Encuesta con Gemini (por lotes, con caché y control de
     ritmo). Sin clave, este paso se omite y lo demás funciona igual.
  7. Notas del colegio: promedios por curso y área, desempeños del Decreto 1290 y
     estudiantes en riesgo académico.
  8. Escribe reporte.xlsx con formatos, filtros y gráficos nativos de Excel.

Uso:
    pip install -r requirements.txt
    python analisis_con_python.py
    python analisis_con_python.py --sin-ia
    python analisis_con_python.py --datos otro.xlsx --salida mi_reporte.xlsx --max-ia 100

Clave de Gemini (opcional, gratis en https://aistudio.google.com/apikey), solo en la
variable de entorno, nunca dentro del código:
    Windows:     setx GEMINI_API_KEY "tu_clave"   (y abre una terminal nueva)
    macOS/Linux: export GEMINI_API_KEY="tu_clave"
Privacidad: el paso 6 envía a Google los comentarios (no los demás datos). Con el nivel
gratuito, Google puede usar ese contenido para mejorar sus productos: no envíes datos
personales.
"""
from __future__ import annotations

import argparse
import hashlib
import json
import os
import sys
import time
import unicodedata
from datetime import date, datetime
from pathlib import Path

import numpy as np
import pandas as pd

try:  # requests solo hace falta para el paso con IA
    import requests
except ImportError:  # pragma: no cover
    requests = None

# ---------------------------------------------------------------------------
# Ajustes (cámbialos para tus propios datos)
# ---------------------------------------------------------------------------
CARPETA = Path(__file__).resolve().parent
MESES_PRONOSTICO = 6
MODELO_IA = "gemini-2.5-flash"
SEGUNDOS_ENTRE_LLAMADAS = 6.5  # nivel gratuito: ~10 solicitudes por minuto
LOTE_IA = 30                   # comentarios por solicitud
CATEGORIAS = ["Atención", "Entrega", "Precio", "Calidad del producto", "Pagos", "Otro"]
SENTIMIENTOS = ["Positivo", "Negativo", "Neutro"]

# Escala nacional del Decreto 1290 de 2009. Los rangos numéricos los fija cada colegio en
# su SIEE; estos son los más usados con notas de 1,0 a 5,0.
DESEMPENOS = [(4.6, "Superior"), (4.0, "Alto"), (3.0, "Básico"), (1.0, "Bajo")]
NOTA_MINIMA = 3.0              # aprobar = desempeño Básico o superior
MAX_INASISTENCIAS = 25         # inasistencias acumuladas en el año que encienden la alerta
AREAS_PERDIDAS_RIESGO = 2      # áreas con promedio < 3,0 que ponen al estudiante en riesgo

AZUL = "2350F0"


# ---------------------------------------------------------------------------
# Utilidades
# ---------------------------------------------------------------------------
def sin_tildes(texto: str) -> str:
    return "".join(c for c in unicodedata.normalize("NFKD", texto) if not unicodedata.combining(c))


def coma(x: float, decimales: int = 1) -> str:
    """3.456 -> «3,5» (decimal con coma, como se escribe en Colombia)."""
    return f"{x:.{decimales}f}".replace(".", ",")


def miles(x: float) -> str:
    """1250000 -> «1.250.000»."""
    return f"{x:,.0f}".replace(",", ".")


def clave_texto(texto: str) -> str:
    """Clave para comparar variantes: «  medellín », «MEDELLÍN» y «Medellin» -> «medellin»."""
    return " ".join(sin_tildes(str(texto)).casefold().split())


def a_fecha(valor) -> pd.Timestamp:
    """Acepta fechas reales y textos como 15/03/2025 o 2025-03-15."""
    if isinstance(valor, (pd.Timestamp, datetime, date)):
        return pd.Timestamp(valor)
    if isinstance(valor, str):
        for formato in ("%d/%m/%Y", "%Y-%m-%d", "%d-%m-%Y", "%d/%m/%y"):
            try:
                return pd.Timestamp(datetime.strptime(valor.strip(), formato))
            except ValueError:
                pass
    return pd.NaT


def a_numero(valor) -> float:
    """Números y textos como «12», «3,5» o «$ 24.900» -> float; lo demás -> NaN."""
    if isinstance(valor, (int, float, np.integer, np.floating)) and not isinstance(valor, bool):
        return float(valor)
    if isinstance(valor, str):
        s = valor.strip().replace("$", "").replace(" ", "")
        if s.count(",") == 1 and s.count(".") >= 1:      # 1.250,50
            s = s.replace(".", "").replace(",", ".")
        elif s.count(",") == 1:                          # 3,5
            s = s.replace(",", ".")
        elif s.count(".") > 1:                           # 1.250.000
            s = s.replace(".", "")
        try:
            return float(s)
        except ValueError:
            return np.nan
    return np.nan


class Bitacora:
    """Registro de cada transformación: lo que una auditoría o un directivo quiere ver."""

    def __init__(self):
        self.filas: list[dict] = []

    def anotar(self, hoja: str, paso: str, afectadas: int, detalle: str = ""):
        self.filas.append({"Hoja": hoja, "Paso": paso, "Filas o celdas afectadas": int(afectadas), "Detalle": detalle})
        print(f"  [{hoja}] {paso}: {afectadas}" + (f" ({detalle})" if detalle else ""))

    def tabla(self) -> pd.DataFrame:
        return pd.DataFrame(self.filas)


# ---------------------------------------------------------------------------
# 1-2. Carga y limpieza de Ventas
# ---------------------------------------------------------------------------
def limpiar_ventas(df: pd.DataFrame, bit: Bitacora) -> pd.DataFrame:
    df = df.copy()
    texto_cols = ["Ciudad", "Vendedor", "Producto", "Categoría", "Canal", "Comentario del cliente"]

    # Espacios sobrantes
    cambios = 0
    for col in texto_cols:
        es_texto = df[col].map(lambda v: isinstance(v, str))
        limpio = df.loc[es_texto, col].map(lambda s: " ".join(s.split()))
        cambios += int((limpio != df.loc[es_texto, col]).sum())
        df.loc[es_texto, col] = limpio
    bit.anotar("Ventas", "Espacios sobrantes eliminados", cambios)

    # Variantes de escritura de la ciudad: se usa la forma más frecuente de cada grupo
    claves = df["Ciudad"].map(clave_texto)
    canonica = df.groupby(claves)["Ciudad"].agg(lambda s: s.value_counts().index[0])
    nueva = claves.map(canonica)
    bit.anotar("Ventas", "Ciudades unificadas (mayúsculas y tildes)", int((nueva != df["Ciudad"]).sum()),
               ", ".join(sorted(canonica.unique())))
    df["Ciudad"] = nueva

    # Fechas escritas como texto
    fechas = df["Fecha"].map(a_fecha)
    bit.anotar("Ventas", "Fechas escritas como texto convertidas",
               int(df["Fecha"].map(lambda v: isinstance(v, str)).sum()))
    df["Fecha"] = pd.to_datetime(fechas)

    # Números guardados como texto
    for col in ["Unidades", "Precio unitario", "Total"]:
        textos = int(df[col].map(lambda v: isinstance(v, str)).sum())
        df[col] = df[col].map(a_numero).astype(float)
        if textos:
            bit.anotar("Ventas", f"«{col}» guardado como texto convertido a número", textos)

    # Totales vacíos o que no cuadran con unidades x precio
    calculado = df["Unidades"] * df["Precio unitario"]
    vacios = df["Total"].isna() & calculado.notna()
    bit.anotar("Ventas", "Totales vacíos calculados (unidades x precio)", int(vacios.sum()))
    df.loc[vacios, "Total"] = calculado[vacios]
    descuadre = (df["Total"] - calculado).abs() > 1
    if descuadre.any():
        bit.anotar("Ventas", "Totales que no cuadraban, recalculados", int(descuadre.sum()))
        df.loc[descuadre, "Total"] = calculado[descuadre]

    # Vendedor sin registrar
    sin_vendedor = df["Vendedor"].isna()
    bit.anotar("Ventas", "Vendedor vacío marcado como «Sin asignar»", int(sin_vendedor.sum()))
    df.loc[sin_vendedor, "Vendedor"] = "Sin asignar"

    # Duplicados exactos (después de limpiar: así se detectan también los «casi iguales»)
    antes = len(df)
    df = df.drop_duplicates().reset_index(drop=True)
    bit.anotar("Ventas", "Filas duplicadas eliminadas", antes - len(df))

    invalidas = df["Fecha"].isna() | df["Total"].isna()
    if invalidas.any():
        bit.anotar("Ventas", "Filas sin fecha o sin total descartadas", int(invalidas.sum()))
        df = df[~invalidas].reset_index(drop=True)
    df["Mes"] = df["Fecha"].dt.to_period("M").dt.to_timestamp()
    return df


# ---------------------------------------------------------------------------
# 3. Indicadores
# ---------------------------------------------------------------------------
def indicadores(df: pd.DataFrame) -> dict[str, pd.DataFrame]:
    mes = (df.groupby("Mes")
             .agg(Ventas=("Total", "sum"), Pedidos=("Total", "size"), Unidades=("Unidades", "sum"))
             .asfreq("MS", fill_value=0))
    mes["Ticket promedio"] = mes["Ventas"] / mes["Pedidos"].replace(0, np.nan)
    mes["Crecimiento mensual"] = mes["Ventas"].pct_change()
    mes["Crecimiento anual"] = mes["Ventas"].pct_change(12)
    mes = mes.reset_index()

    total = df["Total"].sum()

    def resumen(col: str) -> pd.DataFrame:
        t = (df.groupby(col)
               .agg(Ventas=("Total", "sum"), Pedidos=("Total", "size"), Unidades=("Unidades", "sum"))
               .sort_values("Ventas", ascending=False))
        t["Participación"] = t["Ventas"] / total
        t["Ticket promedio"] = t["Ventas"] / t["Pedidos"]
        return t.reset_index()

    # Crecimiento por ciudad: últimos 12 meses frente a los 12 anteriores
    fin = df["Mes"].max()
    ult = df[df["Mes"] > fin - pd.DateOffset(months=12)].groupby("Ciudad")["Total"].sum()
    prev = df[(df["Mes"] <= fin - pd.DateOffset(months=12)) &
              (df["Mes"] > fin - pd.DateOffset(months=24))].groupby("Ciudad")["Total"].sum()
    ciudades = resumen("Ciudad")
    ciudades["Crecimiento 12 meses"] = ciudades["Ciudad"].map((ult / prev - 1).replace([np.inf, -np.inf], np.nan))

    return {
        "mes": mes,
        "ciudad": ciudades,
        "producto": resumen("Producto").head(10),
        "canal": resumen("Canal"),
        "categoria": resumen("Categoría"),
        "vendedor": resumen("Vendedor"),
    }


# ---------------------------------------------------------------------------
# 4. Valores atípicos
# ---------------------------------------------------------------------------
def atipicos(df: pd.DataFrame) -> tuple[pd.DataFrame, pd.Series]:
    """Devuelve (hallazgos, máscara de errores probables).

    - Error probable (se excluye de los KPI): precio a más de 3 veces (o menos de un tercio) de
      la mediana de ESE producto, o unidades por encima de 15 veces su mediana: el típico «cero
      de más» o un número digitado en la columna equivocada.
    - Atípico (solo para revisar): total fuera de 3 x IQR dentro de su producto; el puntaje z
      robusto (mediana y MAD, menos sensible a los extremos que la media) dice qué tan lejos está.
    """
    hallazgos = []
    grupo = df.groupby("Producto")
    med_precio = grupo["Precio unitario"].transform("median")
    med_unid = grupo["Unidades"].transform("median")
    razon_precio = df["Precio unitario"] / med_precio
    razon_unid = df["Unidades"] / med_unid
    error = (razon_precio > 3) | (razon_precio < 1 / 3) | (razon_unid > 15)
    for i in df.index[error]:
        if razon_unid[i] > 15:
            motivo = f"{miles(df.at[i, 'Unidades'])} unidades: {razon_unid[i]:.0f} veces lo normal del producto"
        else:
            motivo = f"precio {coma(razon_precio[i])} veces la mediana del producto ({miles(med_precio[i])})"
        hallazgos.append({"Fila (datos limpios)": i + 2, "Fecha": df.at[i, "Fecha"], "Producto": df.at[i, "Producto"],
                          "Total": df.at[i, "Total"], "Tipo": "Error probable (excluido de KPI)", "Motivo": motivo})

    # Las ventas son asimétricas (muchas pequeñas, pocas grandes): se mide en escala logarítmica
    log_total = np.log10(df["Total"].clip(lower=1))
    q1, q3 = log_total.quantile([0.25, 0.75])
    riq = q3 - q1
    mediana = log_total.median()
    mad = (log_total - mediana).abs().median()
    z = 0.6745 * (log_total - mediana) / mad if mad else pd.Series(0.0, index=df.index)
    revisar = ~error & (z.abs() > 3.5)        # umbral de Iglewicz y Hoaglin
    for i in df.index[revisar]:
        hallazgos.append({"Fila (datos limpios)": i + 2, "Fecha": df.at[i, "Fecha"], "Producto": df.at[i, "Producto"],
                          "Total": df.at[i, "Total"], "Tipo": "Atípico (revisar)",
                          "Motivo": f"z robusto {coma(z[i])} (|z| > 3,5); rango IQR normal: "
                                    f"{miles(10 ** (q1 - 1.5 * riq))} a {miles(10 ** (q3 + 1.5 * riq))}"})
    tabla = pd.DataFrame(hallazgos, columns=["Fila (datos limpios)", "Fecha", "Producto", "Total", "Tipo", "Motivo"])
    return tabla.sort_values(["Tipo", "Fecha"]).reset_index(drop=True), error


# ---------------------------------------------------------------------------
# 5. Pronóstico
# ---------------------------------------------------------------------------
def pronostico(mes: pd.DataFrame, meses: int = MESES_PRONOSTICO) -> tuple[pd.DataFrame, str]:
    serie = mes.set_index("Mes")["Ventas"].astype(float).asfreq("MS")
    futuro = pd.date_range(serie.index[-1] + pd.offsets.MonthBegin(1), periods=meses, freq="MS")
    metodo = ""
    try:
        from statsmodels.tsa.holtwinters import ExponentialSmoothing

        estacional = "add" if len(serie) >= 24 else None
        modelo = ExponentialSmoothing(serie, trend="add", seasonal=estacional,
                                      seasonal_periods=12 if estacional else None,
                                      initialization_method="estimated").fit()
        valores = np.asarray(modelo.forecast(meses))
        metodo = "Holt-Winters aditivo (tendencia" + (" y estacionalidad de 12 meses)" if estacional else ")")
    except Exception as e:  # sin statsmodels o con muy pocos datos
        x = np.arange(len(serie))
        pendiente, intercepto = np.polyfit(x, serie.values, 1)
        valores = intercepto + pendiente * np.arange(len(serie), len(serie) + meses)
        metodo = f"Tendencia lineal (numpy.polyfit){'' if isinstance(e, ImportError) else ' — ' + type(e).__name__}"
    tabla = pd.DataFrame({"Mes": list(serie.index) + list(futuro),
                          "Ventas reales": list(serie.values) + [np.nan] * meses,
                          "Pronóstico": [np.nan] * (len(serie) - 1) + [serie.values[-1]] + list(np.maximum(valores, 0))})
    return tabla, metodo


# ---------------------------------------------------------------------------
# 6. Clasificación de comentarios con Gemini
# ---------------------------------------------------------------------------
class ClasificadorIA:
    URL = "https://generativelanguage.googleapis.com/v1beta/models/{modelo}:generateContent"

    def __init__(self, clave: str, modelo: str, cache: Path):
        self.clave, self.modelo, self.ruta_cache = clave, modelo, cache
        self.cache: dict[str, dict] = json.loads(cache.read_text("utf-8")) if cache.exists() else {}
        self.ultima = 0.0
        self.llamadas = 0

    def _id(self, texto: str) -> str:
        base = f"{self.modelo}|{'/'.join(CATEGORIAS)}|{texto}"
        return hashlib.sha256(base.encode("utf-8")).hexdigest()[:24]

    def _post(self, payload: dict) -> dict:
        espera = SEGUNDOS_ENTRE_LLAMADAS - (time.monotonic() - self.ultima)
        if espera > 0 and self.llamadas:
            time.sleep(espera)                                   # control de ritmo
        for intento in range(5):
            self.ultima = time.monotonic()
            r = requests.post(self.URL.format(modelo=self.modelo), json=payload, timeout=90,
                              headers={"x-goog-api-key": self.clave})   # la clave va en la cabecera
            self.llamadas += 1
            if r.status_code == 200:
                return r.json()
            if r.status_code in (429, 500, 503) and intento < 4:
                pausa = min(60, 5 * 2 ** intento)                # espera exponencial
                print(f"    Gemini respondió {r.status_code}; reintento en {pausa} s")
                time.sleep(pausa)
                continue
            mensaje = r.json().get("error", {}).get("message", r.text[:200]) if r.content else r.reason
            raise RuntimeError(f"Gemini {r.status_code}: {mensaje}")
        raise RuntimeError("Gemini no respondió después de varios intentos")

    def clasificar(self, textos: list[str]) -> dict[str, dict]:
        pendientes = [t for t in dict.fromkeys(textos) if self._id(t) not in self.cache]
        print(f"  {len(textos)} comentarios únicos; {len(textos) - len(pendientes)} ya estaban en caché")
        for inicio in range(0, len(pendientes), LOTE_IA):
            lote = pendientes[inicio:inicio + LOTE_IA]
            lista = "\n".join(f"{i}. {t}" for i, t in enumerate(lote))
            config = {
                "temperature": 0,
                "maxOutputTokens": 4096,
                "responseMimeType": "application/json",
                "responseSchema": {
                    "type": "ARRAY",
                    "items": {"type": "OBJECT", "properties": {
                        "id": {"type": "INTEGER"},
                        "categoria": {"type": "STRING", "enum": CATEGORIAS},
                        "sentimiento": {"type": "STRING", "enum": SENTIMIENTOS}},
                        "required": ["id", "categoria", "sentimiento"]}},
            }
            if "flash" in self.modelo:
                config["thinkingConfig"] = {"thinkingBudget": 0}
            payload = {
                "systemInstruction": {"parts": [{"text":
                    "Clasificas comentarios de clientes de una pyme colombiana. Para cada comentario elige "
                    "exactamente una categoría y un sentimiento de las listas permitidas."}]},
                "contents": [{"role": "user", "parts": [{"text":
                    f"Categorías: {', '.join(CATEGORIAS)}.\nSentimientos: {', '.join(SENTIMIENTOS)}.\n"
                    f"Comentarios (id. texto):\n{lista}"}]}],
                "generationConfig": config,
            }
            datos = self._post(payload)
            texto = "".join(p.get("text", "") for p in datos["candidates"][0]["content"]["parts"])
            for item in json.loads(texto):
                i = int(item.get("id", -1))
                if 0 <= i < len(lote) and item.get("categoria") in CATEGORIAS:
                    self.cache[self._id(lote[i])] = {"categoria": item["categoria"],
                                                     "sentimiento": item.get("sentimiento", "Neutro")}
            self.ruta_cache.write_text(json.dumps(self.cache, ensure_ascii=False, indent=1), "utf-8")
            print(f"  Lote {inicio // LOTE_IA + 1}: {len(lote)} comentarios clasificados")
        return {t: self.cache.get(self._id(t), {}) for t in textos}


def clasificar_encuesta(enc: pd.DataFrame, args, salida: Path) -> tuple[pd.DataFrame, str]:
    conteo = enc["Comentario"].dropna().map(str.strip).value_counts()
    tabla = conteo.rename_axis("Comentario").reset_index(name="Veces")
    clave = os.environ.get("GEMINI_API_KEY", "").strip()
    if args.sin_ia or not clave:
        motivo = "omitido (--sin-ia)" if args.sin_ia else "omitido: no hay variable de entorno GEMINI_API_KEY"
        print(f"  Clasificación con IA {motivo}")
        tabla["Categoría (IA)"] = ""
        tabla["Sentimiento (IA)"] = ""
        return tabla, motivo
    if requests is None:
        return tabla.assign(**{"Categoría (IA)": "", "Sentimiento (IA)": ""}), "omitido: instala requests"
    textos = list(tabla["Comentario"].head(args.max_ia))
    ia = ClasificadorIA(clave, args.modelo, salida.with_name("cache_ia.json"))
    try:
        resultado = ia.clasificar(textos)
        estado = f"clasificados con {args.modelo} ({ia.llamadas} solicitudes nuevas)"
    except Exception as e:  # la IA nunca debe tumbar el reporte
        print(f"  No se pudo clasificar con IA: {e}")
        resultado, estado = {}, f"error: {e}"
    tabla["Categoría (IA)"] = tabla["Comentario"].map(lambda t: resultado.get(t, {}).get("categoria", ""))
    tabla["Sentimiento (IA)"] = tabla["Comentario"].map(lambda t: resultado.get(t, {}).get("sentimiento", ""))
    return tabla, estado


# ---------------------------------------------------------------------------
# 7. Notas del colegio (Decreto 1290 de 2009)
# ---------------------------------------------------------------------------
def desempeno(nota: float) -> str:
    if pd.isna(nota):
        return ""
    for minimo, nombre in DESEMPENOS:
        if nota >= minimo:
            return nombre
    return "Bajo"


def analizar_notas(notas: pd.DataFrame, bit: Bitacora) -> dict[str, pd.DataFrame]:
    n = notas.copy()
    textos = int(n["Nota"].map(lambda v: isinstance(v, str)).sum())
    n["Nota"] = n["Nota"].map(a_numero).astype(float)
    bit.anotar("Notas", "Notas escritas como texto («3,5») convertidas", textos)
    fuera = (n["Nota"] > 5) & (n["Nota"] <= 50)
    bit.anotar("Notas", "Notas fuera de escala corregidas (45 -> 4,5)", int(fuera.sum()))
    n.loc[fuera, "Nota"] = n.loc[fuera, "Nota"] / 10
    invalidas = n["Nota"].notna() & ((n["Nota"] < 1) | (n["Nota"] > 5))
    n.loc[invalidas, "Nota"] = np.nan
    bit.anotar("Notas", "Notas vacías (pendientes, no cuentan en promedios)", int(n["Nota"].isna().sum()))
    n["Curso"] = n["Curso"].astype(str)

    por_curso_area = n.pivot_table(index="Curso", columns="Área", values="Nota", aggfunc="mean").round(2)
    por_curso_area["Promedio del curso"] = n.groupby("Curso")["Nota"].mean().round(2)
    por_curso_area = por_curso_area.sort_index(key=lambda s: s.astype(int)).reset_index()  # 901, 902, 1001...

    n["Desempeño"] = n["Nota"].map(desempeno)
    distribucion = (pd.crosstab(n["Curso"], n["Desempeño"], normalize="index")
                      .reindex(columns=[d for _, d in DESEMPENOS], fill_value=0)
                      .sort_index(key=lambda s: s.astype(int)).reset_index())

    est_area = n.groupby(["Código estudiante", "Curso", "Área"])["Nota"].mean().reset_index()
    perdidas = (est_area[est_area["Nota"] < NOTA_MINIMA].groupby("Código estudiante")["Área"]
                .agg(lambda s: ", ".join(sorted(s))))
    estudiantes = (n.groupby(["Código estudiante", "Grado", "Curso"])
                     .agg(Promedio=("Nota", "mean"), Inasistencias=("Inasistencias", "sum"))
                     .reset_index())
    estudiantes["Promedio"] = estudiantes["Promedio"].round(2)
    estudiantes["Desempeño"] = estudiantes["Promedio"].map(desempeno)
    estudiantes["Áreas en Bajo"] = estudiantes["Código estudiante"].map(perdidas).fillna("")
    estudiantes["N.º áreas en Bajo"] = estudiantes["Áreas en Bajo"].map(lambda s: len(s.split(", ")) if s else 0)

    def motivos(f) -> str:
        m = []
        if f["Promedio"] < NOTA_MINIMA:
            m.append(f"promedio {coma(f['Promedio'], 2)}")
        if f["N.º áreas en Bajo"] >= AREAS_PERDIDAS_RIESGO:
            m.append(f"{f['N.º áreas en Bajo']} áreas en Bajo")
        if f["Inasistencias"] > MAX_INASISTENCIAS:
            m.append(f"{f['Inasistencias']} inasistencias")
        return "; ".join(m)

    estudiantes["Motivo de riesgo"] = estudiantes.apply(motivos, axis=1)
    riesgo = (estudiantes[estudiantes["Motivo de riesgo"] != ""]
              .sort_values(["N.º áreas en Bajo", "Promedio"], ascending=[False, True]))
    return {"curso_area": por_curso_area, "distribucion": distribucion, "riesgo": riesgo,
            "total_estudiantes": pd.DataFrame({"n": [estudiantes.shape[0]]})}


# ---------------------------------------------------------------------------
# 8. Reporte en Excel
# ---------------------------------------------------------------------------
def escribir_reporte(ruta: Path, hojas: dict[str, pd.DataFrame], formatos: dict[str, dict[str, str]],
                     resumen: list[tuple[str, object, str]]):
    from openpyxl import load_workbook
    from openpyxl.chart import BarChart, LineChart, Reference
    from openpyxl.styles import Alignment, Font, PatternFill
    from openpyxl.utils import get_column_letter

    def mostrar_ejes(grafico):
        # openpyxl 3.1 marca los ejes como borrados: sin esto Excel no muestra etiquetas
        grafico.x_axis.delete = False
        grafico.y_axis.delete = False
        grafico.title.overlay = False
        if grafico.legend is not None:
            grafico.legend.overlay = False

    with pd.ExcelWriter(ruta, engine="openpyxl") as xw:
        pd.DataFrame(columns=["Indicador", "Valor"]).to_excel(xw, sheet_name="Resumen", index=False)
        for nombre, df in hojas.items():
            df.to_excel(xw, sheet_name=nombre, index=False)

    wb = load_workbook(ruta)
    encabezado = PatternFill("solid", fgColor=AZUL)

    # Resumen con formato por indicador
    ws = wb["Resumen"]
    ws["A1"], ws["B1"] = "Indicador", "Valor"
    for i, (nombre, valor, formato) in enumerate(resumen, start=2):
        ws.cell(i, 1, nombre)
        celda = ws.cell(i, 2, valor)
        if formato:
            celda.number_format = formato
        celda.alignment = Alignment(horizontal="left")
    ws.column_dimensions["A"].width = 42
    ws.column_dimensions["B"].width = 70

    for ws in wb.worksheets:
        for c in ws[1]:
            c.font = Font(bold=True, color="FFFFFF")
            c.fill = encabezado
            c.alignment = Alignment(wrap_text=True, vertical="center")
        ws.freeze_panes = "A2"
        if ws.title != "Resumen" and ws.max_row > 1:
            ws.auto_filter.ref = ws.dimensions
        nombres = [c.value for c in ws[1]]
        for j, nombre in enumerate(nombres, start=1):
            letra = get_column_letter(j)
            formato = formatos.get(ws.title, {}).get(nombre) or formatos.get("*", {}).get(nombre)
            if formato and ws.title != "Resumen":
                for (celda,) in ws.iter_rows(min_row=2, min_col=j, max_col=j):
                    celda.number_format = formato
            if ws.title != "Resumen":
                largo = max([len(str(nombre or ""))] + [len(str(c.value)) for (c,) in
                            ws.iter_rows(min_row=2, max_row=min(ws.max_row, 200), min_col=j, max_col=j) if c.value is not None])
                ws.column_dimensions[letra].width = min(60, max(10, largo * 0.9 + 2))

    # Gráfico de línea: ventas reales y pronóstico
    ws = wb["Pronóstico"]
    graf = LineChart()
    graf.title = "Ventas mensuales y pronóstico"
    graf.y_axis.title = "COP"
    graf.y_axis.number_format = '#,##0,,"M"'
    graf.height, graf.width = 9, 22
    graf.add_data(Reference(ws, min_col=2, max_col=3, min_row=1, max_row=ws.max_row), titles_from_data=True)
    graf.set_categories(Reference(ws, min_col=1, min_row=2, max_row=ws.max_row))
    graf.x_axis.number_format = "mmm-yy"
    for serie, color in zip(graf.series, (AZUL, "E8710A")):
        serie.smooth = False
        serie.graphicalProperties.line.solidFill = color
        serie.graphicalProperties.line.width = 28000   # 2,2 pt (EMU)
    graf.series[1].graphicalProperties.line.dashStyle = "dash"
    graf.legend.position = "b"
    mostrar_ejes(graf)
    ws.add_chart(graf, "F2")

    # Gráfico de barras: ventas por ciudad
    ws = wb["Ciudades"]
    barras = BarChart()
    barras.type = "bar"
    barras.title = "Ventas por ciudad"
    barras.height, barras.width = 9, 16
    barras.add_data(Reference(ws, min_col=2, min_row=1, max_row=ws.max_row), titles_from_data=True)
    barras.set_categories(Reference(ws, min_col=1, min_row=2, max_row=ws.max_row))
    barras.y_axis.number_format = '#,##0,,"M"'
    barras.x_axis.scaling.orientation = "maxMin"   # la ciudad con más ventas arriba
    barras.y_axis.crosses = "max"                  # y el eje de valores abajo
    barras.legend = None
    barras.varyColors = False
    barras.series[0].graphicalProperties.solidFill = AZUL
    mostrar_ejes(barras)
    ws.add_chart(barras, "J2")

    # Gráfico de columnas: promedio por curso
    ws = wb["Notas por curso"]
    col_prom = [c.value for c in ws[1]].index("Promedio del curso") + 1
    cols = BarChart()
    cols.title = "Promedio por curso"
    cols.y_axis.scaling.min, cols.y_axis.scaling.max = 1, 5
    cols.height, cols.width = 8, 14
    cols.add_data(Reference(ws, min_col=col_prom, min_row=1, max_row=ws.max_row), titles_from_data=True)
    cols.set_categories(Reference(ws, min_col=1, min_row=2, max_row=ws.max_row))
    cols.legend = None
    cols.varyColors = False
    cols.series[0].graphicalProperties.solidFill = AZUL
    mostrar_ejes(cols)
    ws.add_chart(cols, "A" + str(ws.max_row + 3))

    wb.properties.title = "Reporte de análisis — Excel con IA (edwinortiz.net)"
    wb.save(ruta)


# ---------------------------------------------------------------------------
def main():
    if hasattr(sys.stdout, "reconfigure"):
        sys.stdout.reconfigure(encoding="utf-8")
    p = argparse.ArgumentParser(description="Análisis de datos-ejemplo.xlsx con pandas y Gemini")
    p.add_argument("--datos", type=Path, default=CARPETA / "datos-ejemplo.xlsx")
    p.add_argument("--salida", type=Path, default=CARPETA / "reporte.xlsx")
    p.add_argument("--sin-ia", action="store_true", help="no llamar a Gemini")
    p.add_argument("--max-ia", type=int, default=200, help="máximo de comentarios únicos a clasificar")
    p.add_argument("--modelo", default=MODELO_IA)
    args = p.parse_args()

    if not args.datos.exists():
        sys.exit(f"No encuentro {args.datos}. Pon este script junto a datos-ejemplo.xlsx o usa --datos.")
    print(f"Leyendo {args.datos.name}")
    libro = pd.read_excel(args.datos, sheet_name=None, dtype=object)
    bit = Bitacora()

    print("1. Limpieza de Ventas")
    crudas = libro["Ventas"]
    ventas = limpiar_ventas(crudas, bit)

    print("2. Valores atípicos")
    raros, errores = atipicos(ventas)
    bit.anotar("Ventas", "Filas con error probable excluidas de los KPI", int(errores.sum()),
               "detalle en la hoja Atípicos")
    print(f"  {len(raros)} hallazgos")
    ventas_kpi = ventas[~errores]

    print("3. Indicadores")
    kpi = indicadores(ventas_kpi)
    mes = kpi["mes"]
    ult12 = mes.tail(12)["Ventas"].sum()
    prev12 = mes.iloc[-24:-12]["Ventas"].sum() if len(mes) >= 24 else np.nan

    print("4. Pronóstico")
    pron, metodo = pronostico(mes)
    print(f"  Método: {metodo}")

    print("5. Comentarios de la encuesta con IA")
    comentarios, estado_ia = clasificar_encuesta(libro["Encuesta"], args, args.salida)
    if comentarios["Categoría (IA)"].ne("").any():
        temas = (comentarios[comentarios["Categoría (IA)"] != ""]
                 .groupby("Categoría (IA)")["Veces"].sum().sort_values(ascending=False))
        print("  " + ", ".join(f"{k}: {v}" for k, v in temas.items()))

    print("6. Notas del colegio")
    notas = analizar_notas(libro["Notas"], bit)
    print(f"  {len(notas['riesgo'])} estudiantes en riesgo de {int(notas['total_estudiantes']['n'][0])}")

    top_ciudad = kpi["ciudad"].iloc[0]
    resumen = [
        ("Ventas totales (sin errores probables)", float(ventas_kpi["Total"].sum()), '"$" #,##0'),
        ("Pedidos", len(ventas_kpi), "#,##0"),
        ("Ticket promedio", float(ventas_kpi["Total"].mean()), '"$" #,##0'),
        ("Periodo", f"{ventas['Fecha'].min():%d/%m/%Y} a {ventas['Fecha'].max():%d/%m/%Y}", ""),
        ("Ventas últimos 12 meses", float(ult12), '"$" #,##0'),
        ("Crecimiento frente a los 12 meses anteriores", float(ult12 / prev12 - 1) if prev12 else "", "0.0%"),
        ("Ciudad con más ventas", f"{top_ciudad['Ciudad']} ({coma(top_ciudad['Participación'] * 100)} % del total)", ""),
        ("Producto más vendido", kpi["producto"].iloc[0]["Producto"], ""),
        ("Pronóstico próximos 6 meses", float(pron["Pronóstico"].tail(MESES_PRONOSTICO).sum()), '"$" #,##0'),
        ("Método de pronóstico", metodo, ""),
        ("Errores probables (excluidos) / atípicos a revisar",
         f"{int(errores.sum())} / {int((raros['Tipo'] == 'Atípico (revisar)').sum())}", ""),
        ("Clasificación con IA", estado_ia, ""),
        ("Estudiantes en riesgo (Notas)", len(notas["riesgo"]), "0"),
        ("Criterio de riesgo", f"promedio < {coma(NOTA_MINIMA)}, {AREAS_PERDIDAS_RIESGO} o más áreas en Bajo "
                               f"o más de {MAX_INASISTENCIAS} inasistencias en el año", ""),
        ("Generado", datetime.now().strftime("%d/%m/%Y %H:%M"), ""),
    ]
    hojas = {
        "Calidad de datos": bit.tabla(),
        "Ventas por mes": mes,
        "Pronóstico": pron,
        "Ciudades": kpi["ciudad"],
        "Top productos": kpi["producto"],
        "Canales": kpi["canal"],
        "Categorías": kpi["categoria"],
        "Vendedores": kpi["vendedor"],
        "Atípicos": raros,
        "Comentarios IA": comentarios,
        "Notas por curso": notas["curso_area"],
        "Desempeños 1290": notas["distribucion"],
        "Estudiantes en riesgo": notas["riesgo"],
        "Ventas limpias": ventas.drop(columns=["Mes"]),
    }
    dinero = '"$" #,##0'
    formatos = {
        "*": {"Ventas": dinero, "Ticket promedio": dinero, "Participación": "0.0%", "Unidades": "#,##0",
              "Pedidos": "#,##0", "Mes": "mmm-yyyy", "Fecha": "dd/mm/yyyy", "Crecimiento mensual": "0.0%",
              "Crecimiento anual": "0.0%", "Crecimiento 12 meses": "0.0%", "Ventas reales": dinero,
              "Pronóstico": dinero, "Total": dinero, "Precio unitario": dinero, "Valor": "#,##0",
              "Promedio": "0.00", "Promedio del curso": "0.00"},
        "Desempeños 1290": {d: "0.0%" for _, d in DESEMPENOS},
        "Notas por curso": {a: "0.00" for a in notas["curso_area"].columns[1:]},
    }
    try:
        escribir_reporte(args.salida, hojas, formatos, resumen)
    except PermissionError:
        sys.exit(f"No pude escribir {args.salida}: ciérralo en Excel y vuelve a intentarlo.")
    print(f"\nListo: {args.salida} ({args.salida.stat().st_size:,} bytes, {len(hojas) + 1} hojas)")


if __name__ == "__main__":
    main()
