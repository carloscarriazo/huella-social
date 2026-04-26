FROM php:8.3-cli

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Dependencias Node y build
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# Permisos de storage
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && touch database/database.sqlite

# Post-install scripts
RUN composer run-script post-autoload-dump 2>/dev/null || true

EXPOSE 8000

CMD touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
