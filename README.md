# edwinortiz.net

Sitio de Edwin Ortiz Herazo: blog, herramientas gratuitas y tienda de descargas digitales, en **español (raíz del dominio, COP)** e **inglés (`/en/`, USD)**. Reemplaza el WordPress + WooCommerce anterior conservando todas sus URLs.

- **Backend:** PHP 8.2+ sin framework (PSR-4, PSR-12, `strict_types`), MySQL 8 con PDO y sentencias preparadas.
- **Frontend:** plantillas PHP con HTML semántico, `critical.css` en línea + `main.css`, JavaScript en módulos ES sin dependencias.
- **Pagos:** Mercado Pago y Wompi (español, COP) y PayPal (inglés, USD), por REST con cURL.
- **Dependencias de Composer:** `phpmailer/phpmailer`, `vlucas/phpdotenv` y `dompdf/dompdf` (PDF del PIAR), más `phpunit` para desarrollo.

---

## 1. Requisitos

| Componente | Versión | Notas |
| --- | --- | --- |
| PHP | 8.2 o superior | Extensiones: `pdo_mysql`, `curl`, `mbstring`, `intl`, `dom`, `simplexml`, `fileinfo` y `gd` con soporte WebP (biblioteca de medios); `exif` opcional para orientar fotos de celular. Activa OPcache en producción. |
| MySQL | 8.0 | `utf8mb4_unicode_ci`, InnoDB. |
| Servidor web | Nginx (recomendado) o Apache 2.4 | La raíz web es **`public/`**. Ver `deploy/nginx.conf` o `public/.htaccess`. |
| Composer | 2.x | |
| Cron | — | Ver `deploy/cron.txt`. |

## 2. Instalación

```bash
git clone … /var/www/edwinortiz && cd /var/www/edwinortiz
composer install --no-dev --optimize-autoloader
cp .env.example .env          # completa los valores (ver sección 3)
php bin/console migrate       # crea la base de datos y el esquema
```

Importar el contenido de WordPress (los XML van en `storage/import/`, nunca en `public/`):

```bash
php bin/console import:wxr      # 64 entradas, 18 páginas, 21 productos (idempotente)
php bin/console seed            # hubs, tienda, tratamiento editorial, redirecciones, ajustes, políticas y traducciones al inglés
php bin/console downloads:fetch # copia los archivos de los productos a storage/downloads/ (requiere que WordPress siga en línea)
php bin/console downloads:check # lista lo que falte
php bin/console admin:create    # crea (o restablece) el usuario del panel
php bin/console sitemap:build
```

Permisos: el usuario de PHP debe poder escribir en `storage/` (caché, logs, sesiones, descargas).

### Desarrollo local con XAMPP (Windows)

En este equipo el sitio corre en **http://localhost:8090/** mediante un VirtualHost de Apache con `DocumentRoot` en `public/` (al final de `C:\xampp\apache\conf\extra\httpd-vhosts.conf`). Se activaron `intl`, `gd`, `sodium` y `opcache` en `php.ini`, y `mod_deflate`, `mod_expires` y `mod_filter` en `httpd.conf`; hay copias de respaldo con el sufijo `.bak-edwinortiz`. El `.htaccess` de la raíz del proyecto bloquea el acceso web a todo lo que no sea `public/`.

## 3. Configuración (`.env`)

`.env.example` documenta cada variable. Las más importantes:

| Variable | Uso |
| --- | --- |
| `APP_URL`, `APP_KEY`, `APP_DEBUG` | URL absoluta (canonical, sitemap, correos), clave para firmas CSRF, errores detallados solo en desarrollo. |
| `NOINDEX=true` | Para el subdominio de pruebas: añade `noindex` a todo. |
| `DB_*` | Conexión MySQL. |
| `MAIL_*`, `ADMIN_EMAIL` | SMTP (Amazon SES). `MAIL_DRIVER=log` guarda los correos en `storage/logs/mail/` en vez de enviarlos. La contraseña SMTP de SES se obtiene con `php bin/console mail:ses-password us-east-1`. |
| `USD_COP_RATE` | Tasa usada por el seed para calcular `price_cop` (luego se edita en el panel). |
| `MP_*`, `WOMPI_*`, `PAYPAL_*` | Credenciales y modo `sandbox`/`production` de cada pasarela. |
| `GA4_ID`, `ADSENSE_*` | Se cargan solo tras aceptar cookies; AdSense solo en artículos (máximo 3 bloques). |
| `DOWNLOAD_ACCEL=true` | Con Nginx, entrega los archivos con `X-Accel-Redirect`. |
| `GEMINI_API_KEY`, `GEMINI_MODEL`, `GEMINI_ASSIST_MODEL` | PIAR con IA: clave de la API de Google Gemini (va en la cabecera `x-goog-api-key`), modelo del documento (por defecto `gemini-2.5-pro`) y modelo del asistente «Redactar con IA» por campo (por defecto `gemini-2.5-flash`; 10 usos por cada PIAR de los paquetes vigentes y 8 por hora, respuestas de máximo 1.500 tokens; no descuenta PIAR). Sin clave, la generación se muestra como no disponible. |

