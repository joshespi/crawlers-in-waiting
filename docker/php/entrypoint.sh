#!/bin/bash
set -e

cd /var/www/html

mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/framework/testing bootstrap/cache

echo "[deploy] composer install"
composer install --no-dev --optimize-autoloader --no-interaction --quiet

echo "[deploy] migrate"
php artisan migrate --force

echo "[deploy] npm build"
npm install --silent && npm run build --silent

echo "[deploy] optimize:clear"
php artisan optimize:clear

echo "[deploy] optimize"
php artisan optimize

echo "[deploy] view:cache"
php artisan view:cache

echo "[deploy] starting php-fpm"
exec php-fpm
