# Etapa 1: Composer
FROM composer:2 AS vendor
WORKDIR /app
# Copiar solo archivos de dependencias primero
COPY composer.json composer.lock ./
# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-scripts
# Copiar el resto del código
COPY . .
# Ejecutar scripts post-install
RUN composer run-script post-autoload-dump

# Etapa 2: PHP
FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        gd

WORKDIR /var/www/html

# Copiar código
COPY . .

# Copiar vendor desde la etapa de composer
COPY --from=vendor /app/vendor ./vendor

# Exponer puerto
EXPOSE 8000

# Servidor de desarrollo Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]