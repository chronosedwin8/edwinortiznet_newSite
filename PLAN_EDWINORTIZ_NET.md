# edwinortiz.net — especificación de reconstrucción (para Claude Code)

Reconstruye https://www.edwinortiz.net, hoy en WordPress + WooCommerce + Elementor, como una aplicación propia en **PHP 8.2+ y MySQL 8**, con frontend en **HTML, CSS y JavaScript sin frameworks**, tienda de descargas digitales y sitio **bilingüe: español e inglés**. Pagos: **Mercado Pago y Wompi en español (COP)** y **PayPal en inglés (USD)**; ninguna otra pasarela. El sitio debe ser moderno, dinámico, rápido y optimizado para SEO, y debe conservar todas las URLs actuales.

Trabaja por fases, en orden. Al terminar cada fase ejecuta sus criterios de aceptación, haz commit y continúa. No te detengas a pedir confirmación salvo en los puntos marcados **[DECISIÓN DE EDWIN]**; en esos casos aplica el valor por defecto indicado, déjalo anotado en `PENDIENTES.md` y sigue.

El español de Colombia (`lang="es-CO"`) es el idioma principal y vive en la raíz del dominio; el inglés (`lang="en"`) vive bajo `/en/`. Tono cercano y directo en ambos. Los detalles están en la sección 4A.

---

## 1. Contexto

- **Dueño:** Edwin Ortiz Herazo, docente de matemáticas y tecnología con más de 20 años de experiencia, Licenciado en Matemáticas y Física, Magíster en Ingeniería de Sistemas y Magíster en Educación. Barranquilla, Colombia.
- **Posicionamiento nuevo:** "Edwin Ortiz Herazo: automatización, IA y tecnología para docentes y oficinas".
- **Modelo:** el blog trae tráfico; cada artículo conduce a un producto, una herramienta gratuita o una suscripción por correo. AdSense es ingreso secundario.
- **Público:** (1) personal de oficina que automatiza Excel y Word, (2) docentes, (3) aspirantes al Concurso Docente de Colombia.

## 2. Archivos de origen

En la carpeta del proyecto hay tres exportaciones WXR 1.2 de WordPress. Localízalas por nombre (`*productos*.xml`, `*Entradas*.xml`, `*paginas*.xml`) y muévelas a `storage/import/`. No las publiques en el webroot.

| Archivo | Contenido verificado |
| --- | --- |
| Entradas | 64 entradas publicadas, 285 adjuntos, 1 autor (`edwinortiz`), 0 comentarios |
| Páginas | 18 páginas publicadas, 48 adjuntos |
| Productos | 21 productos publicados, 105 adjuntos |

Datos del contenido que el importador debe manejar:

- El cuerpo viene en `content:encoded` como HTML de Gutenberg (comentarios `<!-- wp:... -->`). Bloques presentes: paragraph, heading, list, image, embed (70), html (41), table, quote, columns, button, spacer, separator, `woocommerce/handpicked-products` (10), `woocommerce/product-tag`, `contentviews/grid1`, `tomsneddon-video-player`, `tomsneddon-image-slider`, `yoast-seo/estimated-reading-time`.
- Shortcodes presentes: `[pt_view]` (16), `[caption]` (11), `[embed]`, `[woocommerce_cart]`, `[woocommerce_checkout]`, `[woocommerce_my_account]`.
- Imagen destacada: `_thumbnail_id` apunta a un adjunto del mismo XML (`wp:attachment_url`). 27 entradas usan además `fifu_image_url` (imagen externa); úsalo cuando exista.
- Las imágenes están en `blogedwinortiznet.s3.amazonaws.com` (435 adjuntos). **Esas URLs se conservan tal cual**; no descargues ni muevas imágenes.
- SEO de Yoast en postmeta: `_yoast_wpseo_metadesc` (solo 22 de 64 entradas la tienen), `_yoast_wpseo_focuskw`, `_yoast_wpseo_title`, `_yoast_wpseo_primary_category`.
- Productos: `_price`, `_regular_price`, `_sku`, `_downloadable`, `_virtual`, `_downloadable_files` (PHP serializado), `_product_image_gallery`, `total_sales`, taxonomías `product_cat` y `product_visibility`. La descripción corta está en `excerpt:encoded`.
- Hay unos 140 enlaces o embebidos de YouTube y 35 enlaces a `fundales.com` en el contenido.

### Catálogo actual (21 productos, 286 ventas históricas)

