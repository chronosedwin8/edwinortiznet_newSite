# Pendientes y decisiones para Edwin

Todo lo de esta lista ya tiene un **valor por defecto aplicado**: el sitio funciona sin que tomes ninguna decisión. Revísala, decide y cámbialo desde el panel (`/admin/`) o pídele el cambio a quien mantenga el sitio.

---

## A. Decisiones marcadas en el plan `[DECISIÓN DE EDWIN]`

### A1. Artículos traducidos al inglés
**Por defecto:** se tradujeron los 12 tutoriales ligados a productos visibles. Todos quedaron publicados en inglés con la marca "Por revisar".

| Español | Inglés |
| --- | --- |
| `/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/` | `/en/send-bulk-emails-with-attachments-from-excel-and-outlook/` |
| `/enviar-correos-sin-macros-desde-excel-365-y-2019/` | `/en/send-emails-from-excel-without-macros/` |
| `/como-enviar-correos-masivos-desde-una-lista-de-excel-usando-macros-y-outlook/` | `/en/send-bulk-emails-from-an-excel-list-with-macros-and-outlook/` |
| `/enviar-emails-masivos-combinar-correspondencia/` | `/en/send-bulk-emails-with-word-mail-merge/` |
| `/combinar-correspondencia-y-generar-pdf-individuales/` | `/en/mail-merge-to-individual-pdf-files/` |
| `/combinar-y-guardar-en-documentos-independientes/` | `/en/mail-merge-and-save-as-separate-documents/` |
| `/combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/` | `/en/merge-excel-data-into-separate-docx-and-pdf-documents/` |
| `/codigos-qr-en-excel-como-crearlos/` | `/en/qr-codes-in-excel-how-to-create-them/` |
| `/como-crear-codigos-qr-sin-caducidad/` | `/en/how-to-create-qr-codes-that-never-expire/` |
| `/generador-masivo-de-codigos-qr-desde-excel/` | `/en/bulk-qr-code-generator-from-excel/` |
| `/todo-lo-que-necesita-saber-sobre-codigos-de-barras-en-excel/` | `/en/what-you-need-to-know-about-barcodes-in-excel/` |
| `/convertir-numeros-a-letras-en-excel-con-macros/` | `/en/convert-numbers-to-words-in-excel-with-macros/` |

**Qué decidir:** si amplías o reduces la lista. Para traducir uno nuevo, abre el artículo en el panel y usa **"+ Crear versión en inglés"**.

### A2. Productos con versión real en inglés
**Por defecto:** ningún producto está marcado con versión en inglés (`has_english_version = 0`). Por eso cada ficha en inglés dice: *"The template interface is in Spanish; an English quick-start guide is included"*. El correo de compra en inglés repite esa promesa.

**Qué decidir:**
- Qué plantillas vas a ofrecer en inglés. Al tenerlas, marca "La plantilla tiene versión en inglés" en el producto y sube el archivo.
- **Mientras tanto hay que preparar la guía rápida en inglés** que el sitio promete. Agrégala dentro del .zip de cada producto o súbela como archivo adicional desde el panel.

Esta es la decisión que más afectará los reembolsos de compradores en inglés.

### A3. Aviso del Concurso Docente
**Por defecto:** las 8 entradas del concurso muestran al inicio el aviso:
> *Actualización del 5 de octubre de 2026: la CNSC trasladó las inscripciones a enero–febrero de 2027 y las pruebas escritas al segundo semestre de 2027. Las fechas definitivas se publican en cnsc.gov.co.*

**Qué decidir:** confirma que el texto y las fechas son correctos. Se edita en cada entrada, campo "Aviso al inicio".

### A4–A6. Contenido retirado
Los portátiles de afiliados (2020), la guía para descargar videos de YouTube y `/projekttag/` se retiraron con redirección 301, junto con otras 16 piezas de poco contenido o fuera de tema. El detalle, los motivos y cómo revertir cada una están en **`EVALUACION_CONTENIDO.md`**.

### A7. Tasa de cambio y precios en pesos
**Por defecto:** `USD_COP_RATE=4000`, redondeado al millar. En español se cobra el precio en COP; en inglés, el precio en USD.

| Producto | Estado | USD | COP |
| --- | --- | ---: | ---: |
| Enviar Correos Masivos con adjuntos y copias CC y CCO | a la venta | 25 | 100.000 |
| Combinar correspondencia y guardar documentos independientes | a la venta | 30 | 120.000 |
| Generador de Códigos QR Masivos | a la venta | 15 | 60.000 |
| Generador Códigos QR de productos Individuales | a la venta | 10 | 40.000 |
| Combinar correspondencia y generar PDF individuales | a la venta | 20 | 80.000 |
| Factura Sencilla Numeración Automática | a la venta | 10 | 40.000 |
| Convertidor de números a letras en Excel | a la venta | 10 | 40.000 |
| Factura con envío por correo al cliente | a la venta | 20 | 80.000 |
| Generador de códigos QR masivos a imágenes PNG | a la venta | 30 | 120.000 |
| Generador de Etiquetas para inventario de activos fijos | a la venta | 25 | 100.000 |
| Generador de Códigos de Barras masivos a PNG | a la venta | 50 | 200.000 |
| Aplicativo para Combinar datos de Excel en documentos separados | a la venta | 70 | 280.000 |
| Listado de Asistencia laboral o académica en Excel | a la venta | 10 | 40.000 |
| Asesoría PLUS para las plantillas de Excel | a la venta | 30 | 120.000 |
| Curso Aptitud Matemática – Concurso 2021 | a la venta | 20 | 80.000 |
| Pack Oficina / Pack Docente / Todo incluido anual | pronto | 99 / 79 / 149 | 396.000 / 316.000 / 596.000 |
| 10 productos nuevos (certificados, kit concurso, boletines, kit IA, exámenes, asistencia QR, correo web/Mac, inventario, cotizaciones, curso IA) | pronto | 15–60 | 60.000–240.000 |

