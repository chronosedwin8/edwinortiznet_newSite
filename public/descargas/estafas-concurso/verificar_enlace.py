"""
Verificador básico de enlaces: ¿el dominio termina en el dominio oficial de la CNSC? (Python 3, solo biblioteca estándar)

Un enlace es del dominio oficial solo si el NOMBRE DEL SERVIDOR (lo que va entre «https://» y la primera «/»)
es exactamente «cnsc.gov.co» o termina en «.cnsc.gov.co». Las estafas suelen poner el nombre oficial en otra parte de la
dirección (por ejemplo, antes de otro dominio) o usar letras parecidas.

Es una ayuda mínima: un enlace puede ser oficial y llevarte a un contenido que no confirmas; y un dominio distinto
no siempre es una estafa (la CNSC puede enlazar a otros sitios). Confirma siempre escribiendo la dirección a mano.
Uso:  python verificar_enlace.py https://simo.cnsc.gov.co/
"""
import sys
from urllib.parse import urlparse

OFICIAL = "cnsc.gov.co"


def es_dominio_oficial(url):
    if "://" not in url:
        url = "https://" + url
    host = (urlparse(url).hostname or "").lower().rstrip(".")
    return host == OFICIAL or host.endswith("." + OFICIAL), host


if __name__ == "__main__":
    urls = sys.argv[1:] or [
        "https://www.cnsc.gov.co/",
        "https://simo.cnsc.gov.co/",
        "https://cnsc.gov.co.inscripciones-docentes.example/pago",
        "https://simo-cnsc.gov.co.pago-seguro.example/",
        "https://www.cnsc-gov.example/concurso",
        "https://cnsc.gov.co@sitio-falso.example/",
        "https://simo.cnsc.gov.co.evil.example/",
    ]
    for u in urls:
        ok, host = es_dominio_oficial(u)
        print(("OFICIAL     " if ok else "NO OFICIAL  ") + f"{host:45} <- {u}")