| ID WP | Slug | Precio USD | Ventas | Visible | Archivo hoy |
| --- | --- | --- | --- | --- | --- |
| 380 | enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco | 25 | 113 | sí | S3 |
| 376 | combinar-correspondencia-y-guardar-documentos-independientes | 30 | 54 | sí | servidor WP |
| 409 | generador-de-codigos-qr-masivos | 15 | 49 | sí | S3 |
| 413 | generador-codigos-qr-de-productos-individuales | 10 | 35 | sí | S3 |
| 358 | combinar-correspondencia-y-generar-pdf-individuales | 20 | 12 | sí | servidor WP |
| 436 | plantilla-en-excel-de-factura-sencilla-numeracion-automatica | 10 | 11 | sí | servidor WP |
| 396 | convertidor-de-numeros-a-letras-en-excel | 10 | 9 | sí | servidor WP |
| 420 | factura-con-envio-por-correo-al-cliente | 20 | 1 | sí | servidor WP |
| 664 | generador-de-codigos-qr-masivos-a-imagenes-png | 30 | 1 | sí | S3 |
| 713 | generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras | 25 | 1 | sí | S3 |
| 706 | generador-de-codigos-de-barras-masivos-a-png | 50 | 0 | sí | S3 |
| 816 | aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf | 70 | 0 | sí | S3 (`archivosedwin`) |
| 349 | listado-de-asistencia-laboral-o-academica-en-excel | 10 | 0 | sí | servidor WP |
| 373 | soporte-plus-para-las-plantillas-de-excel (servicio) | 30 | 0 | sí | no aplica |
| 371 | curso-aptitud-matematica-…-2021 (curso, sin descripción) | 20 | 0 | sí | no aplica |
| 382 | grupo-de-5-presentaciones-de-interland-ciudadania-digital | 15 | 0 | oculto | servidor WP |
| 385, 388, 390, 392, 394 | cinco presentaciones de Interland sueltas | 4 c/u | 0 | oculto | servidor WP |

Lectura del historial: correo masivo, combinar documentos y QR concentran 265 de las 286 ventas. Son las familias que la portada y la tienda deben destacar.

**Archivos descargables.** 12 productos tienen su archivo en `www.edwinortiz.net/wp-content/uploads/woocommerce_uploads/...`, que desaparece al apagar WordPress; 7 están en buckets S3 con URL pública. El importador guarda la URL original en `product_files.source_url` y deja `storage_path` vacío. Edwin copiará los archivos a `storage/downloads/` (fuera del webroot); crea el comando `php bin/console downloads:check` que liste qué productos aún no tienen archivo local. Un producto sin archivo local no se puede comprar: muestra "Disponible pronto".

## 3. Stack y restricciones

- PHP 8.2+, `declare(strict_types=1)`, PSR-4, PSR-12. Sin framework. Composer permitido solo para `phpmailer/phpmailer` y `vlucas/phpdotenv`; el resto es código propio. Las pasarelas se consumen por REST con cURL, sin SDK.
- MySQL 8, `utf8mb4_unicode_ci`, InnoDB, acceso solo con PDO y sentencias preparadas. Migraciones SQL numeradas en `database/migrations/` y un ejecutor `php bin/console migrate`.
- Frontend: plantillas PHP que entregan HTML semántico; un `main.css` propio (objetivo < 50 KB) y JavaScript en módulos ES sin dependencias (objetivo < 100 KB por página). Nada de jQuery, Bootstrap, Tailwind ni CDN de terceros para CSS o JS.
- Servidor: front controller único. Entrega `deploy/nginx.conf` y también `public/.htaccess` equivalente.
- Secretos en `.env` fuera del webroot; incluye `.env.example` completo.

### Estructura

```
/public            index.php, assets/{css,js,img,fonts}, robots.txt
/src               Core (Router, Request, Response, DB, View, Csrf, Mailer, Cache)
                   Controllers, Models, Services (Payments/MercadoPago, Payments/Wompi, Payments/PayPal, I18n,
                   Orders, Downloads, Seo, Search, Importer), Admin
/templates         layouts, partials, pages, admin, emails/{es,en}
/lang              es.php, en.php (cadenas de interfaz)
/database          migrations, seeds
/bin/console       migrate, import:wxr, downloads:check, sitemap:build, admin:create
/storage           import, downloads, cache, logs   (todo fuera del webroot)
/deploy            nginx.conf, cron.txt, CHECKLIST.md
/tests             pruebas PHPUnit de firmas, pedidos e importador
```

## 4. URLs y redirecciones

Regla principal: **ninguna URL indexada cambia**. Todas terminan en `/`; la versión sin barra redirige con 301.

| Ruta | Qué muestra |
| --- | --- |
| `/` | Portada nueva |
| `/blog/` y `/blog/pagina/N/` | Listado de artículos (10 por página) |
| `/{slug}/` | Entrada o página importada (mismo slug de WordPress) |
| `/producto/{slug}/` | Ficha de producto |
| `/tienda/` | Catálogo con filtros |
| `/categoria-producto/{slug}/` | Catálogo filtrado por familia |
| `/excel/`, `/concurso-docente/`, `/ia-para-docentes/`, `/herramientas/` | Hubs |
| `/herramientas/{slug}/` | Herramienta gratuita |
| `/sobre-mi/`, `/contacto/`, `/politicas/{slug}/` | Institucionales |
| `/carrito/`, `/finalizar-compra/`, `/mi-cuenta/` | Tienda (mismas rutas de WooCommerce) |
| `/pedido/{token}/` | Estado del pedido y descargas |
| `/buscar/?q=` y `/api/buscar?q=` | Búsqueda |
| `/admin/` | Panel |
| `/sitemap.xml`, `/feed/`, `/robots.txt` | SEO |