**Qué decidir:** la tasa y los precios finales en COP. Se editan producto por producto en el panel; volver a correr el seed no los pisa.

### A8. Simulacro del Concurso Docente → Fundales
El simulacro propio se retiró. La página `/herramientas/simulacro-concurso-docente/`, el hub del concurso, la portada y los artículos del concurso llevan a **fundales.com** con UTM (`utm_source=edwinortiz.net`). El enlace base se cambia en *Panel → Ajustes*.

**Qué revisar:** los textos de la página de Fundales (*cuenta gratis por un año*, funciones y cargos) en `lang/es.php`, claves `fundales.*`.

### A9. Políticas y "Sobre mí"
**Por defecto:** se redactaron borradores de privacidad y tratamiento de datos (Ley 1581 de 2012), términos, reembolsos (7 días, con soporte previo) y cookies, más la página "Sobre mí" con tus datos del plan. Todos están en español y en inglés.

**Qué hacer:**
- Revisar los textos, idealmente con asesoría legal.
- Los textos remiten al formulario de contacto como canal de atención. Si quieres un correo dedicado (por ejemplo `datos@edwinortiz.net`), agrégalo en la política de privacidad.

---

## B. Revisión de contenido

1. **Traducciones al inglés por revisar** (filtro "Por revisar" del panel): 12 artículos, 15 productos, 7 familias, 3 hubs, 5 páginas y `lang/en.php`. Notas de la traducción:
   - Unos textos usan ortografía británica ("customise") y otros "-ize"; conviene unificar.
   - En las fichas en inglés se reemplazaron los medios de pago antiguos (ePayco, PayU, Nequi) por PayPal, y "15 días, dos descargas" por las condiciones reales (30 días, 5 descargas).
   - Los enlaces a artículos que solo existen en español apuntan a la versión en español.
2. **Fichas en español de los productos importados:** varias descripciones aún mencionan **medios de pago antiguos** (ePayco, PayU, transferencias Nequi/Daviplata) y **"15 días, dos descargas"**. Las condiciones reales del sitio nuevo son Mercado Pago o Wompi, 30 días y 5 descargas. Edítalas en el panel.
3. **Requisitos, "qué incluye" y licencia** de los 15 productos son textos generales por familia (Excel 2016+ para Windows con macros, Outlook de escritorio para correo masivo, etc.). Verifícalos producto por producto; por ejemplo, el aplicativo de 70 USD dice "Windows 10 u 11".
4. El producto **"Combinar correspondencia y generar PDF individuales"** entrega un archivo **.txt** con el código VBA (así estaba en WooCommerce). Confirma que es lo que quieres vender.
5. **Curso Aptitud Matemática 2021:** sigue a la venta, pero no tiene descripción y es de 2021. Decide si actualizarlo o pasarlo a oculto.
6. **10 productos nuevos y 3 packs:** sus fichas describen lo que *tendrán*. Revisa textos y precios antes de anunciarlos. La lista de espera está en *Panel → Suscriptores*.
7. **53 metadescripciones automáticas** (marcadas "Meta automática"): son borradores de 150–160 caracteres tomados del primer párrafo. Revísalas en el panel y desmarca la casilla al aprobarlas.
8. **Producto relacionado de cada artículo:** los tutoriales enlazan a su plantilla. El resto usa un producto según el hub (Excel → el más vendido; docentes → Kit de IA; concurso → invitación a Fundales en lugar de un producto). Se cambia en el campo "Producto relacionado" de cada artículo.

9. **Artículo de Wompi:** critica a Wompi, que es una de las pasarelas del sitio. Decide si actualizarlo (ver `EVALUACION_CONTENIDO.md`).
10. **Artículos de Grupo Logic:** revisa los 7 artículos nuevos de la sección Docentes (datos de cada producto, enlaces y la nota sobre grados de VCodePro).

## C. Antes de apagar WordPress

