FROM php:8.2-fpm

# Install system dependencies (Nginx ay ginawang lowercase)
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

EXPOSE 80

# Auto run database migration & start servers
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && nginx -g 'daemon off;' & php-fpm"]