Redirecciones 301 que debes sembrar en la tabla `redirects`: `/page/N/` → `/blog/pagina/N/`; `/author/edwinortiz/` → `/sobre-mi/`; `/category/{x}/` → hub correspondiente (Excel, Oficina, Correos Masivos → `/excel/`; Concurso Docente → `/concurso-docente/`; resto → `/blog/`); `/?add-to-cart={id}` → ficha del producto con ese ID de WordPress; `/archivos-gratis/` → `/herramientas/`; `/blog` (página vacía de WP) → `/blog/`. El router consulta `redirects` antes de responder 404 y registra los 404 en `not_found_log` para revisarlos en el panel.

`/excel/` existe hoy como página "Curso de Excel para profesionales" (442 caracteres): su contenido se integra en el hub nuevo, misma URL. `/cursos/` hoy está vacía: conviértela en listado de cursos (productos tipo curso + listas de YouTube enlazadas en `/cursos-de-informatica-y-tecnologia/`).

## 4A. Multilingüe: español e inglés

- **Rutas.** El español conserva las URLs actuales en la raíz. El inglés usa el prefijo `/en/` con slugs traducidos: `/en/`, `/en/blog/`, `/en/{slug}/`, `/en/product/{slug}/`, `/en/shop/`, `/en/tools/{slug}/`, `/en/about/`, `/en/contact/`, `/en/policies/{slug}/`, `/en/cart/`, `/en/checkout/`, `/en/account/`, `/en/order/{token}/`. El router resuelve el idioma por el prefijo, nunca por cookie ni por IP.
- **Sin redirección automática.** No redirijas por IP ni por `Accept-Language`. Si el navegador prefiere inglés y la página tiene versión en inglés, muestra una franja descartable "This page is available in English". El conmutador de idioma de la cabecera lleva a la traducción de la misma página; si no existe, a la portada del otro idioma.
- **Interfaz.** Todas las cadenas salen de `lang/es.php` y `lang/en.php` mediante un helper `t('clave', [params])`. Ninguna cadena visible queda escrita en las plantillas. Fechas, números y moneda se formatean por idioma con `IntlDateFormatter` y `NumberFormatter`.
- **Contenido.** `posts` lleva `locale` (`es|en`) y `translation_group` (mismo valor para las versiones de un mismo contenido); slug único por idioma. Los productos son una sola fila con precio, archivos y familia, y sus textos van en `product_translations` (product_id, locale, slug, title, short_html, description_html, requirements, license_text, seo_title, seo_description). Igual para `hubs`, `product_families` y `categories` (tablas `*_translations`).
- **Qué se traduce al inglés en el lanzamiento** (tradúcelo tú, en inglés internacional natural, y marca cada registro `needs_review = 1` para que Edwin lo revise en el panel):
  - Interfaz completa, correos, portada, tienda, carrito, pago, cuenta, sobre mí, contacto y políticas.
  - Los 15 productos visibles y sus familias. Las 6 presentaciones de Interland no.
  - Los hubs `excel` (→ `/en/excel-automation/`) y `herramientas` (→ `/en/tools/`), y un hub `/en/ai-for-teachers/`.
  - Las herramientas Generador de QR y Número a letras (versión *Number to words* en inglés, con su propio algoritmo y pruebas).
  - Los artículos tutoriales enlazados a un producto visible (los de correos masivos, combinar correspondencia, códigos QR, códigos de barras y número a letras; son unos 12). **[DECISIÓN DE EDWIN]** ampliar o reducir la lista.
- **Qué no se traduce:** el hub y las 8 entradas del Concurso Docente, el simulacro, y los artículos sobre temas colombianos (Wompi, educación virtual en colegios públicos, CNSC). Existen solo en español y no llevan `hreflang`.
- **Aviso en fichas en inglés:** las plantillas y sus capturas están en español. Cada ficha en inglés muestra "The template interface is in Spanish; an English quick-start guide is included" hasta que Edwin marque el producto con `has_english_version = 1`. **[DECISIÓN DE EDWIN]** decidir qué productos tendrán versión en inglés; es lo que más afectará reembolsos de compradores en inglés.
- **SEO multilingüe.** Cada página con traducción emite `<link rel="alternate" hreflang="es-CO">`, `hreflang="en"` y `hreflang="x-default"` (apuntando al español), recíprocos y con URL absoluta; el canonical apunta siempre a sí misma. El sitemap incluye las alternativas con `xhtml:link`. Open Graph usa `og:locale` `es_CO` o `en_US` con `og:locale:alternate`. El JSON-LD lleva `inLanguage`, y `Offer` usa COP en español y USD en inglés. Feed propio en `/en/feed/`. Título de la portada en inglés: "Edwin Ortiz Herazo | Excel automation & AI for teachers".
- **Moneda y pasarela por idioma.** En español se muestra y cobra en COP con Mercado Pago o Wompi. En inglés se muestra y cobra en USD (`price_usd`) solo con PayPal. El idioma del pedido se guarda en `orders.locale` y determina la moneda, las pasarelas ofrecidas, el idioma de los correos y la página de retorno. El servidor rechaza cualquier combinación distinta (por ejemplo, PayPal en un pedido en español). En inglés no existe el selector COP/USD.

## 5. Base de datos

Crea al menos estas tablas, con índices y claves foráneas:

