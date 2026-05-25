FROM node:24-alpine AS assets
WORKDIR /app
COPY src/package*.json ./
RUN npm ci --silent
COPY src/vite.config.js ./
COPY src/resources ./resources
COPY src/public ./public
RUN npm run build

FROM php:8.5-fpm AS app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/zzz-laravel.conf /usr/local/etc/php-fpm.d/zzz-laravel.conf
COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html

COPY src/ .
RUN mkdir -p bootstrap/cache storage/framework/views storage/framework/cache/data storage/framework/sessions storage/framework/testing \
    && composer install --no-dev --optimize-autoloader --no-interaction --quiet

COPY --from=assets /app/public/build ./public/build

ENTRYPOINT ["/entrypoint.sh"]

FROM nginx:alpine AS nginx-server
COPY src/public /var/www/html/public
COPY --from=assets /app/public/build /var/www/html/public/build
