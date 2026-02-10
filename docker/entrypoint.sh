#!/bin/sh
echo "Clearing Caches..."
php artisan optimize:clear

echo "Running Migrations..."
php artisan migrate --force

echo "Seeding Admin..."
php artisan db:seed --force

echo "Starting Server..."
exec "$@"
