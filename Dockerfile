# Etapa 1: Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Etapa 2: PHP
FROM php:8.2-fpm

# Extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/html

# Copiar código
COPY . .

# Copiar vendor desde la etapa de composer
COPY --from=vendor /app/vendor ./vendor

# Exponer puerto
EXPOSE 8000

# Servidor de desarrollo Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]