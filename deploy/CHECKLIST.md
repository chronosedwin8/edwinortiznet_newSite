# Lista de verificación para el lanzamiento

Sigue los pasos **en este orden**. Marca cada uno al terminarlo.

## 0. Preparar el servidor

- [ ] PHP 8.2+ con `pdo_mysql`, `curl`, `mbstring`, `intl`, `dom`, `fileinfo` y OPcache; MySQL 8; Nginx con `deploy/nginx.conf` (o Apache con `public/.htaccess`).
- [ ] Código desplegado, `composer install --no-dev --optimize-autoloader` y `.env` completo (fuera de `public/`), con `APP_ENV=production`, `APP_DEBUG=false` y una `APP_KEY` nueva.
- [ ] `php bin/console migrate`, `import:wxr`, `seed`, `admin:create`, `sitemap:build`.
- [ ] Cron de `deploy/cron.txt` instalado.
- [ ] `storage/` con permisos de escritura para el usuario de PHP y **sin** acceso web (`https://…/storage/` debe dar 404).

## 1. Archivos de los productos — antes de apagar WordPress

- [ ] Copiar los **12 archivos de `woocommerce_uploads`** y los **7 de S3** a `storage/downloads/`:
      `php bin/console downloads:fetch` (lo hace automáticamente mientras WordPress siga en línea).
- [ ] `php bin/console downloads:check` debe decir: *"Todos los productos descargables activos tienen archivo local."*
- [ ] Copiar también las imágenes y el video que solo existen en `www.edwinortiz.net/wp-content/uploads/` (lista en `PENDIENTES.md`), o reemplazarlos en el panel.

## 2. Datos de WooCommerce (opcional)

- [ ] Si quieres que los compradores antiguos entren a "Mi cuenta", exporta pedidos y clientes de WooCommerce (**no vienen en los XML**) e impórtalos a `customers`, `orders`, `order_items` y `download_grants`.

## 3. Pasarelas de pago en producción

- [ ] **Mercado Pago:** credenciales de producción (`MP_ACCESS_TOKEN`), webhook `https://www.edwinortiz.net/webhooks/mercadopago` con eventos de *Pagos*, y la clave secreta en `MP_WEBHOOK_SECRET`. `MP_MODE=production`.
- [ ] **Wompi:** llaves de producción (`WOMPI_PUBLIC_KEY`, `WOMPI_PRIVATE_KEY`), secreto de integridad (`WOMPI_INTEGRITY_SECRET`), secreto de eventos (`WOMPI_EVENTS_SECRET`) y URL de eventos `https://www.edwinortiz.net/webhooks/wompi`. `WOMPI_MODE=production`.
- [ ] **PayPal:** cuenta **Business**, app REST *Live* (`PAYPAL_CLIENT_ID`, `PAYPAL_CLIENT_SECRET`) y webhook `https://www.edwinortiz.net/webhooks/paypal` con los eventos `PAYMENT.CAPTURE.COMPLETED`, `PAYMENT.CAPTURE.DENIED`, `PAYMENT.CAPTURE.REFUNDED`, `PAYMENT.CAPTURE.REVERSED`, `PAYMENT.CAPTURE.PENDING` y `CHECKOUT.ORDER.APPROVED`; su id va en `PAYPAL_WEBHOOK_ID`. `PAYPAL_MODE=production`.
- [ ] Antes de pasar a producción, hacer **una compra en sandbox con cada pasarela** y comprobar el correo con la descarga (en español con Mercado Pago y Wompi; en inglés con PayPal).

## 4. Correo

- [ ] Dominio `edwinortiz.net` verificado en Amazon SES (us-east-1), con **SPF**, **DKIM** (y DMARC recomendado) publicados en el DNS.
- [ ] La cuenta de SES está fuera del modo sandbox, y `MAIL_FROM_ADDRESS` es una dirección del dominio verificado.
- [ ] `MAIL_DRIVER=smtp` y `php bin/console mail:test tu@correo.com` llega a la bandeja de entrada (no a spam).

## 5. Prueba completa en un subdominio con `noindex`

- [ ] Publicar en, por ejemplo, `nuevo.edwinortiz.net` con `NOINDEX=true` y `APP_URL` de ese subdominio.
- [ ] `php bin/console routes:check` → 0 errores. `php vendor/bin/phpunit` → todo en verde.
- [ ] Revisar portada, artículo, tienda, producto, pago, pedido, Mi cuenta, herramientas y panel en móvil y en escritorio.
- [ ] Probar el flujo de compra en sandbox de punta a punta y una descarga.
- [ ] Lighthouse móvil en portada, artículo, tienda y producto.

## 6. Cambio de dominio

- [ ] `APP_URL=https://www.edwinortiz.net`, `NOINDEX=false` y `php bin/console cache:clear`.
- [ ] Apuntar el DNS al servidor nuevo, emitir el certificado TLS y verificar la redirección de `http` y de `edwinortiz.net` a `https://www.edwinortiz.net`.
- [ ] Comprobar varias redirecciones antiguas (`/page/2/`, `/category/excel/`, `/?add-to-cart=380`, `/archivos-gratis/`).

## 7. Search Console

- [ ] Enviar `https://www.edwinortiz.net/sitemap.xml` en Google Search Console (y en Bing Webmaster Tools).
- [ ] Revisar el informe de páginas y de `hreflang`.

## 8. Seguimiento — dos meses

- [ ] Cada semana, revisar los 404 en *Panel → Redirecciones* (`not_found_log`) y crear las redirecciones que falten.

## 9. Respaldo

- [ ] El respaldo diario incluye la base de datos y el `.env`. Las imágenes y los archivos de producto están en S3 (`STORAGE_DISK=s3`): activa el **versionado del bucket** `blogedwinortiznet` para poder recuperar archivos borrados o reemplazados.

- [ ] Conservar el WordPress **apagado pero intacto durante 30 días** como respaldo (archivos + base de datos). No borrar nada antes de ese plazo.