### URLs de webhook que se registran en cada pasarela

| Pasarela | URL | Eventos |
| --- | --- | --- |
| Mercado Pago | `https://www.edwinortiz.net/webhooks/mercadopago` | Pagos (`payment`). La clave secreta va en `MP_WEBHOOK_SECRET`. |
| Wompi | `https://www.edwinortiz.net/webhooks/wompi` | `transaction.updated`. El "Secreto de eventos" va en `WOMPI_EVENTS_SECRET`. |
| PayPal | `https://www.edwinortiz.net/webhooks/paypal` | `PAYMENT.CAPTURE.COMPLETED`, `.DENIED`, `.REFUNDED`, `.REVERSED`, `.PENDING` y `CHECKOUT.ORDER.APPROVED`. El id del webhook va en `PAYPAL_WEBHOOK_ID`. |

## Producción (desplegado el 5 de octubre de 2026)

- **Servidor:** EC2 t2.small con CloudPanel (Debian 11), IP `54.165.72.25`. Comparte servidor con otros sitios: no se toca la configuración global de nginx ni de PHP.
- **Sitio:** usuario `edwinortiz`, código en `/home/edwinortiz/htdocs/www.edwinortiz.net` (clon de `github.com/chronosedwin8/edwinortiznet_newSite`, rama `main`). Raíz web: `public/`. PHP 8.4-FPM en `127.0.0.1:19006`. Base de datos MariaDB 10.6 `edwinortiz` (las credenciales están solo en el `.env` del servidor).
- **Nginx:** plantilla propia guardada también en CloudPanel (*Sitio → Vhost*), con PageSpeed y Varnish desactivados para este sitio. Si se edita desde el panel, conservar el front controller y `location /protected-downloads/`.
- **Desplegar cambios:** `git push` a `main` y luego en el servidor: `sudo -u edwinortiz -H bash /home/edwinortiz/htdocs/www.edwinortiz.net/deploy/deploy.sh` (trae el código, instala dependencias, migra, vacía la caché, regenera el sitemap y comprueba las rutas).
- **Cron** (usuario `edwinortiz`, visible en CloudPanel): `orders:reconcile` cada 10 minutos y `sitemap:build` a las 3:15.
- **Solo en el servidor (no están en git):** `.env` y `public/cv/` (CV). Las imágenes y los archivos de producto están en S3 (`STORAGE_DISK=s3`); activa el versionado del bucket si quieres poder recuperar archivos borrados.
- **Respaldo de WordPress:** `/home/edwinortiz/backups/wordpress-*-2026-10-05.*` y copia local en `Documentos\Backups\edwinortiz-wordpress-2026-10-05`.

## 4. Comandos (`php bin/console …`)

