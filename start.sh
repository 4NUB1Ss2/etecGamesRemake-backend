#!/bin/bash

echo "==> Copying .env..."
cp .env.example .env

echo "==> Generating app key..."
php artisan key:generate

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Running seeders..."
php artisan db:seed --force

echo "==> Caching config..."
php artisan config:cache

echo "==> Starting PHP-FPM..."
php-fpm -D

echo "==> Starting Nginx..."
nginx -g "daemon off;"
