# syntax=docker/dockerfile:1.7
# ---------------------------------------------------------------------------
# Penida Gili — production image for Railway (Laravel 13 + MySQL + FrankenPHP)
# ---------------------------------------------------------------------------

# 1) PHP dependencies ---------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --no-scripts --prefer-dist --ignore-platform-reqs --no-autoloader

# 2) Front-end assets (Vite + Tailwind v4) -------------------------------------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

# 3) Runtime -------------------------------------------------------------------
FROM dunglas/frankenphp:1-php8.4 AS app

RUN install-php-extensions pdo_mysql mbstring intl zip gd bcmath opcache pcntl exif \
    && apt-get update && apt-get install -y --no-install-recommends unzip default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    PHP_INI_MEMORY_LIMIT=256M \
    COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi \
    && mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache \
    && cp docker/php.ini "$PHP_INI_DIR/conf.d/zz-penida.ini" \
    && chmod +x docker/start.sh

EXPOSE 8080
CMD ["/app/docker/start.sh"]
