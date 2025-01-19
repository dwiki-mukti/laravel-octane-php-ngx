### ERROR ###
FROM php:8.3-cli

RUN docker-php-ext-install pcntl sockets

RUN apt-get update && apt-get install git -y

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . /app
RUN chown -R www-data:www-data /app
RUN php artisan octane:install --server=roadrunner

CMD php artisan octane:start --server=roadrunner --port=8000 --host=0.0.0.0