# Use official PHP image
FROM php:7.4-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy custom php.ini settings
COPY php.ini /usr/local/etc/php/

# Copy application files into container
COPY ./src /var/www/html/

# Expose the Apache port
EXPOSE 80
