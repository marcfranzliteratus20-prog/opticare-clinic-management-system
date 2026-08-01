FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    gnupg \
    ca-certificates \
    lsb-release \
    nginx \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

# Add PostgreSQL official repository
RUN curl -fsSL https://www.postgresql.org/media/keys/ACCC4CF8.asc \
    | gpg --dearmor -o /usr/share/keyrings/postgresql.gpg

RUN echo "deb [signed-by=/usr/share/keyrings/postgresql.gpg] https://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" \
    > /etc/apt/sources.list.d/pgdg.list

# Install PostgreSQL 18 client
RUN apt-get update && apt-get install -y \
    postgresql-client-18

# Clean apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Expose port
EXPOSE 80

# Start application
CMD ["sh","-c","php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && nginx -g 'daemon off;' & php-fpm"]