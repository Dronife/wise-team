FROM php:8.4-fpm

FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    bash \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    zlib1g-dev \
    libonig-dev \
    curl \
    libpq-dev

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    opcache \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ../ .

RUN chown -R www-data:www-data /var/www/html

RUN composer install --no-interaction --no-progress --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
