FROM dunglas/frankenphp:php8.3

ENV SERVER_NAME=":80"

WORKDIR /app/laravel-example

COPY . /app/laravel-example

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev && \
    docker-php-ext-install zip && \
    docker-php-ext-enable zip

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader