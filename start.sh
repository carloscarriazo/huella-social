#!/bin/bash
set -e

# Crear BD SQLite si no existe
touch database/database.sqlite

# Limpiar caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Storage link
php artisan storage:link 2>/dev/null || true

# Migraciones
php artisan migrate --force

# Iniciar servidor
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