| Comando | Qué hace |
| --- | --- |
| `migrate [--fresh]` | Aplica las migraciones de `database/migrations/` (`--fresh` borra la base primero). |
| `import:wxr` | Importa los XML de WordPress. Se puede repetir: actualiza por `wp_id` sin duplicar y no toca los campos editoriales. |
| `seed [filtro]` | Ejecuta los seeds (`database/seeds/*.php` y `database/seeds/en/*.php`). Son idempotentes. |
| `downloads:check` | Lista los productos que aún no tienen su archivo en `storage/downloads/` (esos se muestran como "Disponible pronto"). |
| `downloads:fetch` | Copia los archivos desde su URL original (WordPress o S3) y los enlaza. |
| `sitemap:build` | Regenera `storage/cache/sitemap.xml`. |
| `admin:create [correo] [nombre] [clave]` | Crea o restablece un usuario del panel (Argon2id). |
| `orders:reconcile` | Tarea programada: consulta pedidos pendientes y anula los vencidos. |
| `piar:purge` | Tarea programada (cada 15 min): borra el contenido de las pruebas gratis del PIAR vencidas (2 h) y da por fallidas las generaciones colgadas, devolviendo el crédito. |
| `examenes:purge` | Tarea programada (cada 15 min): Generador de exámenes — da por fallidas las generaciones colgadas (devuelve el examen al plan) y vacía el contenido de los exámenes borrados hace más de 30 días. |
| `kit:build [materia…] [--check]` | Kit de IA para docentes: por cada materia con contenido en `database/kits/ia-docentes/` genera el PDF, `prompts.txt` y el ZIP, y los registra como archivo del producto con su variante (sube a S3 si `STORAGE_DISK=s3`). Idempotente. Activa el producto solo cuando están las seis materias. `--check` solo valida el contenido. |
| `cache:clear` | Vacía la caché de página completa. |
| `routes:check` | Verifica que todas las URL importadas respondan 200. |
| `mail:test [correo]` | Envía un correo de prueba con la configuración actual. |
| `mail:ses-password [región]` | Deriva la contraseña SMTP de Amazon SES desde la clave secreta IAM. |

## 5. Operación diaria

- **Panel:** `https://www.edwinortiz.net/admin/`. Escritorio con ventas, pendientes, suscriptores, 404 y productos sin archivo. Desde ahí se editan artículos, productos (textos ES/EN, precios, archivos), familias, pedidos (reenviar correo, regenerar descargas, consultar la pasarela), suscriptores y lista de espera (CSV), redirecciones, secciones (introducción, preguntas frecuentes y SEO de cada hub), biblioteca de medios y ajustes.
- **Editor del panel:** texto enriquecido con limpieza al pegar desde Word/Docs, imágenes (subir, arrastrar o elegir de la biblioteca, con texto alternativo obligatorio), videos de YouTube, tablas, bloques dinámicos `{{productos:…}}` / `{{articulos:…}}` y vista de HTML. Incluye asistente SEO con vista previa de Google, borradores locales que se recuperan si se cierra el navegador, `Ctrl+S` para guardar y `Ctrl+K` para buscar en todo el panel.
- **Archivos subidos:** con `STORAGE_DISK=s3` van al bucket de S3 (`blogedwinortiznet`). Las imágenes se convierten a WebP (1600 y 800 px) y quedan públicas en `uploads/AAAA/MM/`; los archivos de producto quedan **privados** en `descargas/<producto>/` y se entregan con una URL firmada que vence en 5 minutos, después de validar el enlace de descarga del pedido. `php bin/console storage:s3` mueve a S3 lo que aún esté en el servidor y lo borra solo después de verificarlo.
- **Caché:** cada guardado en el panel vacía la caché de página. Las páginas en caché se sirven en milisegundos y llevan `ETag`.
- **Traducciones:** todo lo traducido al inglés entra con `needs_review = 1`. El filtro "Por revisar" del panel muestra lo pendiente; desmarca la casilla al aprobarlo. En una entrada en español, "Crear versión en inglés" crea el borrador enlazado (mismo `translation_group`) y el `hreflang` aparece al publicarlo.
- **Cambiar un slug** desde el panel crea automáticamente una redirección 301 desde la URL anterior.
- **404:** revisa "Redirecciones" en el panel; cada 404 trae un enlace para crear su redirección.
- **Archivos de producto:** se suben desde la ficha del producto en el panel y quedan en `storage/downloads/` (fuera de la web). El comprador recibe enlaces firmados válidos por 30 días y 5 descargas.

## 6. Cómo funciona

### Rutas e idiomas
- Español en la raíz con las URLs de WordPress intactas (`/{slug}/`, `/producto/{slug}/`, `/categoria-producto/{slug}/`, `/tienda/`, `/carrito/`, `/finalizar-compra/`, `/mi-cuenta/`…). Inglés bajo `/en/` con slugs traducidos.
- El idioma lo decide **solo el prefijo** de la URL. Si el navegador prefiere el otro idioma y existe traducción, se muestra una franja descartable.
- Todas las URLs terminan en `/`; sin barra → 301. El router consulta la tabla `redirects` antes de responder 404 y registra los 404 en `not_found_log`.
- Las cadenas de interfaz están en `lang/es.php`, `lang/en.php` y `lang/admin.es.php`. Las plantillas usan `t('clave')`. Una prueba garantiza que no quede texto visible fuera de `t()`.

