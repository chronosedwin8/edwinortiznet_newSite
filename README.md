# edwinortiz.net

Sitio de Edwin Ortiz Herazo: blog, herramientas gratuitas y tienda de descargas digitales, en **español (raíz del dominio, COP)** e **inglés (`/en/`, USD)**. Reemplaza el WordPress + WooCommerce anterior conservando todas sus URLs.

- **Backend:** PHP 8.2+ sin framework (PSR-4, PSR-12, `strict_types`), MySQL 8 con PDO y sentencias preparadas.
- **Frontend:** plantillas PHP con HTML semántico, `critical.css` en línea + `main.css`, JavaScript en módulos ES sin dependencias.
- **Pagos:** Mercado Pago y Wompi (español, COP) y PayPal (inglés, USD), por REST con cURL.
- **Dependencias de Composer:** solo `phpmailer/phpmailer` y `vlucas/phpdotenv` (más `phpunit` para desarrollo).

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
- **Solo en el servidor (no están en git):** `.env`, `storage/downloads/` (archivos de producto), `public/uploads/` (biblioteca de medios), `public/cv/` (CV) y `public/wp-content/uploads/` (3 archivos que el contenido aún enlaza). Inclúyelos en el respaldo.
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
| `cache:clear` | Vacía la caché de página completa. |
| `routes:check` | Verifica que todas las URL importadas respondan 200. |
| `mail:test [correo]` | Envía un correo de prueba con la configuración actual. |
| `mail:ses-password [región]` | Deriva la contraseña SMTP de Amazon SES desde la clave secreta IAM. |

## 5. Operación diaria

- **Panel:** `https://www.edwinortiz.net/admin/`. Escritorio con ventas, pendientes, suscriptores, 404 y productos sin archivo. Desde ahí se editan artículos, productos (textos ES/EN, precios, archivos), familias, pedidos (reenviar correo, regenerar descargas, consultar la pasarela), suscriptores y lista de espera (CSV), redirecciones, secciones (introducción, preguntas frecuentes y SEO de cada hub), biblioteca de medios y ajustes.
- **Editor del panel:** texto enriquecido con limpieza al pegar desde Word/Docs, imágenes (subir, arrastrar o elegir de la biblioteca, con texto alternativo obligatorio), videos de YouTube, tablas, bloques dinámicos `{{productos:…}}` / `{{articulos:…}}` y vista de HTML. Incluye asistente SEO con vista previa de Google, borradores locales que se recuperan si se cierra el navegador, `Ctrl+S` para guardar y `Ctrl+K` para buscar en todo el panel.
- **Imágenes subidas:** se convierten a WebP (1600 y 800 px) y se guardan en `public/uploads/AAAA/MM/`. **Incluye `public/uploads/` en el respaldo diario** junto con la base de datos y `storage/downloads/`.
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

### SEO y rendimiento
- Title, descripción, canonical, `hreflang` recíproco con `x-default`, Open Graph/Twitter y JSON-LD (`Person`, `WebSite` + `SearchAction`, `Article`, `Product`/`Offer`, `BreadcrumbList`, `FAQPage`, `Course`).
- Sitemap dinámico con alternativas (sin `noindex`), feeds RSS `/feed/` y `/en/feed/`, `robots.txt`.
- Caché de página en disco, CSS crítico en línea, fuentes WOFF2 locales con respaldo de métricas ajustadas, `srcset` de los tamaños que existen en S3, `preconnect` al bucket, `content-visibility` bajo el pliegue y GA4/AdSense diferidos tras el consentimiento.

### Seguridad
- CSRF con cookie de doble envío firmada; honeypot y marca de tiempo firmada en los formularios públicos; límite de peticiones por IP en acceso, pago, suscripción, búsqueda y contacto.
- CSP con hash para el único script en línea, HSTS en producción, `X-Content-Type-Options`, `Referrer-Policy` y `Permissions-Policy`.
- El HTML de artículos y productos pasa por una lista blanca (importador y panel). Las plantillas escapan con `e()`.
- Panel: Argon2id, bloqueo tras 5 intentos fallidos y cookies `HttpOnly` + `SameSite=Lax` (+ `Secure` en HTTPS).
- Los registros (`storage/logs`) omiten datos sensibles. Los errores detallados solo se muestran con `APP_DEBUG=true`.

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
