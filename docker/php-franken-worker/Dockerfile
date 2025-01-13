FROM php:8.3-cli
WORKDIR /app

# install php extension
RUN docker-php-ext-install pcntl

# copy app
COPY --chown=www-data:www-data . .

# Install extension
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev && \
    docker-php-ext-install zip && \
    docker-php-ext-enable zip

# install laravel dependencies
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --no-dev
RUN php artisan octane:install --server=frankenphp

# emergency solution
RUN sed -i '1a \nerror_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);' public/index.php

# launch
EXPOSE 8000
CMD php artisan octane:start --server=frankenphp --port=8000 --host=0.0.0.0