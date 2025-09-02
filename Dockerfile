# Etapa 1: Dependencias de Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Etapa 2: Imagen de PHP
FROM php:8.2-cli

# Instalar extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

WORKDIR /var/www/html

# Copiamos el código
COPY . .

# Copiamos las dependencias de vendor
COPY --from=vendor /app/vendor ./vendor

# Exponer puerto
EXPOSE 8000

# Comando por defecto (servidor Laravel)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]