- `posts` (id, wp_id, type `post|page`, slug único, title, excerpt, content_html, cover_url, cover_alt, hub_id, status `published|draft|noindex`, seo_title, seo_description, focus_keyword, reading_minutes, published_at, updated_at) con índice FULLTEXT (title, excerpt, content_text).
- `categories`, `post_category`.
- `hubs` (slug, title, intro_html, seo_title, seo_description).
- `products` (id, wp_id, slug único, sku, title, short_html, description_html, family_id, audience `oficina|docente|concurso`, type `download|service|course|pack`, price_usd, price_cop, status `active|hidden|coming_soon`, featured, cover_url, video_url, requirements, license_text, legacy_sales, seo_title, seo_description) con FULLTEXT.
- `product_families`, `product_images`, `product_files` (product_id, label, source_url, storage_path, version, bytes), `pack_items`.
- `orders` (id, reference única, token único, email, name, document, phone, locale `es|en`, currency `COP|USD`, subtotal, total, status `pending|approved|declined|voided|refunded|error`, gateway `mercadopago|wompi|paypal`, gateway_id, paid_at, ip, created_at), `order_items`.
- `payment_events` (gateway, event_id, order_id, payload JSON, signature_ok, processed_at) con único (gateway, event_id) para idempotencia.
- `download_grants` (order_item_id, token, max_downloads 5, downloads, expires_at) y `download_log`.
- `customers` (email único) y `login_tokens` para enlace mágico.
- Tablas de traducción descritas en la sección 4A y columnas `locale`, `translation_group` y `needs_review` en `posts`.
- `subscribers` (email, locale, source, tag, confirmed_at, token) y `waitlist` (product_id, email).
- `redirects`, `not_found_log`, `admin_users`, `settings` (clave/valor), `quiz_questions` (para el simulacro).

## 6. Importador (`php bin/console import:wxr`)

Idempotente: se puede ejecutar varias veces; usa `wp_id` para actualizar en vez de duplicar. Imprime un resumen final que debe coincidir con: **64 entradas, 18 páginas, 21 productos**. Todo lo importado entra con `locale = es`; las traducciones al inglés se crean después con un seed aparte (`database/seeds/en/`), nunca dentro del importador.

Limpieza del HTML al importar:

1. Quita los comentarios de bloque de Gutenberg y los `spacer`.
2. Pasa el HTML por una lista blanca (p, h2–h4, ul, ol, li, a, img, figure, figcaption, table, blockquote, pre, code, strong, em, iframe solo de YouTube). Elimina `style`, clases de WordPress y scripts.
3. Si el cuerpo trae un H1, bájalo a H2: el único H1 es el título.
4. `[caption]` → `<figure><figcaption>`. Embebidos y `[embed]` de YouTube → componente "lite" (miniatura + botón; el iframe de `youtube-nocookie.com` se carga al hacer clic).
5. `woocommerce/handpicked-products` y `product-tag` → marcador `{{productos:slug1,slug2}}` que la plantilla resuelve como tarjetas de producto. `[pt_view]` y `contentviews` → marcador `{{articulos:hub}}`. Bloques de `tomsneddon` → `<video>` o galería simple si traen URL; si no, se eliminan.
6. A cada `<img>`: `loading="lazy"`, `decoding="async"`, `alt` (del adjunto si existe; si no, derivado del título) y `width`/`height` cuando el adjunto los traiga en `_wp_attachment_metadata`.
7. Enlaces a `fundales.com`: añade `rel="noopener"` y `?utm_source=edwinortiz.net&utm_medium=articulo&utm_campaign={slug}`.
8. Enlaces de afiliado de Lenovo (`lenovo-co.5nfc.net`): `rel="sponsored nofollow"`.
9. Genera `content_text` (sin etiquetas) para búsqueda, `reading_minutes` y, cuando falte `seo_description`, un borrador de 150 a 160 caracteres tomado del primer párrafo, marcado `seo_auto = 1` para que Edwin lo revise en el panel.
10. Las páginas `/tienda`, `/carrito`, `/finalizar-compra`, `/mi-cuenta`, `/blog` y `/cursos` no se importan como contenido: son rutas de la aplicación.

Asignación de hubs por categoría de WordPress: Excel, Oficina, Correos Masivos → `excel`; Concurso Docente → `concurso-docente`; Educación, Para Profesores, Pensamiento Computacional, Ciudadanía Digital, Realidad Aumentada, Infografías → `ia-para-docentes` (renómbralo en pantalla "IA y tecnología para docentes"); el resto queda sin hub y aparece solo en `/blog/`.

Tratamiento editorial de contenido antiguo (aplícalo con un seed después de importar):

