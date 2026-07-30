FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

# Configure Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Fix file permissions for storage, cache, and system tmp directory
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache /tmp

EXPOSE 80

# Run migrations, clear/cache config, and start Nginx & PHP-FPM
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:clear && php artisan view:clear && nginx -g 'daemon off;' & php-fpm"]