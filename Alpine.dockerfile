FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Install dependencies
RUN apk add --no-cache \
    zip unzip git curl libpng-dev libjpeg-turbo-dev freetype-dev \
    oniguruma-dev libxml2-dev bash supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Migration to databae
RUN php artisan migrate

CMD ["php-fpm"]