| Contenido | Acción |
| --- | --- |
| 8 entradas del Concurso Docente (enero de 2026) | Inserta al inicio un aviso fechado: "Actualización: la CNSC trasladó las inscripciones a enero–febrero de 2027 y las pruebas escritas al segundo semestre de 2027. Las fechas definitivas se publican en cnsc.gov.co." No reescribas el cuerpo. **[DECISIÓN DE EDWIN]** revisar el texto del aviso |
| Dos entradas de Microsoft 365 Copilot (22-05-2023) | Conserva `microsoft-365-copilot-la-revolucion-…`; la otra redirige con 301 a ella |
| `restar-horas-en-excel` y `como-restar-horas-en-excel-horas-laborales` | Canonical de la primera hacia la segunda (más completa) |
| `los-mejores-portatiles-baratos-y-rapidos`, `cual-es-la-mejor-laptop-para-estudiantes-…` (2020, afiliados) | `noindex` y fuera de listados. **[DECISIÓN DE EDWIN]** |
| `descargar-audio-y-videos-de-youtube-gratis-y-sin-programas` | `noindex` y sin anuncios (riesgo con las políticas de AdSense). **[DECISIÓN DE EDWIN]** |
| `western-union-dejara-de-estar-disponible-en-youtube-…`, `hosting-y-dominio-gratis-por-siempre-…`, `como-obtener-filmora-9-x` | Se conservan con aviso "Artículo de {año}; puede estar desactualizado" |
| Página `/projekttag/` | Se conserva sin enlazar y con `noindex`. **[DECISIÓN DE EDWIN]** |
| Las 6 presentaciones de Interland (ocultas, 0 ventas) | Se importan con `status = hidden` |

No fusiones más artículos por tu cuenta: faltan los datos de Search Console para decidirlo.

## 7. Diseño y frontend

Usa un sistema de diseño propio definido con variables CSS en `:root`; modo oscuro con `prefers-color-scheme` y un conmutador que recuerda la elección.

- **Carácter:** editorial y técnico, claro, con mucho aire. Evita el aspecto de plantilla genérica: nada de degradados morados, tarjetas idénticas en rejilla infinita ni iconos decorativos sin función.
- **Color:** fondo casi blanco cálido, texto casi negro, un color de marca (parte de azul petróleo `#0E5A6B` y ajústalo cuando Edwin entregue el logo) y un color de acción reservado para los botones de compra (ámbar `#E8A013`). Contraste AA como mínimo.
- **Tipografía:** dos familias variables alojadas en `/assets/fonts` (WOFF2, `font-display: swap`): una con carácter para títulos y una de lectura para el cuerpo. Cuerpo de 18 px, línea máxima de 70 caracteres, escala fluida con `clamp()`.
- **Maquetación:** mobile-first con CSS Grid y container queries. Sin desplazamiento horizontal desde 320 px.

Plantillas:

1. **Portada.** Titular "Automatiza tu trabajo de oficina y de aula", subtítulo con la propuesta de valor, dos botones (Ver herramientas / Soy docente). Tres entradas por perfil (Trabajo en oficina, Soy docente, Me preparo para el concurso). Productos más vendidos (ordenados por `legacy_sales` + ventas nuevas). Herramientas gratis. Últimos artículos por hub. Bloque de autor. Suscripción.
2. **Hub.** Introducción de 150 a 250 palabras, guía pilar destacada, artículos del hub, productos relacionados, preguntas frecuentes con marcado FAQPage.
3. **Artículo.** Migas, fecha de publicación y de actualización, tiempo de lectura, tabla de contenido generada desde los H2, barra de progreso, tarjeta de producto relacionada después del segundo H2 y al final, caja de autor, artículos hermanos, suscripción.
4. **Tienda.** Filtros por perfil, familia y precio que actúan sin recargar y actualizan la URL (`?perfil=docente`); tabla comparativa por familia.
5. **Producto.** Galería, video lite, precio en COP con referencia en USD (en inglés, solo USD), botón de compra fijo en móvil, qué incluye, requisitos, licencia, política de reembolso, preguntas frecuentes, tutorial relacionado, otros productos de la familia.
6. **Carrito y pago.** Una sola página: resumen, datos (nombre, correo, documento, teléfono), elección de pasarela, aceptación de términos.
7. **Sobre mí, contacto, políticas** (privacidad y tratamiento de datos según la Ley 1581 de 2012, términos, reembolsos, cookies). Redacta borradores y márcalos **[DECISIÓN DE EDWIN]** para revisión.

Comportamiento dinámico (JavaScript propio, con mejora progresiva: todo funciona sin JS salvo el buscador instantáneo y las herramientas):

- Buscador instantáneo en la cabecera: `fetch` a `/api/buscar` con espera de 200 ms, resultados agrupados en artículos y productos, navegable con teclado, atajo `/`.
- View Transitions API entre páginas, con respaldo sin animación.
- Aparición al hacer scroll con IntersectionObserver; todo movimiento se apaga con `prefers-reduced-motion`.
- Carrito en un panel lateral (estado en `localStorage` y validado en servidor al pagar).
- En español, selector COP/USD que recuerda la preferencia (el cobro siempre es en COP). En inglés, solo USD.
- Conmutador de idioma ES/EN en cabecera y pie, según la sección 4A.
- Botón flotante de WhatsApp (`https://wa.me/573162830615`), el mismo número del sitio actual.

## 8. SEO

