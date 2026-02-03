# Use PHP 8.4 to match your local project version
FROM php:8.4-apache

# Install system dependencies (Added git to prevent dependency errors)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo_mysql bcmath

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Configure Apache to serve the public folder correctly
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
# Using 'update' ensures it adapts to the server environment without crashing
RUN composer update --no-dev --optimize-autoloader

# Set permissions for Laravel folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80