### Pagos
- El cliente **nunca envía montos**: precios y totales se calculan en el servidor según el idioma (`price_cop` en español, `price_usd` en inglés).
- `GatewayResolver` permite Mercado Pago y Wompi solo en pedidos `es`/`COP`, y PayPal solo en `en`/`USD`. El servidor rechaza cualquier otra combinación.
- Un pedido pasa a `approved` **solo** desde un webhook verificado o una consulta servidor a servidor, nunca por los parámetros de la URL de retorno. Siempre se verifica que monto y moneda coincidan, dentro de una transacción con `SELECT … FOR UPDATE`.
- Cada evento se guarda en `payment_events` (único por pasarela + id), así que los duplicados no se reprocesan. Firma inválida → 401.
- Al aprobarse se crean los permisos de descarga y se envían los correos en el idioma del pedido, junto con el aviso a `ADMIN_EMAIL`.

### PIAR con IA (`/herramientas/piar/` y `/piar/`)
- Herramienta solo en español para redactar el **Plan Individual de Ajustes Razonables** (Decreto 1421 de 2017) con Google Gemini. Presentación indexable en `/herramientas/piar/`; la aplicación (`/piar/…`) es `noindex` y `private, no-store`.
- **Acceso:** enlace mágico con la misma tabla `customers`/`login_tokens` y la misma sesión (`customer_id`) que Mi cuenta; aquí pedir el enlace **crea la cuenta** y registra la aceptación de términos y tratamiento de datos (`piar_profiles.terms_accepted_at`).
- **Prueba gratis:** 2 PIAR por cuenta de por vida (los fallidos no cuentan), más límite por IP. Solo se ven en la misma sesión, sin PDF ni edición, y su contenido se purga a las 2 horas (perezosamente y con `piar:purge`); el registro sin contenido queda para el contador.
- **Paquetes:** productos de servicio `PIAR-5`, `PIAR-10` y `PIAR-20` (seed `11_piar.php`), comprados por el pago normal. Al aprobarse el pedido, `OrderService` crea un paquete por ítem (`piar_packages`, único por `order_item_id`) con vigencia de 30 días desde el pago y envía `piar-credits`; el reembolso anula los créditos sin usar. Cada PIAR consume un crédito del paquete que vence primero (`SELECT … FOR UPDATE`); si la IA falla, se devuelve. No existe la opción de borrar PIAR.
- **Generación asíncrona:** el POST crea la fila `pending` y redirige a la página de progreso, que consulta `/piar/{id}/estado/`. Con PHP-FPM la llamada a Gemini corre después de `fastcgi_finish_request()` (hasta 300 s; el pool debe permitirlo: `request_terminate_timeout` en 0 o ≥ 300); sin FPM se genera dentro de la misma petición. Un `pending` de más de 6 minutos pasa a error y devuelve el crédito.
- **Con paquete activo:** historial permanente, edición por secciones, PDF formal (dompdf, DejaVu Sans) con logo e institución del perfil y acta de acuerdo con firmas. El logo (PNG/JPG/WebP ≤ 1 MB) se valida con `getimagesize`, se recodifica a PNG y queda privado en S3 (`piar/logos/`) o en `storage/piar/logos/`.
- **Panel:** *Tienda → PIAR con IA* lista las cuentas (prueba usada, créditos vigentes, PIAR guardados) y permite dar un paquete manual.

### Variantes de producto y Kit de IA para docentes
- Un producto de descarga puede tener **variantes** (migración 015): cada archivo de `product_files` puede llevar `variant` (clave, p. ej. `matematicas`); los archivos sin variante son para todos. Si un producto tiene archivos con variante, la ficha pide elegir una (obligatorio) y el carrito guarda líneas `id:variante` (dos variantes = dos líneas). El servidor valida la variante contra los archivos del producto (`OrderService::cart()`), el ítem del pedido guarda `variant`, `variant_label` y el título «Producto — Variante», y `DownloadService::createGrants()` entrega solo los archivos de esa variante más los comunes. El nombre visible de cada variante sale de `lang/*.php` (`variant.{clave}`) o, si no existe, de la etiqueta del archivo. En el panel, el formulario de archivos tiene el campo «Variante (materia)».
- **Kit de IA para docentes** (`EO-KIT-IA`): se vende por materia. El contenido está en `database/kits/ia-docentes/{materia}.php` (más `_comun.php` con los capítulos compartidos); `php bin/console kit:build` genera el PDF (dompdf, índice con páginas en dos pasadas, plantilla `templates/kits/ia-docentes-pdf.php`) y el ZIP de cada materia en `storage/downloads/kit-de-ia-para-docentes/`. El seed `13_kit_ia.php` pone los textos ES/EN, la portada y el estado.