- `<title>` de 50 a 60 caracteres y meta descripción de 150 a 160, editables por registro. Portada: título "Edwin Ortiz Herazo | Excel, IA y tecnología educativa"; descripción "Plantillas de Excel automatizadas, herramientas gratis y guías de IA para docentes y oficinas. Más de 20 años enseñando matemáticas y tecnología en aula."
- Canonical absoluto, atributo `lang` según el idioma, `hreflang` según la sección 4A, Open Graph y Twitter Card con imagen de 1200 × 630, `robots` por registro.
- JSON-LD: `Person` + `WebSite` con `SearchAction` en la portada; `Article` con `datePublished` y `dateModified`; `Product` con `Offer` (precio en COP, disponibilidad); `BreadcrumbList` en todo; `FAQPage` en hubs y fichas; `Course` en cursos. No generes `AggregateRating` sin reseñas reales.
- `/sitemap.xml` dinámico con `lastmod`, sin páginas `noindex`; `/feed/` RSS 2.0; `robots.txt` que bloquea `/admin/`, `/carrito/`, `/finalizar-compra/`, `/mi-cuenta/`, `/pedido/`, `/api/`.
- Enlazado interno automático: cada artículo enlaza a su hub, a dos hermanos y a un producto; cada producto, a su tutorial (relación editable en el panel).
- Rendimiento: caché de página completa en disco para visitantes sin carrito (se invalida al guardar en el panel), `ETag`, compresión, CSS crítico en línea, `preload` de la fuente principal y de la imagen LCP, `srcset` cuando el adjunto tenga tamaños. Metas: LCP < 2,5 s, INP < 200 ms, CLS < 0,1, Lighthouse móvil ≥ 95 en portada, artículo, tienda y producto.
- Analítica y anuncios: GA4 y AdSense se cargan solo tras el consentimiento de cookies y de forma diferida. AdSense solo en artículos (máximo tres bloques, con espacio reservado para no mover el contenido); nunca en portada, hubs, tienda, fichas, pago ni herramientas. IDs en `.env`.

## 9. Tienda, pedidos y descargas

- Compra como invitado, solo con correo. Sin registro obligatorio.
- **Moneda:** Wompi y Mercado Pago Colombia cobran en pesos; PayPal cobra en dólares. En español se cobra `price_cop` y `price_usd` es referencia visual; en inglés se cobra `price_usd`. El seed calcula `price_cop = price_usd × USD_COP_RATE` (variable de `.env`), redondeado al millar, editable después en el panel. **[DECISIÓN DE EDWIN]** fijar la tasa y revisar precios.
- Los 15 productos visibles conservan su precio y siguen a la venta. Agrúpalos en familias: Combinador de documentos (358, 376, 816), QR y códigos de barras (409, 413, 664, 706, 713), Correo masivo (380), Documentos comerciales (396, 420, 436), Docentes (349, 371), Servicios (373).
- Siembra tres packs (`type = pack`, `status = coming_soon`): Pack Oficina (USD 99), Pack Docente (USD 79), Todo incluido anual (USD 149).
- Siembra diez productos nuevos con `status = coming_soon`, ficha completa y formulario "Avísame cuando salga" que escribe en `waitlist`. Sirve para medir demanda antes de fabricarlos:

| Producto | Perfil | Precio USD sugerido |
| --- | --- | --- |
| Certificados y diplomas masivos con QR de verificación | oficina | 60 |
| Kit Concurso Docente 2027 | concurso | 25 |
| Boletines e informes con observaciones | docente | 35 |
| Kit de IA para docentes | docente | 15 |
| Generador de exámenes en varias versiones | docente | 30 |
| Asistencia con QR desde el celular | docente | 30 |
| Correo masivo para Excel web y Mac | oficina | 35 |
| Inventario de activos fijos completo | oficina | 60 |
| Cotizaciones y cuentas de cobro | oficina | 20 |
| Curso: IA para docentes | docente | 40 |

- **Flujo del pedido:** carrito → `POST /finalizar-compra/` (o `/en/checkout/`) crea el pedido `pending` con `reference` única (`EO-{año}-{aleatorio}`) y `token` de 32 bytes → redirección a la pasarela → retorno a `/pedido/{token}/`, que muestra "confirmando pago" y consulta el estado cada 3 s → el webhook aprueba el pedido → se crean los `download_grants` y se envía el correo con los enlaces.
- **Fuente de verdad:** el pedido solo pasa a `approved` desde el webhook verificado o desde una consulta servidor a servidor a la API de la pasarela. Nunca desde los parámetros de la URL de retorno. Verifica siempre que el monto y la moneda pagados coincidan con el pedido.
- **Descargas:** `/descarga/{token}/` valida vigencia (30 días) y límite (5), registra en `download_log` y entrega el archivo desde `storage/downloads/` con `X-Accel-Redirect` (Nginx) o `readfile` por bloques. Los archivos nunca tienen URL pública.
- **Mi cuenta:** acceso por enlace mágico al correo (token de un solo uso, 15 minutos); lista pedidos y permite regenerar enlaces vencidos.
- **Correos** (PHPMailer por SMTP, plantillas HTML y texto): pedido recibido, pago aprobado con descargas, pago rechazado, enlace mágico, confirmación de suscripción (doble opt-in), aviso al administrador por cada venta.
- **Tarea programada** (`deploy/cron.txt`): cada 10 minutos consulta en la pasarela los pedidos `pending` de más de 15 minutos; a las 24 horas los marca `voided`.

## 10. Pasarelas de pago

Implementa una interfaz `PaymentGateway` (`createCheckout(Order): string`, `handleWebhook(Request): WebhookResult`, `fetchStatus(Order): Status`) con tres adaptadores. Un `GatewayResolver` devuelve las pasarelas permitidas según `orders.locale`: `es` → Mercado Pago y Wompi; `en` → PayPal. Credenciales y modo `sandbox|production` en `.env`. **Antes de programar cada adaptador, consulta la documentación oficial vigente y ajusta lo que difiera de lo descrito aquí.**

