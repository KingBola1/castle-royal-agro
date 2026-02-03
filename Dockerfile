# Use PHP 8.4
FROM php:8.4-apache

# Install dependencies (Keep Postgres drivers!)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install zip pdo_pgsql bcmath

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Configure Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer update --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# START COMMAND (REMOVED 'MIGRATE' TO PREVENT CRASH)
CMD apache2-foreground