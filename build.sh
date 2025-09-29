#!/bin/bash

echo "Building HRIS-PCO for Vercel deployment..."

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js dependencies and build assets
npm install
npm run build

# Generate optimized configuration cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link

echo "Build complete!"