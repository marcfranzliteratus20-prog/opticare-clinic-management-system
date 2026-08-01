FROM php:8.2-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    gnupg2 \
    ca-certificates \
    lsb-release \
    nginx \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

# Add PostgreSQL official repository
RUN curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor -o /usr/share/keyrings/postgresql.gpg

RUN echo "deb [signed-by=/usr/share/keyrings/postgresql.gpg] http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" \
> /etc/apt/sources.list.d/pgdg.list

# Install PostgreSQL 18 client
RUN apt-get update && apt-get install -y postgresql-client-18

# Clean cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY nginx.conf /etc/nginx/sites-available/default

RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["sh","-c","php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && nginx -g 'daemon off;' & php-fpm"]