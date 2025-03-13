#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/usr/src

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
