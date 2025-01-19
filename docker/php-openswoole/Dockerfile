FROM openswoole/swoole:php8.3
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath sockets \
    && apt-get clean

COPY . /var/www
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000
CMD ["php", "artisan", "openswoole:start", "--port=8000"]
