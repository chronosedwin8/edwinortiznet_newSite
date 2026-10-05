# Evaluación de contenido — 5 de octubre de 2026

Revisé los artículos y páginas importados de WordPress buscando tres problemas:

- **poco contenido**: textos cortos o genéricos que no responden una pregunta concreta;
- **poca relevancia**: temas fuera de lo que hoy trabaja el sitio (automatización con Excel, tecnología para docentes, Concurso Docente);
- **riesgo**: piezas que pueden afectar la cuenta de AdSense o la reputación del sitio.

**Nada se borró.** Cada pieza retirada pasó a **borrador** y su URL redirige con **301** al reemplazo más útil, así se conservan los enlaces que la apuntaban. El cambio está en `database/seeds/07_content_cleanup.php`.

**Para revertir una pieza:**
1. En *Panel → Artículos y páginas*, cambia su estado a «Publicado».
2. En *Panel → Redirecciones*, elimina su redirección.

## 1. Retirado (borrador + 301)

| URL | Redirige a | Motivo |
| --- | --- | --- |
| `/como-obtener-filmora-9-x/` | `/como-convertir-un-video-filmora-a-mp4/` | Promueve instalar Filmora con crack y quitar la marca de agua: riesgo legal y de AdSense. |
| `/descargar-audio-y-videos-de-youtube-gratis-y-sin-programas/` | `/blog/` | Descarga de videos de YouTube: riesgo de derechos de autor y de AdSense. |
| `/western-union-dejara-de-estar-disponible-en-youtube-como-forma-de-pago/` | `/blog/` | Noticia de 2020 sin vigencia y fuera de tema. |
| `/hosting-y-dominio-gratis-por-siempre-100-sin-publicidad/` | Guía de WordPress 2022 | Ofertas de hosting de 2020 que ya no aplican. |
| `/como-instalar-wordpress-en-un-hosting-de-manera-facil/` | Guía de WordPress 2022 | Texto corto que repite la guía más completa. |
| `/los-mejores-portatiles-baratos-y-rapidos/` | `/blog/` | Afiliados de 2020 con modelos y precios desactualizados. |
| `/cual-es-la-mejor-laptop-para-estudiantes-de-escuela-y-universidad/` | `/blog/` | Ídem. |
| `/por-que-el-cielo-es-azul/` | `/ia-para-docentes/` | Fuera del enfoque del sitio y con poco contenido. |
| `/la-tecnologia-en-la-educacion-dio-un-salto-cuantico-durante-el-covid-19/` | Artículo sobre educación virtual en colegios públicos | Opinión de 2020 que se solapa con el artículo más completo. |
| `/la-educacion-virtual-y-su-relacion-con-los-padres/` | Ídem | Ídem. |
| `/restar-horas-en-excel/` | `/como-restar-horas-en-excel-horas-laborales/` | Duplicado (antes solo tenía canonical). |
| `/infografia/` (página 2018) | `/infografia-en-power-point/` | Texto genérico; el artículo es más útil. |
| `/wordpress/` (página 2018) | Guía de WordPress 2022 | Página genérica con banners de hosting. |
| `/lineas-de-tiempo/` (página 2018) | `/ia-para-docentes/` | Página genérica sobre diagramas de Gantt. |
| `/herramientas-tic/` (página 2018) | `/herramientas-tecnologicas-para-docentes-pros-y-contras/` | Repite el artículo de herramientas tecnológicas. |
| `/realidad-aumentada/` (página 2018) | `/realidad-aumentada-un-recurso-de-aula/` | Genérica; el artículo propio con Scratch es mejor. |
| `/informatica-basica-para-adultos/` | `/cursos/` | Corta y fuera del enfoque actual. |
| `/projekttag/` | `/` | Seis palabras, sin propósito público. |
| `/combinar-correspondencia-en-documentos-independientes-en-3-simples-pasos/` | Ficha del aplicativo de combinar documentos | Página de venta que duplica la ficha del producto y el tutorial. |

El artículo de educación virtual que se conserva lleva ahora un aviso de que es un texto de 2020.

## 2. Revisado y conservado

- **Serie de ciudadanía digital (Interland, 5 artículos):** sigue vigente y encaja con la sección de docentes.
- **Filmora: guardar proyecto y convertir a MP4:** son tutoriales legítimos y reciben tráfico.
- **Página de pensamiento computacional:** contenido largo y propio.
- **Cursos de informática y tecnología:** página comercial vigente.
- **«Todo lo que debes saber sobre Wompi Bancolombia»:** se conserva, pero **revísalo tú**.
  - Es una crítica directa a Wompi, que es una de las pasarelas del sitio nuevo. Un comprador que lo lea antes de pagar puede desconfiar.
  - El artículo cuenta que la cuenta tenía un tope de **500.000 COP por transacción y por día**. Si ese límite sigue activo en tu cuenta, afecta a los packs más caros: confírmalo con Wompi antes del lanzamiento.
  - Opciones:
    - actualizarlo con tu experiencia actual;
    - agregarle una nota de 2026;
    - pasarlo a borrador con una redirección al blog.

## 3. Cambios relacionados

- **Simulacro propio retirado:** el banco de preguntas y la herramienta del sitio se eliminaron.
  - La URL `/herramientas/simulacro-concurso-docente/` ahora presenta **Fundales**, con la cuenta gratis por un año.
  - Todos los artículos del Concurso Docente muestran la invitación a Fundales con UTM para medir de dónde llegan los usuarios.
- **Kit Concurso Docente 2027:** queda **oculto**, porque la preparación ahora se hace en Fundales.
- **Artículos nuevos:** 7 artículos sobre las herramientas de Grupo Logic (UntiCloud, AulaMágica IA, EduNova IA, Codexia, CodeNest School, VCodePro y BookStudio).
  - Están en la sección *Docentes*, con ideas de uso en el aula y preguntas frecuentes, que generan datos estructurados FAQPage.
  - Las imágenes salen de tus proyectos en el escritorio (`Desktop/GrupoLogic`).
  - Revisa dos detalles:
    - **VCodePro** menciona grados «6.º a 12.º». En Colombia el bachillerato termina en 11.º; si el producto también se vende fuera de Colombia, puede quedarse así.
    - **AulaMágica IA** solo tiene una imagen dentro del texto. Puedes agregar más desde *Panel → Medios*.
