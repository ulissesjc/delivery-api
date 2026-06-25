FROM php:8.2-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libpq-dev \
    zip \
    unzip \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões do PHP
RUN docker-php-ext-install pdo pdo_pgsql zip gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto
COPY . .

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