### Mercado Pago (Checkout Pro)

- Crear preferencia: `POST https://api.mercadopago.com/checkout/preferences` con `Authorization: Bearer {MP_ACCESS_TOKEN}`; `items` (título, cantidad, `unit_price`, `currency_id: "COP"`), `payer.email`, `external_reference = order.reference`, `back_urls` hacia `/pedido/{token}/`, `auto_return: "approved"`, `notification_url = /webhooks/mercadopago`. Redirige al `init_point`.
- Webhook: valida la cabecera `x-signature` (`ts` y `v1`) calculando HMAC-SHA256 con `MP_WEBHOOK_SECRET` sobre el manifiesto `id:{data.id};request-id:{x-request-id};ts:{ts};`. Luego consulta `GET /v1/payments/{id}` y usa `status`, `transaction_amount`, `currency_id` y `external_reference` de esa respuesta, no del cuerpo recibido.
- Estados: `approved` → approved; `rejected` y `cancelled` → declined; `refunded` y `charged_back` → refunded; `pending` e `in_process` → pending.

### Wompi

- Checkout web: redirección a `https://checkout.wompi.co/p/` con `public-key`, `currency=COP`, `amount-in-cents`, `reference`, `redirect-url` y `signature:integrity = SHA256(reference + amount_in_cents + currency + WOMPI_INTEGRITY_SECRET)`.
- Webhook `/webhooks/wompi` (evento `transaction.updated`): valida el checksum SHA256 de la concatenación de los valores listados en `signature.properties`, más `timestamp`, más `WOMPI_EVENTS_SECRET`, y compáralo con `signature.checksum`. Después confirma con `GET {base}/v1/transactions/{id}` (`https://sandbox.wompi.co` o `https://production.wompi.co`).
- Estados: `APPROVED` → approved; `DECLINED` y `ERROR` → declined o error; `VOIDED` → voided; `PENDING` → pending.

### PayPal (solo pedidos en inglés, USD)

- API Orders v2 con cuenta PayPal Business. Base `https://api-m.sandbox.paypal.com` o `https://api-m.paypal.com`. Token: `POST /v1/oauth2/token` con `PAYPAL_CLIENT_ID` y `PAYPAL_CLIENT_SECRET` (guárdalo en caché hasta que venza).
- Crear orden: `POST /v2/checkout/orders` con `intent: "CAPTURE"`, una `purchase_unit` con `amount` en `USD` y desglose de artículos, `custom_id = order.reference`, `invoice_id = order.reference`, y `return_url` / `cancel_url` hacia `/en/order/{token}/`. Envía la cabecera `PayPal-Request-Id = order.reference` para idempotencia. Redirige al enlace `approve` (o `payer-action`) de la respuesta.
- Al volver el comprador: `POST /v2/checkout/orders/{id}/capture` desde el servidor. El pedido se aprueba solo si la captura responde `COMPLETED` y el monto y la moneda capturados coinciden con el pedido.
- Webhook `/webhooks/paypal` (eventos `PAYMENT.CAPTURE.COMPLETED`, `PAYMENT.CAPTURE.DENIED`, `PAYMENT.CAPTURE.REFUNDED`, `PAYMENT.CAPTURE.REVERSED`): verifica cada evento con `POST /v1/notifications/verify-webhook-signature` usando las cabeceras `PAYPAL-TRANSMISSION-*` y `PAYPAL_WEBHOOK_ID`; procesa solo si responde `SUCCESS`. Sirve de respaldo si el comprador cierra la ventana antes de la captura y para registrar reembolsos y contracargos.
- Estados: `COMPLETED` → approved; `DENIED` → declined; `REFUNDED` y `REVERSED` → refunded (revoca los `download_grants`); `PENDING` → pending.

Para las tres: compara firmas con `hash_equals` (en PayPal, usa la verificación por API); guarda cada evento en `payment_events` y descarta duplicados; responde 200 rápido cuando la firma es válida y 401 cuando no; procesa dentro de una transacción con `SELECT … FOR UPDATE` sobre el pedido. Escribe pruebas PHPUnit con cuerpos de ejemplo para firma válida, firma inválida, evento duplicado y monto que no coincide.

## 11. Herramientas gratuitas

Tres para el lanzamiento (las dos primeras también en inglés; el simulacro solo en español), todas en el navegador y sin enviar datos al servidor, cada una con texto explicativo indexable, preguntas frecuentes y un producto de pago relacionado:

1. **Generador de código QR** (`/herramientas/generador-qr/`): texto o URL, tamaño, descarga en PNG y SVG. Implementa el codificador QR en un módulo propio. Enlaza al generador masivo.
2. **Número a letras** (`/herramientas/numero-a-letras/`): convierte montos a texto en español, con opción "pesos M/CTE". Con pruebas para 0, 1, 21, 100, 101, 1.000, 1.000.000, 1.001.001 y decimales.
3. **Simulacro del Concurso Docente** (`/herramientas/simulacro-concurso-docente/`): 10 preguntas al azar desde `quiz_questions`, con retroalimentación y puntaje; al final ofrece enviar el resultado por correo (captura de suscriptor con etiqueta `concurso`). Crea la estructura y la carga desde el panel; **no inventes preguntas**: siembra solo dos de ejemplo marcadas como demostración. **[DECISIÓN DE EDWIN]** cargar el banco real.

## 12. Panel de administración (`/admin/`)

Sesión con `password_hash` (Argon2id), límite de intentos y cookies `HttpOnly`, `Secure`, `SameSite=Lax`. El primer usuario se crea con `php bin/console admin:create`. Secciones: escritorio (ventas de 30 días, pedidos pendientes, suscriptores, 404 recientes, productos sin archivo); artículos y páginas (editor HTML con vista previa y campos SEO con contador de caracteres; pestañas ES/EN por registro, filtro "traducciones por revisar" y botón para crear la versión en inglés a partir de la española); productos, familias, packs y archivos (subida a `storage/downloads/`); pedidos (detalle, eventos de pago, reenviar correo, regenerar descargas); suscriptores y lista de espera (exportar CSV); redirecciones; banco de preguntas; ajustes.

## 13. Seguridad

- CSRF en todos los formularios; salida escapada por defecto en las plantillas; HTML de artículos solo desde la lista blanca.
- Cabeceras: CSP estricta (permite solo lo necesario para YouTube, GA4, AdSense y las pasarelas), HSTS, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`.
- Límite de peticiones por IP en acceso, pago, suscripción, búsqueda y contacto. Honeypot y marca de tiempo en formularios públicos.
- Validación en servidor de precios y totales: el cliente nunca envía montos.
- Registros sin datos sensibles; errores detallados solo con `APP_DEBUG=true`.

## 14. Fases y criterios de aceptación

1. **Base.** Estructura, router, PDO, migraciones, plantillas, consola, `.env.example`. *Listo cuando:* `migrate` crea el esquema desde cero y `/` responde 200.
2. **Importación.** `import:wxr` y seeds editoriales. *Listo cuando:* el resumen dice 64 / 18 / 21, una segunda ejecución no duplica nada y un script recorre todos los slugs importados y obtiene 200 en `/{slug}/` y `/producto/{slug}/`.
3. **Sistema de diseño y plantillas.** *Listo cuando:* las siete plantillas se ven bien a 360, 768 y 1280 px en claro y oscuro (revísalas con capturas) y no hay errores en consola.
3A. **Multilingüe.** Rutas `/en/`, `lang/*.php`, tablas de traducción, seed de traducciones, conmutador. *Listo cuando:* una búsqueda en las plantillas no encuentra cadenas visibles fuera de `t()`, cada página en inglés y su par en español tienen `hreflang` recíproco, y ninguna URL en español cambió.
4. **SEO.** Metadatos, JSON-LD, sitemap, feed, redirecciones, caché. *Listo cuando:* el JSON-LD de portada, artículo y producto es válido, las redirecciones sembradas responden 301 y Lighthouse móvil da ≥ 95 en rendimiento, SEO y accesibilidad.
5. **Tienda y pagos.** Carrito, pedido, adaptadores, webhooks, descargas, correos, mi cuenta, tarea programada. *Listo cuando:* pasan las pruebas de firmas e idempotencia y una compra simulada en sandbox de cada una de las tres pasarelas termina en correo con descarga funcional en el idioma del pedido, y el servidor rechaza PayPal en un pedido en español y Mercado Pago o Wompi en uno en inglés.
6. **Herramientas, búsqueda y suscripción.** *Listo cuando:* las tres herramientas funcionan sin red, pasan las pruebas de número a letras y el buscador responde en menos de 150 ms en local.
7. **Panel.** *Listo cuando:* se puede editar un artículo, crear un producto con archivo y reenviar un pedido.
8. **Entrega.** `README.md` (instalación y operación), `deploy/CHECKLIST.md` y `PENDIENTES.md`.

`deploy/CHECKLIST.md` debe incluir, en este orden: copiar los 12 archivos de `woocommerce_uploads` y los de S3 a `storage/downloads/` **antes** de apagar WordPress; exportar pedidos y clientes de WooCommerce si se quiere dar acceso a compradores antiguos (no vienen en los XML); credenciales de producción y URLs de webhook registradas en las tres pasarelas (PayPal exige cuenta Business); SMTP con SPF y DKIM; prueba completa en un subdominio con `noindex`; cambio de dominio; envío del sitemap en Search Console; revisión semanal de `not_found_log` durante dos meses; conservar WordPress apagado 30 días como respaldo.

## 15. Fuera de alcance

- No crees los archivos de Excel o Word de los productos nuevos: solo sus fichas en estado "Disponible pronto".
- No escribas artículos nuevos ni reescribas los existentes, salvo los avisos indicados en la sección 6.
- No muevas las imágenes de S3 ni toques el WordPress en producción.
- No integres otras pasarelas (ni Stripe, ni Paddle, ni PayU). Solo Mercado Pago, Wompi y PayPal, cada una en su idioma.
- No añadas más idiomas ni traduzcas el contenido del Concurso Docente.
- No inventes reseñas, cifras de clientes, testimonios ni preguntas del concurso.
