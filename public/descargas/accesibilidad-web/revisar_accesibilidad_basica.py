"""
Revisión básica de accesibilidad de un archivo HTML (Python 3, solo biblioteca estándar).

Detecta ocho problemas frecuentes que una prueba automática puede encontrar y calcula la relación de contraste de WCAG.
Una revisión automática NO demuestra que una página sea accesible: solo encuentra una parte de los problemas.
Uso:  python revisar_accesibilidad_basica.py archivo.html
      python revisar_accesibilidad_basica.py --contraste 767676 ffffff
"""
import re
import sys
from html.parser import HTMLParser

GENERICOS = {"aquí", "aqui", "clic aquí", "haz clic aquí", "haga clic aquí", "ver más", "leer más", "click aquí", "más", "link"}


def luminancia(hex6):
    """Luminancia relativa según WCAG 2."""
    canales = [int(hex6[i:i + 2], 16) / 255 for i in (0, 2, 4)]
    lin = [c / 12.92 if c <= 0.03928 else ((c + 0.055) / 1.055) ** 2.4 for c in canales]
    return 0.2126 * lin[0] + 0.7152 * lin[1] + 0.0722 * lin[2]


def contraste(a, b):
    la, lb = luminancia(a.lstrip("#")), luminancia(b.lstrip("#"))
    claro, oscuro = max(la, lb), min(la, lb)
    return (claro + 0.05) / (oscuro + 0.05)


class Revisor(HTMLParser):
    def __init__(self):
        super().__init__()
        self.problemas = []
        self.lang = False
        self.titulo = False
        self.en_titulo = False
        self.labels_for = set()
        self.campos = []          # (tag, id, tiene_aria, dentro_de_label)
        self.dentro_label = 0
        self.enlace = None        # texto acumulado del enlace actual
        self.enlace_tiene_img_alt = False
        self.boton = None
        self.niveles = []

    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if tag == "html" and a.get("lang"):
            self.lang = True
        if tag == "title":
            self.en_titulo = True
        if tag == "img" and "alt" not in a:
            self.problemas.append("Imagen sin atributo alt: " + (a.get("src") or "?"))
        if tag == "img" and self.enlace is not None and a.get("alt"):
            self.enlace_tiene_img_alt = True
        if tag == "label":
            self.dentro_label += 1
            if a.get("for"):
                self.labels_for.add(a["for"])
        if tag in ("input", "select", "textarea") and a.get("type") not in ("hidden", "submit", "button", "image"):
            self.campos.append((tag, a.get("id"), bool(a.get("aria-label") or a.get("aria-labelledby")), self.dentro_label > 0, a.get("name")))
        if tag == "a":
            self.enlace = ""
            self.enlace_tiene_img_alt = False
        if tag == "button":
            self.boton = ""
        if tag in ("h1", "h2", "h3", "h4", "h5", "h6"):
            n = int(tag[1])
            if self.niveles and n > self.niveles[-1] + 1:
                self.problemas.append(f"Salto de encabezados: de h{self.niveles[-1]} a h{n}")
            self.niveles.append(n)
        if a.get("tabindex", "0").lstrip("-").isdigit() and int(a.get("tabindex", "0")) > 0:
            self.problemas.append(f"tabindex positivo ({a['tabindex']}) en <{tag}>: altera el orden natural del teclado")
        if tag == "div" and "onclick" in a:
            self.problemas.append("<div> con onclick: no es accesible por teclado; usa <button>")

    def handle_endtag(self, tag):
        if tag == "title":
            self.en_titulo = False
        if tag == "label":
            self.dentro_label -= 1
        if tag == "a" and self.enlace is not None:
            texto = self.enlace.strip().lower()
            if not texto and not self.enlace_tiene_img_alt:
                self.problemas.append("Enlace sin texto ni alternativa")
            elif texto in GENERICOS:
                self.problemas.append(f"Enlace con texto genérico: «{self.enlace.strip()}»")
            self.enlace = None
        if tag == "button" and self.boton is not None:
            if not self.boton.strip():
                self.problemas.append("Botón sin texto accesible")
            self.boton = None

    def handle_data(self, data):
        if self.en_titulo and data.strip():
            self.titulo = True
        if self.enlace is not None:
            self.enlace += data
        if self.boton is not None:
            self.boton += data

    def cerrar(self):
        if not self.lang:
            self.problemas.append("Falta el idioma de la página (<html lang=\"es\">)")
        if not self.titulo:
            self.problemas.append("Falta el título de la página (<title>)")
        for tag, idv, aria, dentro, name in self.campos:
            if not (aria or dentro or (idv and idv in self.labels_for)):
                self.problemas.append(f"Campo <{tag}> sin etiqueta asociada (name={name}); un placeholder no reemplaza a la etiqueta")
        return self.problemas


def revisar(ruta):
    with open(ruta, encoding="utf-8") as f:
        html = f.read()
    r = Revisor()
    r.feed(html)
    problemas = r.cerrar()
    for m in re.finditer(r"color:\s*#([0-9a-fA-F]{6})\s*;\s*background:\s*#([0-9a-fA-F]{6})", html):
        c = contraste(m.group(1), m.group(2))
        if c < 4.5:
            problemas.append(f"Contraste insuficiente: #{m.group(1)} sobre #{m.group(2)} = {c:.2f}:1 (mínimo 4,5:1 para texto normal)")
    return problemas


if __name__ == "__main__":
    if len(sys.argv) == 4 and sys.argv[1] == "--contraste":
        print(f"Contraste {sys.argv[2]} sobre {sys.argv[3]}: {contraste(sys.argv[2], sys.argv[3]):.2f}:1")
    elif len(sys.argv) == 2:
        p = revisar(sys.argv[1])
        print(f"{sys.argv[1]}: {len(p)} problema(s) detectado(s)")
        for x in p:
            print(" -", x)
    else:
        print(__doc__)
