FROM php:8.3-cli
WORKDIR /app

# install php extension
RUN docker-php-ext-install pcntl

# copy app
COPY --chown=www-data:www-data . .

# install laravel dependencies
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --no-dev
RUN php artisan octane:install --server=frankenphp

# launch
EXPOSE 8000
CMD php artisan octane:start --server=frankenphp --port=8000 --host=0.0.0.0