1. **Archivos de producto:** ya están copiados en `storage/downloads/` en este equipo (19 archivos, 78 MB). En el servidor nuevo, ejecuta `php bin/console downloads:fetch` mientras WordPress siga en línea, o copia la carpeta `storage/downloads/`.
2. **Imágenes y archivos sin copia en S3.** El importador redirigió a S3 todas las imágenes que tenían copia allí (más de 200). Estas no la tienen y dejarán de funcionar al apagar WordPress o `files.edwinortiz.net`:
   - `/archivos-gratis/` (borrador, redirige a /herramientas/) → `…/wp-content/uploads/2023/11/3of9_barcode.zip`
   - `/combinar-correspondencia-en-documentos-independientes-en-3-simples-pasos/` → `…/wp-content/uploads/2024/07/158386.jpg`
   - `/como-pasar-de-hexadecimal-a-decimal-en-excel/` → `…/wp-content/uploads/2023/10/hexatodec.mp4`
   - `/enviar-emails-masivos-combinar-correspondencia/` → `…/wp-content/uploads/2023/10/combinar.gif`
   - `/los-mejores-portatiles-baratos-y-rapidos/` → 5 imágenes en `…/wp-content/uploads/2020/05/`
   - `files.edwinortiz.net`: `Sin título-1.jpg` (5 entradas de ciudadanía digital), `Trabajo con fechas.xlsx` (sumar y restar fechas), `Filmo2020.rar` (Filmora 9) y un enlace a la raíz (guardar proyecto en Filmora).

   **Qué hacer:** súbelos a S3 y cambia las URL en el panel, o confirma que `files.edwinortiz.net` seguirá en línea.
3. **Pedidos y clientes antiguos** de WooCommerce: no venían en los XML. Si quieres darles acceso en "Mi cuenta", hay que exportarlos (ver `deploy/CHECKLIST.md`).

## D. Configuración pendiente

1. **Pasarelas:** faltan las credenciales reales de Mercado Pago, Wompi y PayPal (Business), y registrar las URL de webhook (ver `README.md`).
   - Las pruebas automáticas cubren firmas, duplicados, montos y la compra completa con las API simuladas.
   - **Falta la compra real en sandbox** con cada pasarela, porque no había credenciales de prueba.
2. **Correo (Amazon SES):** el `.env` local ya tiene el host `email-smtp.us-east-1.amazonaws.com` y la contraseña SMTP derivada de las claves que enviaste; la autenticación se verificó sin enviar correos. Falta:
   - verificar el dominio o la dirección `hola@edwinortiz.net` en SES (o cambiar `MAIL_FROM_ADDRESS`);
   - publicar SPF y DKIM;
   - sacar la cuenta del sandbox de SES.
3. **Seguridad de credenciales:** las claves de AWS (S3 y SES) se compartieron por chat.
   - Además, mientras se configuraba este equipo, el archivo `.env` estuvo accesible en la red local por `http://<este-equipo>:8080/edwinortizNET/.env`. Ya está bloqueado (403).
   - Por ambas razones, **rota las dos claves IAM** al terminar la migración y genera una contraseña SMTP nueva con `php bin/console mail:ses-password`.
   - Las claves de S3 no se usaron: los archivos eran públicos.
4. **GA4 y AdSense:** faltan `GA4_ID`, `ADSENSE_CLIENT` y los tres `ADSENSE_SLOT_*` en `.env`. Hasta entonces no se carga nada de Google.
5. **Redes sociales:** agrega la URL de tu canal de YouTube y de LinkedIn en *Panel → Ajustes*. Se usan en el marcado `Person` de Google; no se inventaron.
6. **Logo:** el color de marca `#0E5A6B`, el favicon "EO" y las imágenes Open Graph (`public/assets/img/og-default*.png`) son provisionales hasta que entregues el logo.
7. **Usuario del panel:** se creó `chronosedwin8@gmail.com` con una contraseña aleatoria, que se te entregó por chat. Cámbiala con `php bin/console admin:create chronosedwin8@gmail.com "Edwin Ortiz Herazo"`.
8. **Boletín:** el sitio recoge suscriptores con doble confirmación y etiquetas (general, excel, concurso…), pero no envía boletines. Exporta el CSV desde el panel a tu herramienta de correo.

## E. Rendimiento

- Lighthouse móvil (local, con OPcache):
  - portada 100, tienda 100, producto 98–99 y herramienta QR 100;
  - **artículo 94–95**.
- Accesibilidad, buenas prácticas y SEO dan 100 en las cuatro páginas.
- El límite del artículo es la imagen de portada: un PNG de 150–200 KB servido desde S3.
- **Qué decidir:** si autorizas servir las imágenes por una CDN con WebP (por ejemplo CloudFront con optimización de imágenes), el artículo pasaría con margen de 95. El plan pedía no mover las imágenes de S3, por eso no se hizo.

## F. Cambios hechos en este equipo (XAMPP)

- `C:\xampp\php\php.ini`: se activaron `intl`, `gd`, `sodium` y `opcache`. Respaldo: `php.ini.bak-edwinortiz`.
- `C:\xampp\apache\conf\httpd.conf`: se activaron `mod_deflate`, `mod_expires` y `mod_filter`. Respaldo: `httpd.conf.bak-edwinortiz`.
- `C:\xampp\apache\conf\extra\httpd-vhosts.conf`: VirtualHost en el puerto **8090** con raíz en `public/`. Respaldo: `httpd-vhosts.conf.bak-edwinortiz`.
- Base de datos local `edwinortiz` en el MySQL de Windows.