### Generador de exámenes con IA (`/herramientas/generador-de-examenes/` y `/examenes/`)
- Herramienta solo en español. Presentación indexable en `/herramientas/generador-de-examenes/`; la aplicación (`/examenes/…`) es `noindex` y `private, no-store`. Acceso con el mismo enlace mágico y la misma sesión (`customer_id`) que PIAR y Mi cuenta (perfil propio en `exam_profiles`: términos, institución, docente y logo privado en S3 `examenes/logos/` o `storage/examenes/logos/`).
- **Asistente de 6 pasos:** materia y grado; tema específico (texto libre, ≤ 200 caracteres) y contexto (≤ 3.000: lo visto en clase, el grupo o un texto fuente), alcance, propósito, dificultad y estilo; cantidad por cada uno de los 12 tipos de pregunta; versiones (hasta 8) y modo (**distintas**: la IA escribe una pregunta equivalente por versión; **barajar**: mismas preguntas con orden y opciones barajados y claves recalculadas); encabezado y papel (carta, oficio 8,5 × 13 in, media carta). El texto del docente va al modelo entre `<<<` y `>>>` como datos.
- **Generación** (`ExamGenerator`, `gemini-2.5-flash`, `EXAMENES_MODEL`): bloques de 12 unidades (pregunta × versión) en paralelo con `curl_multi` (`Gemini::generateJsonMany`), una tabla de especificaciones previa si hay varios bloques, tope de salida por llamada según el tipo de pregunta (`ExamCatalog::TYPES`), rescate de las preguntas completas de una respuesta truncada y un solo reintento por examen (≤ 6 unidades). Asíncrona como PIAR (`fastcgi_finish_request`, la página consulta `/examenes/{id}/estado/`); un `pending` de más de 15 minutos pasa a error.
- **Planes** (`ExamCredits::PLANS`, seed `14_examenes.php`): `EXAM-8`, `EXAM-20` y `EXAM-40`, de 30 días y acumulables, con exámenes, versiones, preguntas únicas (en «distintas» cuenta cada versión) y un cupo extra de preguntas con IA por examen. Se activan en `OrderService` al aprobarse el pago (`examenes-plan`) y el reembolso los anula. Si la IA falla, el examen vuelve al plan (máximo 2 veces por plan). Borrar un examen no devuelve cupo.
- **Editor:** cada pregunta (todas sus versiones) se edita aparte, con vista previa de las fórmulas; se puede quitar, reemplazar con IA o pedir preguntas adicionales con IA (tipo, cantidad, dificultad, estilo, subtema y contexto), dentro del cupo del examen y de 5 solicitudes por examen.
- **LaTeX:** `tools/tex2svg` (MathJax 3 empaquetado para Node 12, ver su README) convierte las fórmulas a SVG una vez por documento; caché por hash en `storage/cache/tex/`. Pantalla: SVG en línea. PDF (dompdf): `<img>` SVG con tamaño y `vertical-align` en em. Sin Node, se muestra el TeX original. `NODE_BINARY` es opcional (por defecto `/usr/bin/node`).
- **PDF:** por versión, el examen y la hoja de respuestas; al final el solucionario (claves, equivalencias, tabla de especificaciones, soluciones, rúbricas y crucigramas y sopas resueltos). Crucigramas y sopas de letras se arman en PHP (`Puzzles`). Pie con la versión y la página dentro de la versión.
- **Simulador** (`/examenes/demo/`): el mismo formulario lleno con un ejemplo, sin IA, con el banco fijo `DemoBank` (5 materias) y PDF con marca DEMO.
- **Panel:** *Tienda → Exámenes con IA* (cuentas, uso, costo de IA de 30 días y plan manual).
### SEO y rendimiento
- Title, descripción, canonical, `hreflang` recíproco con `x-default`, Open Graph/Twitter y JSON-LD (`Person`, `WebSite` + `SearchAction`, `Article`, `Product`/`Offer`, `BreadcrumbList`, `FAQPage`, `Course`).
- Sitemap dinámico con alternativas (sin `noindex`), feeds RSS `/feed/` y `/en/feed/`, `robots.txt`.
- Caché de página en disco, CSS crítico en línea, fuentes WOFF2 locales con respaldo de métricas ajustadas, `srcset` de los tamaños que existen en S3, `preconnect` al bucket, `content-visibility` bajo el pliegue y GA4/AdSense diferidos tras el consentimiento.

