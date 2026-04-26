# ── Stage 1: compilar assets con Node ──────────────────────────
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ── Stage 2: imagen PHP final ───────────────────────────────────
FROM php:8.3-cli-alpine

RUN apk add --no-cache git curl zip unzip sqlite-libs sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copiar código fuente
COPY . .

# Copiar assets compilados desde stage 1
COPY --from=assets /app/public/build ./public/build

# Permisos
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && touch database/database.sqlite

RUN composer run-script post-autoload-dump 2>/dev/null || true

EXPOSE 8000

CMD touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
