#!/bin/bash
set -e

# Wait for database to be ready
until nc -z -v -w30 db 3306
do
  echo "Waiting for database connection..."
  # wait for 5 seconds before check again
  sleep 5
done

# Run migrations
php artisan migrate:fresh --seed

# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Start PHP-FPM
php-fpm