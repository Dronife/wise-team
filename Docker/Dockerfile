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

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    opcache \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm i
RUN npm run dev

COPY Docker/entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000

CMD ["php-fpm"]
