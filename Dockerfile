# Use official PHP image
FROM php:7.4-apache

# Install any dependencies (if needed)
RUN docker-php-ext-install mysqli

# Copy PHP application files into container
COPY ./src /var/www/html/

# Copy php.ini settings
COPY php.ini /usr/local/etc/php/

# Expose port 80 for Apache
EXPOSE 80
