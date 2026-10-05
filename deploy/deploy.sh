#!/bin/bash
# Despliegue en producción (CloudPanel, usuario del sitio "edwinortiz", PHP 8.4).
# Uso desde el servidor:  sudo -u edwinortiz -H bash /home/edwinortiz/htdocs/www.edwinortiz.net/deploy/deploy.sh
set -euo pipefail
APP=/home/edwinortiz/htdocs/www.edwinortiz.net
PHP=php8.4
cd "$APP"

echo "→ Código (rama main)"
git fetch --quiet origin main
git reset --quiet --hard origin/main

echo "→ Dependencias"
$PHP /usr/local/bin/composer install --quiet --no-dev --optimize-autoloader --no-interaction 2>/dev/null

echo "→ Migraciones"
$PHP bin/console migrate

echo "→ Caché y sitemap"
$PHP bin/console cache:clear
$PHP bin/console sitemap:build

echo "→ Comprobación de rutas"
$PHP bin/console routes:check | tail -1
echo "Despliegue terminado: $(git log -1 --format='%h %s')"
