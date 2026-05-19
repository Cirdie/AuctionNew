FROM php:8.2-fpm

# System deps
RUN apt-get update && apt-get install -y git unzip curl libpng-dev libonig-dev libxml2-dev zip nodejs npm

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

WORKDIR /var/www/html

# Copy only composer files first to cache dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Copy rest of the app
COPY . .

# Node/Vite build
RUN npm install
RUN npm run build

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