### Reacciones y compartir
- Cada artículo termina con reacciones al estilo LinkedIn (una por visitante y artículo, se cambia o se quita) y botones para compartir. La página está en la caché completa, así que `article.js` pide los conteos y la reacción del visitante a `GET /api/reacciones/{id}` y guarda con `POST /api/reacciones/{id}` (`reaction` = `like|insightful|celebrate|love|thoughtful`, vacío para quitar; CSRF por `X-CSRF-Token`; límite por IP). Sin JS, cada reacción es un botón de formulario.
- Tabla `post_reactions` (migración 009) con `UNIQUE(post_id, visitor)`; `visitor` es el HMAC con `APP_KEY` del id aleatorio de la cookie funcional `eo_rx` (un año, `HttpOnly`, solo se crea al reaccionar). Los conteos son por idioma (fila de `posts`) y salen de un `GROUP BY` sobre el índice `(post_id, reaction)`; `Reactions::summaries()` los da para varias entradas en una consulta.
- Open Graph: de las portadas WebP se genera una vez un JPEG 1200×630 en `public/og/` (WhatsApp y LinkedIn no siempre muestran WebP); las imágenes por defecto son `og-default.png` y `og-default-en.png`.

### Seguridad
- CSRF con cookie de doble envío firmada; honeypot y marca de tiempo firmada en los formularios públicos; límite de peticiones por IP en acceso, pago, suscripción, búsqueda y contacto.
- CSP con hash para el único script en línea, HSTS en producción, `X-Content-Type-Options`, `Referrer-Policy` y `Permissions-Policy`.
- El HTML de artículos y productos pasa por una lista blanca (importador y panel). Las plantillas escapan con `e()`.
- Panel: Argon2id, bloqueo tras 5 intentos fallidos y cookies `HttpOnly` + `SameSite=Lax` (+ `Secure` en HTTPS).
- Los registros (`storage/logs`) omiten datos sensibles. Los errores detallados solo se muestran con `APP_DEBUG=true`.

### Módulos gratuitos para Excel

Las herramientas de número a letras y de códigos QR también se descargan como módulos VBA para Excel (función `=NUMEROALETRAS()` / `=NUMBERTOWORDS()` y función `=QR()` con la macro `GenerarQR`). El código fuente está en `tools/excel/src/`. Para regenerar los ZIP de `public/descargas/` (módulo `.bas`, complemento `.xlam`, libro de ejemplo `.xlsm` e instrucciones) en un equipo con Excel para Windows:

```
pwsh -File tools/excel/build.ps1
```

El script compara cada función con los 160 casos de `tests/fixtures/numwords_cases.json` y cada QR con el codificador del sitio antes de generar las descargas. Activa temporalmente el acceso al modelo de objetos de VBA y lo deja como estaba.

## 7. Pruebas

```bash
php vendor/bin/phpunit           # PHP: importador, i18n, SEO, pagos, cuenta, búsqueda, panel, rutas
node tests/js/numwords.test.mjs  # paridad JS del conversor de número a letras
```

Las pruebas de integración usan la base configurada en `.env` y limpian lo que crean. Las de pagos simulan las APIs de las pasarelas (firmas válidas e inválidas, duplicados, monto distinto y compra completa hasta la descarga).

## 8. Estructura

```
public/            index.php (front controller), assets/{css,js,img,fonts}, robots.txt, .htaccess
src/Core           App, Router, Request, Response, DB, View, Csrf, Session, Mailer, Cache, RateLimiter, Migrator…
src/Controllers    Sitio público (portada, contenido, tienda, pago, pedido, cuenta, herramientas, SEO, webhooks)
src/Admin          Panel
src/Models         Post, Hub, Product, Family, Setting
src/Services       Payments (MercadoPago, Wompi, PayPal), Orders, Downloads, I18n, Seo, Search, Importer, Content, Mail, Tools
templates/         layouts, partials, pages, admin, emails/{es,en}
lang/              es.php, en.php, admin.es.php
database/          migrations/*.sql, seeds/*.php, seeds/en/ (traducciones)
bin/console        Comandos
storage/           import, downloads, cache, logs (fuera de la web)
deploy/            nginx.conf, cron.txt, CHECKLIST.md
tests/             PHPUnit + prueba JS
```
